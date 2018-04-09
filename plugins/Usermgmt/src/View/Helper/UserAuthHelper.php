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
namespace Usermgmt\View\Helper;
use Cake\View\Helper;
use Cake\View\View;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

class UserAuthHelper extends Helper {
	public $helpers = ['Session', 'Html', 'Form'];
	public $permissions = [];
	public $view;
	public $recaptcha_script = false;

	public function __construct(View $View, array $config = []) {
		parent::__construct($View, $config);
		$this->view = $View;
		if(!defined("QRDN")) {
			define("QRDN", "12345678");
		}
		if(!defined("SITE_URL")) {
			define("SITE_URL", Router::url('/', true));
		}
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
		return $this->request->session()->read('Auth');
	}
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getUserId() {
		return $this->request->session()->read('Auth.User.id');
	}
	/**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getGroupId() {
		return $this->request->session()->read('Auth.User.user_group_id');
	}
	/**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function getGroupName() {
		return $this->request->session()->read('Auth.User.user_group.name');
	}
	/**
	 * Used to check is admin logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isAdmin() {
		$idName = $this->request->session()->read('Auth.User.user_group.id_name');
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
		$idName = $this->request->session()->read('Auth.User.user_group.id_name');
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
		$last_login = $this->request->session()->read('Auth.User.last_login');
		if(!empty($last_login)) {
			if(empty($format)) {
				$format = 'd-M-Y h:i A';
			}
			return $last_login->format($format);
		}
		return '';
	}
	public function showCaptcha($error=null) {
		$this->Form->unlockField('g-recaptcha-response');
		if(!$this->recaptcha_script) {
			$this->recaptcha_script = true;
			$this->Html->script('https://www.google.com/recaptcha/api.js', array('block'=>true));
		}
		$code = '<div class="g-recaptcha" data-sitekey="'.PUBLIC_KEY_FROM_RECAPTCHA.'"></div>';
		$errorMsg = '';
		if(!empty($error)) {
			$errorMsg = "<div class='error-message'>".$error."</div>";
		}
		return $code.$errorMsg;
	}
	public function needToCheckPermission() {
		if(!PERMISSIONS) {
			return false;
		}
		$userGroupID = $this->getGroupId();
		$userGroupIDArray = array_map('trim', explode(',', $userGroupID));

		if(in_array(ADMIN_GROUP_ID, $userGroupIDArray) && !ADMIN_PERMISSIONS) {
			return false;
		}
		return true;
	}
	public function HP($controller=null, $action='index', $plugin=null, $prefix=null) {
		if($this->needToCheckPermission()) {
			if(empty($this->permissions)) {
				$this->permissions = $this->view->requestAction('/usermgmt/UserGroupPermissions/getPermissions');
			}
			if($controller) {
				$access = Inflector::camelize($controller).'/'.$action;
				if($plugin) {
					$access = $plugin.'/'.$access;
				}
				if($prefix) {
					$access = strtolower(Inflector::camelize($prefix)).'/'.$access;
				}
				$access = strtolower($access);
				if(is_array($this->permissions) && in_array($access, $this->permissions)) {
					return true;
				}
				return false;
			} else {
				echo "Missing Argument 1";
				return false;
			}
		} else {
			return true;
		}
	}
	public function canUseRecaptha($type=null) {
		$privatekey = PRIVATE_KEY_FROM_RECAPTCHA;
		$publickey = PUBLIC_KEY_FROM_RECAPTCHA;
		if(!empty($privatekey) && !empty($publickey)) {
			if($type == 'login') {
				if(USE_RECAPTCHA_ON_LOGIN) {
					return true;
				} else if(USE_RECAPTCHA_ON_BAD_LOGIN) {
					if($this->request->session()->check('Auth.badLoginCount') && $this->request->session()->read('Auth.badLoginCount') > BAD_LOGIN_ALLOW_COUNT) {
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
}