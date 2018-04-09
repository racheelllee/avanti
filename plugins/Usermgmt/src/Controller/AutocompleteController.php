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
namespace Usermgmt\Controller;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;
use Cake\Utility\Security;

class AutocompleteController extends UsermgmtAppController {
	/**
	 * Called before the controller action. You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
	}
	/**
	 * It displays search suggestions on search filter form
	 *
	 * @access public
	 * @param string $model model name to identify table
	 * @param string $field model field name to identify table column name
	 * @return String
	 */
	public function fetch($model, $field) {
		$resultToPrint = [];
		if($this->request->is('ajax')) {
			$key1 = Security::salt();
			$fieldDecrypt = base64_decode($field);
			if(strpos($fieldDecrypt, '.') !== false) {
				$fieldDecrypt = explode('.', $fieldDecrypt);
				$field = array_shift($fieldDecrypt);
				$key2 = implode('.', $fieldDecrypt);
				if($key1 === $key2) {
					$results = [];
					if(isset($_GET['term'])) {
						$query = trim($_GET['term']);
						$cond = [];
						$queryParts = explode(' ', $query);
						foreach($queryParts as $queryPart) {
							$queryPart = trim($queryPart);
							if(strlen($queryPart)) {
								$cond['OR'][] = $model."." . $field . " LIKE '%" . $queryPart . "%'";
							}
						}
						if(!empty($cond)) {
							$this->loadModel($model);
							$results = $this->$model->find()
								->select([$model.".".$field])->distinct([$model.".".$field])
								->where($cond)
								->hydrate(false)
								->toArray();
						}
					}
					foreach($results as $res) {
						$resultToPrint[] = ['name'=>(string)$res[$field]];
					}
				}
			}
		}
		echo json_encode($resultToPrint);exit;
	}
}