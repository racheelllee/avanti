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
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

function UsermgmtInIt() {
	defineUsermgmtCache();
	$allSettings = getAllSettings();

	if(!defined("SITE_URL")) {
		if(!defined('CRON_DISPATCHER')) {
			define("SITE_URL", Router::url('/', true));
		}
	}
	if(!defined("USERMGMT_PATH")) {
		define("USERMGMT_PATH", dirname(__DIR__));
	}
	if(!defined("DEFAULT_IMAGE_PATH")) {
		define("DEFAULT_IMAGE_PATH", USERMGMT_PATH.DS."webroot".DS."img".DS."default.png");/* setting path for default image */
	}
	if(!defined("DEFAULT_IMAGE_URL")) {
		define("DEFAULT_IMAGE_URL", SITE_URL."usermgmt/img/default.png");
	}
	date_default_timezone_set((isset($allSettings['default_time_zone'])) ? $allSettings['default_time_zone']['value'] : 'America/New_York');

	foreach ($allSettings as $key=>$variable) {
		Configure::write("{$key}", $variable['value']);
		if(!defined(strtoupper($key))) {
			define(strtoupper($key), $variable['value']);
		}
	}
}
function defineUsermgmtCache() {
	$configured = Cache::configured();
	if(!in_array('UserMgmtPermissions', $configured)) {
		Cache::config('UserMgmtPermissions', [
			'className'=>'File',
			'duration'=>'+3 months',
			'path'=>CACHE,
			'prefix'=>'UserMgmt_'
		]);
	}
	if(!in_array('UserMgmtSettings', $configured)) {
		Cache::config('UserMgmtSettings', [
			'className'=>'File',
			'duration'=>'+1 day',
			'path'=>CACHE,
			'prefix'=>'UserMgmt_'
		]);
	}
}
function getAllSettings() {
	$cacheKey = 'all_settings';
	$allSettings = false;
	if(Configure::read('debug') == 0) {
		$allSettings = Cache::read($cacheKey, 'UserMgmtSettings');
	}
	if($allSettings === false) {
		$allSettings = TableRegistry::get('Usermgmt.UserSettings')->getAllUserSettings();
		Cache::write($cacheKey, $allSettings, 'UserMgmtSettings');
	}
	return $allSettings;
}