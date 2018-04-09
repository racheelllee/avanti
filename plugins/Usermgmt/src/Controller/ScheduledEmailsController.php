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
use Cake\Network\Email\Email;
use Cake\Network\Session;
use Cake\I18n\Time;

class ScheduledEmailsController extends UsermgmtAppController {
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
	 * This controller uses search filters in following functions for ex index function
	 *
	 * @var array
	 */
	public $searchFields = array
		(
			'index'=>[
				'Usermgmt.ScheduledEmails'=>[
					'ScheduledEmails'=>[
						'type'=>'text',
						'label'=>'Search',
						'tagline'=>'Search by from name, email, subject, message',
						'condition'=>'multiple',
						'searchFields'=>['ScheduledEmails.from_name', 'ScheduledEmails.from_email', 'ScheduledEmails.subject', 'ScheduledEmails.message'],
						'inputOptions'=>['style'=>'width:300px;']
					]
				]
			]
		);
	/**
	 * Called before the controller action. You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->loadModel('Usermgmt.ScheduledEmails');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
		if(isset($this->Csrf) && $this->request->is('ajax') && $this->request['action'] == 'deleteRecipient') {
			$this->eventManager()->off($this->Csrf);
		}
	}
	/**
	 * It displays all scheduled Emails
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$cond = [];
		if(!$this->UserAuth->isAdmin()) {
			$cond['ScheduledEmails.scheduled_by'] = $this->UserAuth->getUserId();
		}
		$this->paginate = ['limit'=>10, 'order'=>['ScheduledEmails.id'=>'DESC'], 'contain'=>['Users'], 'conditions'=>$cond];
		$this->Search->applySearch($cond);
		$scheduledEmails = $this->paginate($this->ScheduledEmails)->toArray();
		$this->loadModel('Usermgmt.UserGroups');
		$this->loadModel('Usermgmt.ScheduledEmailRecipients');
		foreach($scheduledEmails as $key=>$row) {
			if(!empty($row['user_group_id'])) {
				$scheduledEmails[$key]['group_name'] = $this->UserGroups->getGroupsByIds($row['user_group_id']);
			}
			$scheduledEmails[$key]['total_sent_emails'] = $this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$row['id'], 'ScheduledEmailRecipients.is_email_sent'=>1])->count();
		}
		$this->set('scheduledEmails', $scheduledEmails);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_scheduled_emails');
		}
	}
	/**
	 * Used to edit scheduled email
	 *
	 * @access public
	 * @param integer $scheduledEmailId scheduled Email id
	 * @return void
	 */
	public function edit($scheduledEmailId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($scheduledEmailId)) {
			$cond = [];
			$cond['ScheduledEmails.id'] = $scheduledEmailId;
			if(!$this->UserAuth->isAdmin()) {
				$cond['ScheduledEmails.scheduled_by'] = $this->UserAuth->getUserId();
			}
			$scheduledEmailEntity = $this->ScheduledEmails->find()->where($cond)->first();
			if(!empty($scheduledEmailEntity)) {
				if(!empty($this->request->data['ScheduledEmails']['schedule_date'])) {
					$this->request->data['ScheduledEmails']['schedule_date'] = new Time($this->request->data['ScheduledEmails']['schedule_date']);
				}
				$this->ScheduledEmails->patchEntity($scheduledEmailEntity, $this->request->data, ['validate'=>'forSend']);
				if($this->request->is(['put', 'post'])) {
					$errors = $scheduledEmailEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['ScheduledEmails']  = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->ScheduledEmails->save($scheduledEmailEntity, ['validate'=>false])) {
								$this->Flash->success(__('The scheduled email has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to update scheduled email, please try again.'));
							}
						}
					}
				} else {
					$scheduledEmailEntity['schedule_date'] = $scheduledEmailEntity['schedule_date']->format('Y-m-d H:i:s');
				}
				$this->loadModel('Usermgmt.UserGroups');
				$groups = $this->UserGroups->getUserGroups(false);
				$this->set(compact('templates', 'signatures', 'groups', 'scheduledEmailEntity'));
			} else {
				$this->Flash->error(__('Invalid Scheduled Email Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing Scheduled Email Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * Used to view scheduled email details and it's recipients
	 *
	 * @access public
	 * @param integer $scheduledEmailId scheduled Email id
	 * @return void
	 */
	public function view($scheduledEmailId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($scheduledEmailId)) {
			$cond = [];
			$cond['ScheduledEmails.id'] = $scheduledEmailId;
			if(!$this->UserAuth->isAdmin()) {
				$cond['ScheduledEmails.scheduled_by'] = $this->UserAuth->getUserId();
			}
			$scheduledEmail = $this->ScheduledEmails->find()->where($cond)->contain(['Users'])->first();
			if(!empty($scheduledEmail)) {
				if(!empty($scheduledEmail['user_group_id'])) {
					$this->loadModel('Usermgmt.UserGroups');
					$scheduledEmail['group_name'] = $this->UserGroups->getGroupsByIds($scheduledEmail['user_group_id']);
				}
				$this->loadModel('Usermgmt.ScheduledEmailRecipients');
				$scheduledEmail['total_sent_emails'] = $this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$scheduledEmailId, 'ScheduledEmailRecipients.is_email_sent'=>1])->count();
				$scheduledEmailRecipients = $this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$scheduledEmailId])->contain(['Users'])->hydrate(false)->toArray();
				$this->set(compact('scheduledEmail', 'scheduledEmailRecipients'));
			} else {
				$this->Flash->error(__('Invalid Scheduled Email Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing Scheduled Email Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * Used to delete scheduled email
	 *
	 * @access public
	 * @param integer $scheduledEmailId scheduled Email id
	 * @return void
	 */
	public function delete($scheduledEmailId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($scheduledEmailId)) {
			$cond = [];
			$cond['ScheduledEmails.id'] = $scheduledEmailId;
			if(!$this->UserAuth->isAdmin()) {
				$cond['ScheduledEmails.scheduled_by'] = $this->UserAuth->getUserId();
			}
			$scheduledEmail = $this->ScheduledEmails->find()->where($cond)->contain(['Users'])->first();
			if(!empty($scheduledEmail)) {
				$this->loadModel('Usermgmt.ScheduledEmailRecipients');
				if(!$scheduledEmail['is_sent']) {
					$total_sent_emails = $this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$scheduledEmailId, 'ScheduledEmailRecipients.is_email_sent'=>1])->count();
					$total_unsent_emails = $this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$scheduledEmailId, 'ScheduledEmailRecipients.is_email_sent'=>0])->count();
					if($total_sent_emails) {
						$this->ScheduledEmailRecipients->deleteAll(['scheduled_email_id'=>$scheduledEmailId, 'is_email_sent'=>0]);
						$scheduledEmail['is_sent'] = 1;
						$this->ScheduledEmails->save($scheduledEmail, ['validate'=>false]);
						$this->Flash->success(__('Only few recipients have been deleted successfully'));
					} else {
						$this->ScheduledEmails->delete($scheduledEmail);
						$this->Flash->success(__('Scheduled Email and recipients have been deleted successfully'));
					}
				} else {
					$this->Flash->error(__('All emails have been sent already so this scheduled email cannot be deleted'));
				}
			} else {
				$this->Flash->error(__('Invalid User Email Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Email Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
	/**
	 * Used to delete scheduled email recipient
	 *
	 * @access public
	 * @param integer $scheduledEmailRecipientId scheduled email recipient id
	 * @return json
	 */
	public function deleteRecipient($scheduledEmailRecipientId=null) {
		$scheduledEmailId = null;
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		$response = ['error'=>1, 'message'=>'failure'];
		if(!empty($scheduledEmailRecipientId)) {
			$cond = [];
			$cond['ScheduledEmailRecipients.id'] = $scheduledEmailRecipientId;
			if(!$this->UserAuth->isAdmin()) {
				$cond['ScheduledEmails.scheduled_by'] = $this->UserAuth->getUserId();
			}
			$this->loadModel('Usermgmt.ScheduledEmailRecipients');
			$scheduledEmailRecipient = $this->ScheduledEmailRecipients->find()->where($cond)->contain(['ScheduledEmails'])->first();
			if(!empty($scheduledEmailRecipient)) {
				$scheduledEmailId = $scheduledEmailRecipient['scheduled_email_id'];
				if($this->request->is('post') || isset($_SERVER['HTTP_REFERER'])) {
					if(!$scheduledEmailRecipient['is_email_sent']) {
						$this->ScheduledEmailRecipients->delete($scheduledEmailRecipient);
						$response = ['error'=>0, 'message'=>__('Selected recipient has been deleted successfully')];
					} else {
						$response['message'] = __('Selected Recipient cannot be deleted');
					}
				} else {
					$response['message'] = __('Invalid Request');
				}
			} else {
				$response['message'] = __('Invalid Scheduled Email Recipient Id');
			}
		} else {
			$response['message'] = __('Missing Scheduled Email Recipient Id');
		}
		if($this->request->is('ajax')) {
			echo json_encode($response);exit;
		} else {
			if($response['error']) {
				$this->Flash->error($response['message']);
			} else {
				$this->Flash->success($response['message']);
			}
			if($scheduledEmailId) {
				$this->redirect(['action'=>'view', $scheduledEmailId, 'page'=>$page]);
			} else {
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		}
	}
}