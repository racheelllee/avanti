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
use Cake\Routing\Router;

Router::scope('/', function($routes) {
	$routes->plugin('Usermgmt', function($routes) {
		$defaultRouteClass = 'InflectedRoute';
		if(in_array(Router::defaultRouteClass(), ['DashedRoute'])) {
			$defaultRouteClass = Router::defaultRouteClass();
		}
		$routes->fallbacks($defaultRouteClass);
	});
	$routes->connect('/login/*', ['controller'=>'Users', 'action'=>'login', 'plugin'=>'Usermgmt']);
	$routes->connect('/logout', ['controller'=>'Users', 'action'=>'logout', 'plugin'=>'Usermgmt']);
	$routes->connect('/forgotPassword', ['controller'=>'Users', 'action'=>'forgotPassword', 'plugin'=>'Usermgmt']);
	$routes->connect('/emailVerification', ['controller'=>'Users', 'action'=>'emailVerification', 'plugin'=>'Usermgmt']);
	$routes->connect('/activatePassword', ['controller'=>'Users', 'action'=>'activatePassword', 'plugin'=>'Usermgmt']);
	$routes->connect('/register', ['controller'=>'Users', 'action'=>'register', 'plugin'=>'Usermgmt']);
	$routes->connect('/dashboard', ['controller'=>'Users', 'action'=>'dashboard', 'plugin'=>'Usermgmt']);
	$routes->connect('/contactUs', ['controller'=>'UserContacts', 'action'=>'contactUs', 'plugin'=>'Usermgmt']);
	$routes->connect('/userVerification/*', ['controller'=>'Users', 'action'=>'userVerification', 'plugin'=>'Usermgmt']);
	$routes->connect('/accessDenied', ['controller'=>'Users', 'action'=>'accessDenied', 'plugin'=>'Usermgmt']);
	$routes->connect('/myprofile', ['controller'=>'Users', 'action'=>'myprofile', 'plugin'=>'Usermgmt']);
	$routes->connect('/editProfile', ['controller'=>'Users', 'action'=>'editProfile', 'plugin'=>'Usermgmt']);
	$routes->connect('/info/*', ['controller'=>'StaticPages', 'action'=>'preview', 'plugin'=>'Usermgmt']);
	
	$defaultRouteClass = 'InflectedRoute';
	if(in_array(Router::defaultRouteClass(), ['DashedRoute'])) {
		$defaultRouteClass = Router::defaultRouteClass();
	}
	$routes->fallbacks($defaultRouteClass);
});