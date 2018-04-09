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
use Cake\Core\App;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;

class ControllerListComponent extends Component {
	/**
	 * Used to get all controllers with all methods for permissions
	 *
	 * @access public
	 * @return array
	 */
	public function getControllerAndActions() {
		$controllersList = [];
		$controllerClasses = $this->getControllerClasses();
		foreach($controllerClasses as $i=>$controllerClass) {
			$controllersList[$i]['controller'] = $controllerClass['controller'];
			$controllersList[$i]['prefix'] = $controllerClass['prefix'];
			$controllersList[$i]['plugin'] = $controllerClass['plugin'];
			$controllersList[$i]['actions'] = $this->__getControllerMethods($controllerClass['controller'], $controllerClass['prefix'], $controllerClass['plugin']);
		}
		return $controllersList;
	}
	private function __getControllerMethods($controllerName, $prefix=null, $plugin=null) {
		$methods = [];
		if($prefix) {
			$prefix = str_replace('.', '\\', $prefix).'\\';
		}
		if(empty($plugin)) {
			$base = Configure::read('App.namespace');
			$controllerClassName = $base.'\Controller\\'.$prefix.$controllerName.'Controller';
		} else {
			$controllerClassName = $plugin.'\Controller\\'.$prefix.$controllerName.'Controller';
		}
		$methods = $this->getClassPublicMethods($controllerClassName);
		return $methods;
	}
	private function getClassPublicMethods($className) {
		$class = new \ReflectionClass($className);
		$methods = [];
		$ignoreList = ['beforeFilter', 'afterFilter', 'initialize', 'paginate', 'beforeRender'];
		foreach($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {



			$docCmnt = new \DocBlock($method->getDocComment());

			
			$grupo = $this->request->session()->read('Auth.User.user_group_id');

			if( $grupo != ADMIN_GROUP_ID ){

				if( !isset( $docCmnt->tags['accesslevel'] ) ){
					continue;
				
				}
			}

			if($method->class == $className && !in_array($method->name, $ignoreList)) {
				$methods[] = $method->name;
			}
		}
		return $methods;
	}
	/**
	 *  Used to get controller classes list
	 *
	 * @access public
	 * @return array
	 */
	public function getControllerClasses() {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'DocBlock.php');

		$path = APP.'Controller';
		$dir = new Folder($path);
		$controllers = $dir->findRecursive('.*Controller.php');
		$controllerClasses = [];
		$i = 0;
		foreach($controllers as $controller) {
			$pathinfo = pathinfo($controller);


			$grupo = $this->request->session()->read('Auth.User.user_group_id');

			if( $grupo != ADMIN_GROUP_ID ){
				$base = Configure::read('App.namespace');
				$controllerClassName = $base.'\Controller\\'.str_replace('Controller.php', '', $pathinfo['basename']).'Controller';
				$class = new \ReflectionClass($controllerClassName);
				$docCmnt = new \DocBlock($class->getDocComment());

				if( !isset( $docCmnt->tags['accesslevel'] ) ){
					
						continue;
					
				}
			}

			$controllerClasses[$i]['controller'] = str_replace('Controller.php', '', $pathinfo['basename']);
			$controllerClasses[$i]['prefix'] = '';
			$controllerClasses[$i]['plugin'] = '';
			$prefix = str_replace($path, '', $pathinfo['dirname']);
			if(!empty($prefix)) {
				$prefix = ltrim($prefix, DS);
				$controllerClasses[$i]['prefix'] = str_replace(DS, '.', $prefix);
			}
			$i++;
		}
		$plugins = Plugin::loaded();
		foreach($plugins as $plugin) {
			$path = Plugin::classPath($plugin).'Controller';
			$dir = new Folder($path);
			$path = $dir->path;
			$controllers = $dir->findRecursive('.*Controller.php');
			foreach($controllers as $controller) {
				$pathinfo = pathinfo($controller);

				$grupo = $this->request->session()->read('Auth.User.user_group_id');

				if( $grupo != ADMIN_GROUP_ID ){

					$controllerClassName = $plugin.'\Controller\\'.$prefix.str_replace('Controller.php', '', $pathinfo['basename']).'Controller';

					$class = new \ReflectionClass($controllerClassName);
					$docCmnt = new \DocBlock($class->getDocComment());

					if( !isset( $docCmnt->tags['accesslevel'] ) ){
						
						continue;
						
					}

				}

				$controllerClasses[$i]['controller'] = str_replace('Controller.php', '', $pathinfo['basename']);
				$controllerClasses[$i]['prefix'] = '';
				$controllerClasses[$i]['plugin'] = $plugin;
				$prefix = str_replace($path, '', $pathinfo['dirname']);
				if(!empty($prefix)) {
					$prefix = ltrim($prefix, DS);
					$controllerClasses[$i]['prefix'] = str_replace(DS, '.', $prefix);
				}
				$i++;
			}
		}
		return $controllerClasses;
	}
}