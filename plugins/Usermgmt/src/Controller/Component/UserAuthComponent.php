<?php
/* Cakephp 3.x User Management Premium Version (a product of Ektanjali Softwares Pvt Ltd)
Website- http://ektanjali.com
Plugin Demo- http://cakephp3-user-management.ektanjali.com/
Author- Chetan Varshney (The Director of Ektanjali Softwares Pvt Ltd)
Plugin Copyright No- 11498/2012-CO/L

UMPremium is a copyrighted work of authorship. Chetan Varshney retains ownership of the product and any copies of it, regardless of the form in which the copies may exist. This license is not a sale of the original product or any copies.

By installing and using UMPremium on your server, you agree to the following terms and conditions. Such agreement is either on your own behalf or on behalf of any corporate entity which employs you or which you represent ('Corporate Licensee'). In this Agreement, 'you' includes both the reader and any Corporate Licensee and Chetan Varshney.

The Product is licensed only to you. You may not rent, lease, sublicense, sell, assign, pledge, transfer or otherwise dispose of the Product in any form, on a temporary or permanent basis, without the prior written consent of Chetan Varshney.

The Product source code may be altered (at your risk)

All Product copyright notices within the scripts must remain unchanged (and visible).

If any of the terms of this Agreement are violated, Chetan Varshney reserves the right to action against you.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Product.

THE PRODUCT IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE PRODUCT OR THE USE OR OTHER DEALINGS IN THE PRODUCT. */
?>
<?php
namespace Usermgmt\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\BasicAuthenticate;
use Cake\Utility\Security;

class UserAuthComponent extends Component {
	/**
	 * This component uses following components
	 *
	 * @var array
	 */
	var $components = ['Cookie', 'Usermgmt.Ssl'];

	public $controller;
	public $request;
	public $response;
	public $session;
	public $registry;

	public function __construct(ComponentRegistry $registry, array $config = []) {
		parent::__construct($registry, $config);
		$this->registry = $registry;
		$controller = $registry->getController();
		$this->controller = $controller;
		$this->request = $controller->request;
		$this->response = $controller->response;
		$this->session = $controller->request->session();
	}

	function beforeFilter() {
		UsermgmtInIt();
		if(isset($this->controller->Auth)) {
			$this->controller->Auth->config('authenticate', [
				'Usermgmt.Permission'
			]);
			$this->controller->Auth->config('authorize', [
				'Usermgmt.Permission'
			]);
			$this->controller->Auth->config('loginAction', [
				'controller'=>'Users',
				'action'=>'login',
				'plugin'=>'Usermgmt',
				'prefix'=>false
			]);
			$this->controller->Auth->config('loginRedirect', LOGIN_REDIRECT_URL);
			$this->controller->Auth->config('logoutRedirect', LOGOUT_REDIRECT_URL);
		} else {
			trigger_error(__('Cakephp Auth component not loaded, please load in AppController.'));
			exit;
		}
		if($this->request->session()->check('Auth.SocialLogin') && empty($this->request['requested'])) {
			$this->request->session()->delete('Auth.SocialLogin');
			$this->controller->redirect(['plugin'=>'Usermgmt', 'controller'=>'Users', 'action'=>'changePassword']);
		}
		$this->checkForCookieLogin();
		if(!defined('CRON_DISPATCHER')) {
			$this->updateActivity();
		}
	}
	function beforeRender() {
		if(!$this->request->is('ajax')) {
			if(defined('USE_HTTPS') && USE_HTTPS) {
				$this->Ssl->force();
			} else {
				if(defined('HTTPS_URLS')) {
					$httpsUrls = HTTPS_URLS;
					if(!empty($httpsUrls)) {
						$httpsUrls = array_map('trim', explode(',', strtolower($httpsUrls)));
						$httpsUrls = array_map(function($v) { return rtrim(ltrim($v, '/'), '/'); }, $httpsUrls);
						$actionUrl1 = strtolower($this->request['controller'].'/'.$this->request['action']);
						$actionUrl2 = strtolower($this->request['controller'].'/*');
						if(!empty($this->request['plugin'])) {
							$actionUrl1 = strtolower($this->request['plugin']).'/'.$actionUrl1;
							$actionUrl2 = strtolower($this->request['plugin']).'/'.$actionUrl2;
						}
						if(in_array($actionUrl1, $httpsUrls) || in_array($actionUrl2, $httpsUrls)) {
							if(!in_array($this->request->url, ['login/fb', 'login/twt', 'login/gmail', 'login/ldn', 'login/fs', 'login/yahoo'])) {
								$this->Ssl->force();
							}
						} else {
							$this->Ssl->unforce();
						}
					}
				}
			}
		}
		$userId = $this->getUserId();
		$user = [];
		if($userId) {
			$userModel = TableRegistry::get('Usermgmt.Users');
			$user = $userModel->getUserById($userId);
			if(empty($user['id'])) {
				$this->controller->redirect(['plugin'=>'Usermgmt', 'controller'=>'Users', 'action'=>'logout']);
			}
		}
		$this->controller->set('var', $user);
	}
	/**
	 * Used to maintain login session of user
	 *
	 * @access public
	 * @param mixed $type possible values 'cookie', user array
	 * @param string $credentials credentials of cookie, default null
	 * @return array
	 */
	public function login($type, $credentials = null) {
		$userModel = TableRegistry::get('Usermgmt.Users');
		if(is_string($type) && $type == 'cookie') {
			$user = $userModel->authsomeLogin($type, $credentials);
		} else if(is_array($type)) {
			$user = $type;
		}
		if(!empty($user)) {
			if(isset($user['user_group_id'])) {
				$userGroupModel = TableRegistry::get('Usermgmt.UserGroups');
				$groups = $userGroupModel->getGroupsByIds($user['user_group_id'], true);
				$user['user_group']['id_name'] = $groups;
				$user['user_group']['name'] = implode(', ', $groups);
			}
			$loginAllowed = true;
			if(isset($user['id'])) {
				$gids = [];
				if(isset($user['user_group']['id_name'])) {
					$gids = $user['user_group']['id_name'];
				}
				$loginAllowed = $this->isAllowedLogin($user['id'], $gids);
			}
			if($loginAllowed) {
				if(isset($user['id'])) {
					$userEntity = $userModel->newEntity();
					$userEntity['id'] = $user['id'];
					$userEntity['last_login'] = date('Y-m-d H:i:s');
					$userModel->save($userEntity, ['validate'=>false]);
				}
				$this->controller->Auth->setUser($user);
				$this->session->delete('Auth.badLoginCount');
				return $user;
			} else {
				$this->controller->Flash->info(__('Your account is currently logged in on another computer.'));
				$this->controller->redirect(['plugin'=>'Usermgmt', 'controller'=>'Users', 'action'=>'login']);
			}
		}
		return false;
	}
	private function checkForCookieLogin() {
		if(!$this->isLogged()) {
			$token = $this->Cookie->read(LOGIN_COOKIE_NAME);
			if(!empty($token)) {
				$tokenParts = split(':', $token);
				$duration = array_pop($tokenParts);
				$token = join(':', $tokenParts);
				$user = $this->login('cookie', compact('token', 'duration'));
				$this->Cookie->config('path', '/');
				$this->Cookie->delete(LOGIN_COOKIE_NAME);
				if($user) {
					$this->persist($duration);
				}
			}
		}
	}
	/**
	 * Used to delete user session and cookie
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->deleteActivity($this->getUserId());
		$this->Cookie->config('path', '/');
		$this->Cookie->delete(LOGIN_COOKIE_NAME);
		$this->clearSession();
		return $this->controller->redirect($this->controller->Auth->logout());
	}
	/**
	 * Used to delete social network session
	 *
	 * @access public
	 * @return void
	 */
	private function clearSession() {
		$this->session->delete("fb_".FB_APP_ID."_code");
		$this->session->delete("fb_".FB_APP_ID."_access_token");
		$this->session->delete("fb_".FB_APP_ID."_user_id");
		$this->session->delete("ot");
		$this->session->delete("ots");
		$this->session->delete("oauth.linkedin");
		$this->session->delete("fs_access_token");
		$this->session->delete("G_token");
	}
	/**
	 * Used to persist cookie for remember me functionality
	 *
	 * @access public
	 * @param string $duration duration of cookie life time on user's machine
	 * @return boolean
	 */
	public function persist($duration = '2 weeks') {
		$userId = $this->getUserId();
		if(!empty($userId)) {
			$userModel = TableRegistry::get('Usermgmt.Users');
			$token = $userModel->authsomePersist($userId, $duration);
			$token = $token.':'.$duration;
			$this->Cookie->config('path', '/');
			$this->Cookie->config([
				'expires'=>'+ '.$duration,
				'httpOnly'=>true
			]);
			$this->Cookie->write(LOGIN_COOKIE_NAME, $token);
		}
	}
	/**
	 * Used to make password in hash format
	 *
	 * @access public
	 * @param string $password password of user
	 * @return hash
	 */
	public function makeHashedPassword($password) {
		return (new DefaultPasswordHasher)->hash($password);
	}
	public function checkPassword($password, $dbpassword, $options=[]) {
		if(!isset($options['passwordHasher'])) {
			$options['passwordHasher'] = 'Default';
		}
		$passwordHasher = [];
		if(!empty($options)) {
			if(strtolower($options['passwordHasher']) == 'ump2' && !empty($options['salt'])) {
				//cakephp 2.x old password compatibility
				if(strlen($options['salt']) == 32) {
					//cakephp 2.x user management plugin version upto 2.2.1 version
					return $dbpassword === md5(md5($password).md5($options['salt']));
				} else {
					//cakephp 2.x user management plugin version greater than 2.2.1 version
					$options['salt'] = base64_decode($options['salt']).Security::salt();
					return $dbpassword === Security::hash($password, 'sha256', $options['salt']);
				}
			} else {
				//cakephp 2.x old password compatibility (which are not using our cakephp 2.x user management plugin)
				$passwordHasher['passwordHasher']['className'] = $options['passwordHasher'];
			}
			if(isset($options['hashType'])) {
				$passwordHasher['passwordHasher']['hashType'] = $options['hashType'];
			}
		}
		$hasher = (new BasicAuthenticate($this->registry, $passwordHasher))->passwordHasher();
		return $hasher->check($password, $dbpassword);
	}
	/**
	 * Used to generate random password
	 *
	 * @access public
	 * @return string
	 */
	public function generatePassword() {
		return substr(md5(mt_rand(0, 32) . time()), 0,7);
	}
	/**
	 * Used to check whether user is logged in or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isLogged() {
		if($this->getUserId()) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get user from session
	 *
	 * @access public
	 * @return array
	 */
	public function getUser() {
		return $this->session->read('Auth');
	}
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getUserId() {
		return $this->session->read('Auth.User.id');
	}
	/**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getGroupId() {
		return $this->session->read('Auth.User.user_group_id');
	}
	/**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function getGroupName() {
		return $this->session->read('Auth.User.user_group.name');
	}
	/**
	 * Used to check is admin logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isAdmin() {
		$idName = $this->session->read('Auth.User.user_group.id_name');
		if(isset($idName[ADMIN_GROUP_ID])) {
			return true;
		}
		return false;
	}
	/**
	 * Used to check is guest logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isGuest() {
		$idName = $this->session->read('Auth.User.user_group.id_name');
		if(empty($idName)) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get last login Time
	 *
	 * @access public
	 * @return string
	 */
	public function getLastLoginTime($format=null) {
		$last_login = $this->session->read('Auth.User.last_login');
		if(!empty($last_login)) {
			if(empty($format)) {
				$format = 'd-M-Y h:i A';
			}
			return $last_login->format($format);
		}
		return '';
	}
	/**
	 * Used to update update activities of user or a guest
	 *
	 * @access private
	 * @return void
	 */
	private function updateActivity() {
		$actionUrl = Inflector::camelize($this->request['controller']).'/'.$this->request['action'];
		if(!in_array($actionUrl, ['Users/login', 'Users/logout']) && !isset($this->request['requested'])) {
			$useragent = $this->getUserActivityCookie();
			$user_id = $this->getUserId();

			$activityModel = TableRegistry::get('Usermgmt.UserActivities');
			$res = $activityModel->findByUseragent($useragent)->first();
			if(!empty($res['logout']) && !empty($res['user_id']) && $res['user_id'] == $user_id) {
				$this->controller->redirect(['plugin'=>'Usermgmt', 'controller'=>'Users', 'action'=>'logout']);
			}
			if(!empty($res['deleted']) && !empty($res['user_id']) && $res['user_id'] == $user_id) {
				$this->controller->redirect(['plugin'=>'Usermgmt', 'controller'=>'Users', 'action'=>'logout']);
			}
			$activity = [];
			if(!empty($res['id'])) {
				$activity['UserActivities']['id'] = $res['id'];
			}
			$activity['UserActivities']['useragent'] = $useragent;
			$activity['UserActivities']['user_id'] = $user_id;
			$activity['UserActivities']['last_action'] = time();
			$activity['UserActivities']['last_url'] = $this->request->here;
			$activity['UserActivities']['user_browser'] = $this->request->header('User-Agent');
			$activity['UserActivities']['ip_address'] = $this->request->clientIp();

			$userActivityEntity = TableRegistry::get('Usermgmt.UserActivities')->newEntity($activity);
			$activityModel->save($userActivityEntity, ['validate'=>false]);
		}
	}
	/**
	 * Used to delete activity after logout
	 *
	 * @access public
	 * @return void
	 */
	public function deleteActivity($user_id) {
		if(!empty($user_id)) {
			$activityModel = TableRegistry::get('Usermgmt.UserActivities');
			$useragent = $this->getUserActivityCookie();
			$activityModel->deleteAll(['user_id'=>$user_id, 'useragent'=>$useragent]);
		}
	}
	function setBadLoginCount() {
		$count = 1;
		if($this->session->check('Auth.badLoginCount')) {
			$count += $this->session->read('Auth.badLoginCount');
		}
		$this->session->write('Auth.badLoginCount', $count);
	}
	function captchaOnBadLogin() {
		if($this->session->check('Auth.badLoginCount')) {
			if($this->session->read('Auth.badLoginCount') > BAD_LOGIN_ALLOW_COUNT) {
				return true;
			}
		}
		return false;
	}
	function canUseRecaptha($type=null) {
		$privatekey = PRIVATE_KEY_FROM_RECAPTCHA;
		$publickey = PUBLIC_KEY_FROM_RECAPTCHA;
		if(!empty($privatekey) && !empty($publickey)) {
			if($type == 'login') {
				if(USE_RECAPTCHA_ON_LOGIN) {
					return true;
				} else if(USE_RECAPTCHA_ON_BAD_LOGIN) {
					if($this->session->check('Auth.badLoginCount') && $this->session->read('Auth.badLoginCount') > BAD_LOGIN_ALLOW_COUNT) {
						return true;
					}
				}
			} else if($type == 'registration') {
				if(USE_RECAPTCHA_ON_REGISTRATION) {
					return true;
				}
			} else if($type == 'forgotPassword') {
				if(USE_RECAPTCHA_ON_FORGOT_PASSWORD) {
					return true;
				}
			} else if($type == 'emailVerification') {
				if(USE_RECAPTCHA_ON_EMAIL_VERIFICATION) {
					return true;
				}
			} else if($type == 'contactus') {
				if(!$this->isLogged()) {
					return true;
				}
			}
		}
		return false;
	}
	function isAllowedLogin($userId, $groupIds) {
		$allowMultipleLogin = ALLOW_USER_MULTIPLE_LOGIN;
		if(isset($groupIds[ADMIN_GROUP_ID])) {
			$allowMultipleLogin = ALLOW_ADMIN_MULTIPLE_LOGIN;
		}
		if(!$allowMultipleLogin) {
			$useragent = $this->getUserActivityCookie();
			$last_action = time() - (abs(LOGIN_IDLE_TIME) * 60);

			$activityModel = TableRegistry::get('Usermgmt.UserActivities');
			$res = $activityModel->find()
					->where(['UserActivities.user_id'=>$userId, 'UserActivities.last_action >'=>$last_action, 'UserActivities.useragent !='=>$useragent])
					->first();
			if(!empty($res)) {
				return false;
			} else {
				$activityModel->updateAll(['logout'=>1], ['user_id'=>$userId, 'useragent !='=>$useragent]);
			}
		}
		return true;
	}
	function getUserActivityCookie() {
		$useragent = $this->Cookie->read('usermgmt_user_activity');
		if(empty($useragent)) {
			$useragent = md5($this->request->header('User-Agent')).session_id();
			$this->Cookie->config('path', '/');
			$this->Cookie->config([
				'expires'=>'+ 2 months',
				'httpOnly'=>true
			]);
			$this->Cookie->write('usermgmt_user_activity', $useragent);
		}
		return $useragent;
	}
}