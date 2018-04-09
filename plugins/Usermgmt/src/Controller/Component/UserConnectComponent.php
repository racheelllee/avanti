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
use Abraham\TwitterOAuth\TwitterOAuth;

class UserConnectComponent extends Component {
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
	public function facebook_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'facebook'.DS.'src'.DS.'Facebook'.DS.'autoload.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/fb';
		}
		$fb = new \Facebook\Facebook([
				'app_id' => FB_APP_ID,
				'app_secret' => FB_SECRET,
				'default_graph_version' => 'v2.2'
			]);
		$helper = $fb->getRedirectLoginHelper();
		$fbData = [];
		if(isset($_GET['error'])) {
			$fbData['error'] = $_GET['error_description'];
		} else if(isset($_GET['code'])) {
			try {
				$accessToken = $helper->getAccessToken();
				if($accessToken) {
					$_SESSION['facebook_access_token'] = (string) $accessToken;
					$fb->setDefaultAccessToken($accessToken);
					$oAuth2Client = $fb->getOAuth2Client();
					$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
					$response = $fb->get('/me?fields=id,first_name,last_name,name,email,gender');
					$fbData = $response->getDecodedBody();
					if(!isset($fbData['location'])) {
						$fbData['location'] = '';
					}
					$fbData['picture'] = 'http://graph.facebook.com/'.$fbData['id'].'/picture?type=large';
					$fbData['logoutURL'] = $helper->getLogoutUrl($accessToken, SITE_URL);
					$fbData['access_token'] = (string) $longLivedAccessToken;
				}
			} catch(FacebookRequestException $ex) {
				$fbData['error'] = "Exception occured, code: ".$ex->getCode()." with message: ".$ex->getMessage();
			} catch(\Exception $ex) {
				$fbData['error'] = "Exception occured, with message: ".$ex->getMessage();
			}
		} else {
			$permissions = array_map('trim', explode(',', FB_SCOPE));
			$fbData['redirectURL'] = $helper->getLoginUrl($redirectUrl, $permissions)."&display=popup";
		}
		return $fbData;
	}
	public function twitter_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'twitter'.DS.'autoload.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/twt';
		}

		$twtData = [];
		if(!empty($_GET['oauth_verifier']) && !empty($_GET['oauth_token'])) {
			$request_token = [];
			$request_token['oauth_token'] = $_SESSION['oauth_token'];
			$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
			if($request_token['oauth_token'] === $_GET['oauth_token']) {
				$connection = new TwitterOAuth(TWT_APP_ID, TWT_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
				$access_token = $connection->oauth('oauth/access_token', ['oauth_verifier'=>$_GET['oauth_verifier']]);

				$connection = new TwitterOAuth(TWT_APP_ID, TWT_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
				$user = $connection->get('account/verify_credentials');
				if(!isset($user->errors)) {
					$twtData = json_decode(json_encode($user),TRUE);
					$name = explode(' ', $twtData['name']);
					$twtData['first_name'] = $name[0];
					$twtData['last_name'] = '';
					if(isset($name[2])) {
						unset($name[0]);
						$twtData['last_name'] = implode(' ', $name);
					} else if(isset($name[1])) {
						$twtData['last_name'] = $name[1];
					}
					if(!isset($twtData['gender'])) {
						$twtData['gender'] = '';
					}
					if(!isset($twtData['location'])) {
						$twtData['location'] = '';
					}
					$twtData['username'] = $twtData['screen_name'];
					$twtData['picture'] = $twtData['profile_image_url'];
					$twtData['access_token'] = $access_token['oauth_token'];
					$twtData['access_secret'] = $access_token['oauth_token_secret'];
				} else {
					$twtData['error'] = $user->errors[0]->message;
				}
			} else {
				$twtData['error'] = 'Oauth token mis-matched';
			}
		} else if(!isset($_GET['denied'])) {
			$connection = new TwitterOAuth(TWT_APP_ID, TWT_SECRET);
			$request_token = $connection->oauth('oauth/request_token', ['oauth_callback'=>$redirectUrl]);
			$_SESSION['oauth_token'] = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			$twtData['redirectURL'] = $connection->url('oauth/authorize', ['oauth_token'=>$request_token['oauth_token']]);
		} else if(isset($_GET['denied'])) {
			$twtData['error'] = 'User denied authorisation';
		}
		return $twtData;
	}
	public function linkedin_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'linkedin'.DS.'src'.DS.'LinkedIn'.DS.'Client.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/ldn';
		}
		$client = new \Client(LDN_API_KEY, LDN_SECRET_KEY);

		$ldnData = [];
		if(isset($_GET['error'])) {
			$ldnData['error'] = $_GET['error_description'];
		} else if(isset($_GET['code'])) {
			$access_token = $client->fetchAccessToken($_GET['code'], $redirectUrl);
			$userData = $client->fetch('/v1/people/~:(id,first-name,last-name,picture-url,email-address)');
			if(!empty($userData['emailAddress']) && !empty($userData['id'])) {
				$ldnData['id'] = $userData['id'];
				$ldnData['email'] = $userData['emailAddress'];
				$ldnData['first_name'] = $userData['firstName'];
				$ldnData['last_name'] = $userData['lastName'];
				$ldnData['name'] = $userData['firstName'].' '.$userData['lastName'];
				$ldnData['gender'] = (!empty($userData['gender'])) ? $userData['gender'] : '';
				$ldnData['picture'] = (!empty($userData['pictureUrl'])) ? $userData['pictureUrl'] : '';
				$ldnData['location'] = '';
				$ldnData['access_token'] = $access_token['access_token'];
			}
		} else {
			$ldnData['redirectURL'] = $client->getAuthorizationUrl($redirectUrl);
		}
		return $ldnData;
	}
	public function foursquare_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'foursquare'.DS.'src'.DS.'FoursquareApi.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/fs';
		}
		$foursquare = new \FoursquareAPI(FS_CLIENT_ID, FS_CLIENT_SECRET);

		$fsData = [];
		if(isset($_GET['error'])) {
			$fsData['error'] = 'User denied permission';
		} else if(isset($_GET['code'])) {
			$auth_token = $foursquare->GetToken($_GET['code'], $redirectUrl);
			$foursquare->SetAccessToken($auth_token);
			$response = $foursquare->GetPrivate('/users/self');
			$userData = json_decode($response, true);
			if(!empty($userData['response']['user']) && !empty($userData['response']['user']['id'])) {
				$fsData['id'] = $userData['response']['user']['id'];
				$fsData['email'] = $userData['response']['user']['contact']['email'];
				$fsData['first_name'] = $userData['response']['user']['firstName'];
				$fsData['last_name'] = $userData['response']['user']['lastName'];
				$fsData['name'] = $userData['response']['user']['firstName'].' '.$userData['response']['user']['lastName'];
				$fsData['gender'] = (!empty($userData['response']['user']['gender'])) ? $userData['response']['user']['gender'] : '';
				$fsData['picture'] = (!empty($userData['response']['user']['photo'])) ? $userData['response']['user']['photo']['prefix'].'original'.$userData['response']['user']['photo']['suffix'] : '';
				$fsData['location'] = '';
				$fsData['access_token'] = $auth_token;
			}
		} else {
			$fsData['redirectURL'] = $foursquare->AuthenticationLink($redirectUrl);
		}
		return $fsData;
	}
	public function gmail_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'google'.DS.'src'.DS.'Google'.DS.'autoload.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/gmail';
		}
		$client = new \Google_Client();
		$client->setClientId(GMAIL_CLIENT_ID);
		$client->setClientSecret(GMAIL_CLIENT_SECRET);
		$client->setRedirectUri($redirectUrl);
		$client->setDeveloperKey(GMAIL_API_KEY);
		$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email'));
		$objOAuthService = new \Google_Service_Oauth2($client);

		$gmailData = [];
		if(isset($_GET['error'])) {
			$gmailData['error'] = 'User denied permission';
		} else if(isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
		}
		if($client->getAccessToken()) {
			$userData = $objOAuthService->userinfo->get();
			if(!empty($userData) && $userData->verifiedEmail) {
				$gmailData['email'] = $userData->email;
				$gmailData['first_name'] = $userData->givenName;
				$gmailData['last_name'] = $userData->familyName;
				$gmailData['name'] = $userData->name;
				$gmailData['gender'] = (!empty($userData->gender)) ? $userData->gender : '';
				$gmailData['picture'] = (!empty($userData->picture)) ? $userData->picture : '';
				$gmailData['location'] = '';
				if(empty($gmailData['first_name'])) {
					$emailArr = explode('@', $gmailData['email']);
					$gmailData['first_name'] = $emailArr[0];
				}
				if(empty($gmailData['name'])) {
					$emailArr = explode('@', $gmailData['email']);
					$gmailData['name'] = $emailArr[0];
				}
			}
		} else {
			if(empty($gmailData['error'])) {
				$gmailData['redirectURL'] = $client->createAuthUrl();
			}
		}
		return $gmailData;
	}
	public function yahoo_connect($redirectUrl=null) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'openid'.DS.'Lightopenid.php');
		if(empty($redirectUrl)) {
			$redirectUrl = SITE_URL.'login/yahoo';
		}
		$openid = new \Lightopenid($_SERVER['SERVER_NAME']);

		$yahooData = [];
		if($openid->mode == 'cancel') {
			$yahooData['error'] = 'You have cancelled authentication';
		} else if(isset($_GET['openid_mode'])) {
			$ret = $openid->getAttributes();
			if(isset($ret['contact/email']) && $openid->validate()) {
				$yahooData['email'] = $ret['contact/email'];
				$yahooData['name'] = $ret['namePerson'];
				if($ret['person/gender'] == 'F') {
					$yahooData['gender'] = 'female';
				} else {
					$yahooData['gender'] = 'male';
				}
				$name = explode(' ', $ret['namePerson']);
				$yahooData['first_name'] = $name[0];
				$yahooData['last_name'] = '';
				if(isset($name[2])) {
					unset($name[0]);
					$yahooData['last_name'] = implode(' ', $name);
				} else if(isset($name[1])) {
					$yahooData['last_name'] = $name[1];
				}
				$yahooData['picture'] = '';
				$yahooData['location'] = '';
			}
		} else {
			$openid->identity = "http://me.yahoo.com/";
			$openid->required = ['contact/email', 'namePerson', 'person/gender'];
			$openid->returnUrl = $redirectUrl;
			$yahooData['redirectURL'] = $openid->authUrl();
		}
		return $yahooData;
	}
}