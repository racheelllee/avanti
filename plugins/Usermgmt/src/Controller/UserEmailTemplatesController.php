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

class UserEmailTemplatesController extends UsermgmtAppController {
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
			'Usermgmt.UserEmailTemplates'=>[
				'UserEmailTemplates'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by email template name, header, footer',
					'condition'=>'multiple',
					'searchFields'=>['UserEmailTemplates.template_name', 'UserEmailTemplates.header', 'UserEmailTemplates.footer'],
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
		$this->loadModel('Usermgmt.UserEmailTemplates');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all email templates
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$cond = [];
		$cond['UserEmailTemplates.user_id'] = $this->UserAuth->getUserId();
		$this->paginate = ['limit'=>10, 'conditions'=>$cond, 'order'=>['UserEmailTemplates.id'=>'DESC']];
		$this->Search->applySearch($cond);
		$userEmailTemplates = $this->paginate($this->UserEmailTemplates)->toArray();
		$this->set('userEmailTemplates', $userEmailTemplates);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_email_templates');
		}
	}
	/**
	 * It is used to add a new email template
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		$userEmailTemplateEntity = $this->UserEmailTemplates->newEntity($this->request->data, ['validate'=>'forAdd']);
		if($this->request->is('post')) {
			$errors = $userEmailTemplateEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserEmailTemplates']  = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					$userEmailTemplateEntity['user_id'] = $this->UserAuth->getUserId();
					if($this->UserEmailTemplates->save($userEmailTemplateEntity, ['validate'=>false])) {
						$this->Flash->success(__('The email template has been added successfully'));
						$this->redirect(['action'=>'index']);
					} else {
						$this->Flash->error(__('Unable to add email template, please try again'));
					}
				}
			}
		}
		$this->set(compact('userEmailTemplateEntity'));
	}
	/**
	 * It is used to edit email template
	 *
	 * @access public
	 * @param integer $emailTemplateId email template id
	 * @return void
	 */
	public function edit($emailTemplateId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($emailTemplateId) {
			$userId = $this->UserAuth->getUserId();
			$userEmailTemplateEntity = $this->UserEmailTemplates->find()->where(['UserEmailTemplates.id'=>$emailTemplateId, 'UserEmailTemplates.user_id'=>$userId])->first();
			if(!empty($userEmailTemplateEntity)) {
				$this->UserEmailTemplates->patchEntity($userEmailTemplateEntity, $this->request->data, ['validate'=>'forAdd']);
				if($this->request->is(['put', 'post'])) {
					$errors = $userEmailTemplateEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['UserEmailTemplates'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->UserEmailTemplates->save($userEmailTemplateEntity, ['validate'=>false])) {
								$this->Flash->success(__('The email template has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to update email template, please try again'));
							}
						}
					}
				}
				$this->set(compact('userEmailTemplateEntity'));
			} else {
				$this->Flash->error(__('Invalid email template id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing email template id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to delete the email template
	 *
	 * @access public
	 * @param integer $emailTemplateId email template id
	 * @return void
	 */
	public function delete($emailTemplateId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($emailTemplateId)) {
			if($this->request->is('post')) {
				$userId = $this->UserAuth->getUserId();
				$userEmailTemplate = $this->UserEmailTemplates->find()->where(['UserEmailTemplates.id'=>$emailTemplateId, 'UserEmailTemplates.user_id'=>$userId])->first();
				if(!empty($userEmailTemplate)) {
					if($this->UserEmailTemplates->delete($userEmailTemplate)) {
						$this->Flash->success(__('Selected email template has been deleted successfully'));
					} else {
						$this->Flash->error(__('Unable to delete selected email template, please try again'));
					}
				} else {
					$this->Flash->error(__('Invalid email template id'));
				}
			}
		} else {
			$this->Flash->error(__('Missing email template id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
}