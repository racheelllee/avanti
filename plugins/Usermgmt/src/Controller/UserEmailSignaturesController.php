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

class UserEmailSignaturesController extends UsermgmtAppController {
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components = ['Usermgmt.Search'];
	/**
	 * This controller uses following helpers
	 *
	 * @var array
	 */
	public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor'];
	/**
	 * This controller uses following default pagination values
	 *
	 * @var array
	 */
	public $paginate = [
		'limit'=>25
	];
	/**
	 * This controller uses search filters in following functions for ex index, online function
	 *
	 * @var array
	 */
	public $searchFields = [
		'index'=>[
			'Usermgmt.UserEmailSignatures'=>[
				'UserEmailSignatures'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by signature',
					'condition'=>'multiple',
					'searchFields'=>['UserEmailSignatures.signature_name', 'UserEmailSignatures.signature'],
					'inputOptions'=>['style'=>'width:300px;']
				]
			]
		]
	];
	/**
	 * Called before the controller action. You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->loadModel('Usermgmt.UserEmailSignatures');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all email signatures
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$cond = [];
		$cond['UserEmailSignatures.user_id'] = $this->UserAuth->getUserId();
		$this->paginate = ['limit'=>10, 'conditions'=>$cond, 'order'=>['UserEmailSignatures.id'=>'DESC']];
		$this->Search->applySearch($cond);
		$userEmailSignatures = $this->paginate($this->UserEmailSignatures)->toArray();
		$this->set('userEmailSignatures', $userEmailSignatures);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_email_signatures');
		}
	}
	/**
	 * It is used to add a new email signature
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		$userEmailSignatureEntity = $this->UserEmailSignatures->newEntity($this->request->data, ['validate'=>'forAdd']);
		if($this->request->is('post')) {
			$errors = $userEmailSignatureEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserEmailSignatures']  = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					$userEmailSignatureEntity['user_id'] = $this->UserAuth->getUserId();
					if($this->UserEmailSignatures->save($userEmailSignatureEntity, ['validate'=>false])) {
						$this->Flash->success(__('The email signature has been added successfully'));
						$this->redirect(['action'=>'index']);
					} else {
						$this->Flash->error(__('Unable to save email signature, please try again'));
					}
				}
			}
		}
		$this->set(compact('userEmailSignatureEntity'));
	}
	/**
	 * It is used to edit user email signature
	 *
	 * @access public
	 * @param integer $emailSignatureId email signature id
	 * @return void
	 */
	public function edit($emailSignatureId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($emailSignatureId) {
			$userId = $this->UserAuth->getUserId();
			$userEmailSignatureEntity = $this->UserEmailSignatures->find()->where(['UserEmailSignatures.id'=>$emailSignatureId, 'UserEmailSignatures.user_id'=>$userId])->first();
			if(!empty($userEmailSignatureEntity)) {
				$this->UserEmailSignatures->patchEntity($userEmailSignatureEntity, $this->request->data, ['validate'=>'forAdd']);
				if($this->request->is(['put', 'post'])) {
					$errors = $userEmailSignatureEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['UserEmailSignatures']  = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->UserEmailSignatures->save($userEmailSignatureEntity, ['validate'=>false])) {
								$this->Flash->success(__('The email signature has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to save email signature, please try again'));
							}
						}
					}
				}
				$this->set(compact('userEmailSignatureEntity'));
			} else {
				$this->Flash->error(__('Invalid email signature id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing email signature id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to delete the email signature
	 *
	 * @access public
	 * @param integer $emailSignatureId email signature id
	 * @return void
	 */
	public function delete($emailSignatureId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($emailSignatureId) {
			if($this->request->is('post')) {
				$userId = $this->UserAuth->getUserId();
				$userEmailSignatureEntity = $this->UserEmailSignatures->find()->where(['UserEmailSignatures.id'=>$emailSignatureId, 'UserEmailSignatures.user_id'=>$userId])->first();
				if(!empty($userEmailSignatureEntity)) {
					if($this->UserEmailSignatures->delete($userEmailSignatureEntity)) {
						$this->Flash->success(__('Selected email signature has been deleted successfully'));
					} else {
						$this->Flash->error(__('Unable to delete selected email signature, please try again'));
					}
				} else {
					$this->Flash->error(__('Invalid email signature id'));
				}
			}
		} else {
			$this->Flash->error(__('Missing email signature id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
}