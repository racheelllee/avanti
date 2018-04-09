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

class UserEmailsController extends UsermgmtAppController {
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
				'Usermgmt.UserEmails'=>[
					'UserEmails'=>[
						'type'=>'text',
						'label'=>'Search',
						'tagline'=>'Search by from name, email, subject, message',
						'condition'=>'multiple',
						'searchFields'=>['UserEmails.from_name', 'UserEmails.from_email', 'UserEmails.subject', 'UserEmails.message'],
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
		$this->loadModel('Usermgmt.UserEmails');
		if(isset($this->Security) && ($this->request->is('ajax') || $this->request['action'] == 'send')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
		if(isset($this->Csrf) && $this->request->is('ajax') && $this->request['action'] == 'searchEmails') {
			$this->eventManager()->off($this->Csrf);
		}
	}
	/**
	 * It displays all sent Emails
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$cond = [];
		if(!$this->UserAuth->isAdmin()) {
			$cond['UserEmails.sent_by'] = $this->UserAuth->getUserId();
		}
		$this->paginate = ['limit'=>10, 'order'=>['UserEmails.id'=>'DESC'], 'contain'=>['Users'], 'conditions'=>$cond];
		$this->Search->applySearch($cond);
		$userEmails = $this->paginate($this->UserEmails)->toArray();
		$this->loadModel('Usermgmt.UserGroups');
		$this->loadModel('Usermgmt.UserEmailRecipients');
		foreach($userEmails as $key=>$row) {
			if(!empty($row['user_group_id'])) {
				$userEmails[$key]['group_name'] = $this->UserGroups->getGroupsByIds($row['user_group_id']);
			}
			$userEmails[$key]['total_sent_emails'] = $this->UserEmailRecipients->find()->where(['UserEmailRecipients.user_email_id'=>$row['id'], 'UserEmailRecipients.is_email_sent'=>1])->count();
		}
		$this->set('userEmails', $userEmails);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_emails');
		}
	}
	/**
	 * It is used to send emails to groups, selected users, manual emails
	 *
	 * @access public
	 * @return void
	 */
	public function send() {
		$confirm = null;
		if(isset($this->request->data['confirmEmail'])) {
			$confirm = 'confirm';
		}
		ini_set('memory_limit','256M');
		ini_set('max_execution_time', 5200);
		$confirmRender = false;
		if(!empty($this->request->data) && isset($this->request->data['UserEmails']['type'])) {
			if($this->request->data['UserEmails']['type'] == 'USERS') {
				unset($this->request->data['UserEmails']['user_group_id']);
				unset($this->request->data['UserEmails']['to_email']);
			} else if($this->request->data['UserEmails']['type'] == 'GROUPS') {
				unset($this->request->data['UserEmails']['user_id']);
				unset($this->request->data['UserEmails']['to_email']);
				if(is_array($this->request->data['UserEmails']['user_group_id'])) {
					sort($this->request->data['UserEmails']['user_group_id']);
					$this->request->data['UserEmails']['user_group_id'] = implode(',', $this->request->data['UserEmails']['user_group_id']);
				}
			} else {
				unset($this->request->data['UserEmails']['user_id']);
				unset($this->request->data['UserEmails']['user_group_id']);
			}
		}
		if(!empty($this->request->data['UserEmails']['schedule_date'])) {
			$this->request->data['UserEmails']['schedule_date'] = new Time($this->request->data['UserEmails']['schedule_date']);
		}
		$userEmailEntity = $this->UserEmails->newEntity($this->request->data, ['validate'=>'forSend']);
		$this->loadModel('Usermgmt.UserEmailTemplates');
		$this->loadModel('Usermgmt.UserEmailSignatures');
		$this->loadModel('Usermgmt.Users');

		if($this->request->is('post')) {
			$errors = $userEmailEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserEmails'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					$users = [];
					if(is_null($confirm)) {
						if($userEmailEntity['type'] == 'GROUPS') {
							$userEmailEntity['user_group_id'] = explode(',', $userEmailEntity['user_group_id']);
							$cond = [];
							$cond['Users.active'] = 1;
							$groupCond = [];
							foreach($userEmailEntity['user_group_id'] as $groupId) {
								$groupCond[] = ['Users.user_group_id'=>$groupId];
								$groupCond[] = ['Users.user_group_id like'=>$groupId.',%'];
								$groupCond[] = ['Users.user_group_id like'=>'%,'.$groupId.',%'];
								$groupCond[] = ['Users.user_group_id like'=>'%,'.$groupId];
							}
							$cond['OR'] = $groupCond;
							$users = $this->Users->find()->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email'])->where($cond)->order(['Users.first_name'=>'ASC'])->hydrate(false)->toArray();
						} else if($userEmailEntity['type'] == 'USERS') {
							$users = $this->Users->find()->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email'])->where(['Users.id IN'=>$userEmailEntity['user_id'], 'Users.active'=>1])->order(['Users.first_name'=>'ASC'])->hydrate(false)->toArray();
						} else if($userEmailEntity['type'] == 'MANUAL') {
							$emails = array_filter(array_map('trim', explode(',', strtolower($userEmailEntity['to_email']))));
							$i = 0;
							foreach($emails as $email) {
								$users[$i]['email'] = $email;
								$users[$i]['id'] = null;
								$users[$i]['first_name'] = null;
								$users[$i]['last_name'] = null;
								$i++;
							}
						}
					} else if($confirm == 'confirm') {
						$i = 0;
						foreach($userEmailEntity['EmailList'] as $row) {
							if(isset($row['emailcheck']) && $row['emailcheck'] && !empty($row['email'])) {
								$users[$i]['id'] = $row['uid'];
								$users[$i]['email'] = $row['email'];
								$i++;
							}
						}
					}
					if(!empty($users)) {
						if(is_null($confirm)) {
							$userEmailEntity['total_rows'] = count($users);
							if($userEmailEntity['template']) {
								$template = $this->UserEmailTemplates->getEmailTemplateById($userEmailEntity['template']);
							}
							if($userEmailEntity['signature']) {
								$signature = $this->UserEmailSignatures->getEmailSignatureById($userEmailEntity['signature']);
							}
							$message = '';
							if(!empty($template['header'])) {
								$message .= $template['header']."<br/>";
							}
							$message .= $userEmailEntity['message'];
							if(!empty($signature['signature'])) {
								$message .= $signature['signature'];
							}
							if(!empty($template['footer'])) {
								$message .= "<br/>".$template['footer'];
							}
							$userEmailEntity['modified_message'] = $message;
							$this->request->session()->write('send_email_data', $userEmailEntity);
							$this->set(compact('users'));
							$confirmRender = true;
						} else if($confirm == 'confirm') {
							$data = $this->request->session()->read('send_email_data');
							$postRows = count($userEmailEntity['EmailList']);
							if($data['total_rows'] > $postRows) {
								die('We did not get all email rows in post data, please check max_input_vars configuration on server.');
							}
							if(!empty($data['schedule_date'])) {
								$scheduled = $this->saveScheduledEmails($data, $users);
								if($scheduled) {
									$this->request->session()->delete('send_email_data');
									$this->redirect(['controller'=>'ScheduledEmails', 'action'=>'index']);
								} else {
									$this->redirect(['action'=>'send']);
								}
							} else {
								$sent = $this->sendAndSaveUserEmail($data, $users);
								if($sent) {
									$this->request->session()->delete('send_email_data');
									$this->redirect(['action'=>'index']);
								} else {
									$this->redirect(['action'=>'send']);
								}
							}
						}
					} else {
						if($userEmailEntity['type'] == 'GROUPS') {
							$this->Flash->warning(__('No users found in selected group'));
						}
					}
				}
			}
		} else {
			$userEmailEntity['from_name'] = EMAIL_FROM_NAME;
			$userEmailEntity['from_email'] = EMAIL_FROM_ADDRESS;
			if($this->request->session()->check('send_email_data')) {
				$userEmailEntity = $this->request->session()->read('send_email_data');
				if(!empty($userEmailEntity['schedule_date'])) {
					$userEmailEntity['schedule_date'] = $userEmailEntity['schedule_date']->format('Y-m-d H:i:s');
				}
				$this->request->session()->delete('send_email_data');
			}
		}
		if(!$confirmRender) {
			$sel_users = [];
			if(!empty($userEmailEntity['user_id'])) {
				$sel_users = $this->Users->getAllUsersWithUserIds($userEmailEntity['user_id']);
			}
			$templates = $this->UserEmailTemplates->getEmailTemplates();
			$signatures = $this->UserEmailSignatures->getEmailSignatures();
		}
		$this->loadModel('Usermgmt.UserGroups');
		$groups = $this->UserGroups->getUserGroups(false);
		$this->set(compact('groups', 'sel_users', 'templates', 'signatures', 'userEmailEntity'));
		if($confirmRender) {
			$this->render('send_confirm');
		}
	}
	/**
	 * It is used to send email to user
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function sendToUser($userId=null) {
		$confirm = null;
		if(isset($this->request->data['confirmEmail'])) {
			$confirm = 'confirm';
		}
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		$confirmRender = false;
		if($userId) {
			$this->loadModel('Usermgmt.Users');
			$user = $this->Users->getUserById($userId);
			if(!empty($user)) {
				$userEmailEntity = $this->UserEmails->newEntity($this->request->data, ['validate'=>'forSend']);
				$name = $user['first_name'].' '.$user['last_name'];

				$this->loadModel('Usermgmt.UserEmailTemplates');
				$this->loadModel('Usermgmt.UserEmailSignatures');
				if($this->request->is('post')) {
					$errors = $userEmailEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['UserEmails']  = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if(is_null($confirm)) {
								if($userEmailEntity['template']) {
									$template = $this->UserEmailTemplates->getEmailTemplateById($userEmailEntity['template']);
								}
								if($userEmailEntity['signature']) {
									$signature = $this->UserEmailSignatures->getEmailSignatureById($userEmailEntity['signature']);
								}
								$message = '';
								if(!empty($template['header'])) {
									$message .= $template['header']."<br/>";
								}
								$message .= $userEmailEntity['message'];
								if(!empty($signature['signature'])) {
									$message .= $signature['signature'];
								}
								if(!empty($template['footer'])) {
									$message .= "<br/>".$template['footer'];
								}
								$userEmailEntity['modified_message'] = $message;
								$this->request->session()->write('send_user_email_data', $userEmailEntity);
								$confirmRender = true;
							} else if($confirm == 'confirm') {
								$data = $this->request->session()->read('send_user_email_data');
								$data['type'] = 'USERS';
								$users = [];
								$users[0]['id'] = $userId;
								$users[0]['email'] = $data['to'];
								$sent = $this->sendAndSaveUserEmail($data, $users);
								if($sent) {
									$this->request->session()->delete('send_user_email_data');
									if($sent) {
										$this->redirect(['controller'=>'Users', 'action'=>'index', 'page'=>$page]);
									}
								} else {
									$this->redirect(['action'=>'sendToUser', $userId, 'page'=>$page]);
								}
							}
						}
					}
				} else {
					$userEmailEntity['from_name'] = EMAIL_FROM_NAME;
					$userEmailEntity['from_email'] = EMAIL_FROM_ADDRESS;
					$userEmailEntity['to'] = $user['email'];
					if($this->request->session()->check('send_user_email_data')) {
						$userEmailEntity = $this->request->session()->read('send_user_email_data');
						$this->request->session()->delete('send_user_email_data');
					}
				}
			} else {
				$this->Flash->error(__('Invalid User Id'));
				$this->redirect(['controller'=>'Users', 'action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
			$this->redirect(['controller'=>'Users', 'action'=>'index', 'page'=>$page]);
		}
		$templates = $this->UserEmailTemplates->getEmailTemplates();
		$signatures = $this->UserEmailSignatures->getEmailSignatures();
		$this->set(compact('userId', 'name', 'email', 'templates', 'signatures', 'userEmailEntity'));
		if($confirmRender) {
			$this->render('send_to_user_confirm');
		}
	}
	private function sendAndSaveUserEmail($data, $users) {
		$data['sent_by'] = $this->UserAuth->getUserId();
		if(!empty($data['user_group_id'])) {
			sort($data['user_group_id']);
			$data['user_group_id'] = implode(',', $data['user_group_id']);
		}
		$data['message'] = $data['modified_message'];
		if($this->UserEmails->save($data, ['validate'=>false])) {
			$fromConfig = $data['from_email'];
			$fromNameConfig = $data['from_name'];
			$emailObj = new Email('default');
			$emailObj->from([$fromConfig=>$fromNameConfig]);
			$emailObj->sender([$fromConfig=>$fromNameConfig]);
			$emailObj->subject($data['subject']);
			$emailObj->emailFormat('both');
			$totalSentEmails = $totalEmails = 0;
			$sentEmails = [];
			$this->loadModel('Usermgmt.UserEmailRecipients');
			foreach($users as $user) {
				if(!isset($sentEmails[$user['email']])) {
					$totalEmails++;
					$emailObj->to($user['email']);
					$userEmailRecipient = $this->UserEmailRecipients->newEntity();
					try{
						$result = $emailObj->send($data['message']);
						if($result) {
							$userEmailRecipient['is_email_sent'] = 1;
							$totalSentEmails++;
						}
					} catch (Exception $ex){
					}
					$userEmailRecipient['user_email_id'] = $data['id'];
					$userEmailRecipient['user_id'] = $user['id'];
					$userEmailRecipient['email_address'] = $user['email'];
					$this->UserEmailRecipients->save($userEmailRecipient, ['validate'=>false]);
					$sentEmails[$user['email']] = $user['email'];
				}
			}
			if(!empty($data['cc_to'])) {
				$data['cc_to'] = array_filter(array_map('trim', explode(',', strtolower($data['cc_to']))));
				foreach($data['cc_to'] as $ccEmail) {
					$emailObj->to($ccEmail);
					try{
						$emailObj->send($data['message']);
					} catch (Exception $ex) {
					}
				}
			}
			if($totalSentEmails) {
				if($totalSentEmails == $totalEmails) {
					$this->Flash->success(__('All Emails have been sent successfully'));
				} else {
					$this->Flash->success(__('Out of {0) Emails only {1} Emails have been sent successfully', [$totalEmails, $totalSentEmails]));
				}
				return true;
			} else {
				$this->Flash->error(__('There is problem in sending emails, please try again'));
				return false;
			}
		} else {
			$this->Flash->error(__('These is some problem in saving data, please try again'));
			return false;
		}
	}
	private function saveScheduledEmails($data, $users) {
		$data['scheduled_by'] = $this->UserAuth->getUserId();
		if(!empty($data['user_group_id'])) {
			sort($data['user_group_id']);
			$data['user_group_id'] = implode(',', $data['user_group_id']);
		}
		$data['message'] = $data['modified_message'];
		$this->loadModel('Usermgmt.ScheduledEmails');
		if($this->ScheduledEmails->save($data, ['validate'=>false])) {
			$scheduledEmails = [];
			$this->loadModel('Usermgmt.ScheduledEmailRecipients');
			foreach($users as $user) {
				if(!isset($scheduledEmails[$user['email']])) {
					$scheduledEmailRecipient = $this->ScheduledEmailRecipients->newEntity();
					$scheduledEmailRecipient['scheduled_email_id'] = $data['id'];
					$scheduledEmailRecipient['user_id'] = $user['id'];
					$scheduledEmailRecipient['email_address'] = $user['email'];
					$this->ScheduledEmailRecipients->save($scheduledEmailRecipient, ['validate'=>false]);
					$scheduledEmails[$user['email']] = $user['email'];
				}
			}
			$this->Flash->success(__('Email has been scheduled successfully'));
			return true;
		} else {
			$this->Flash->error(__('These is some problem in saving data, please try again'));
			return false;
		}
	}
	/**
	 * Used to view sent email details and it's recipients
	 *
	 * @access public
	 * @param integer $userEmailId userEmail id
	 * @return void
	 */
	public function view($userEmailId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userEmailId)) {
			$cond = [];
			$cond['UserEmails.id'] = $userEmailId;
			if(!$this->UserAuth->isAdmin()) {
				$cond['UserEmails.sent_by'] = $this->UserAuth->getUserId();
			}
			$userEmail = $this->UserEmails->find()->where($cond)->contain(['Users'])->first();
			if(!empty($userEmail)) {
				if(!empty($userEmail['user_group_id'])) {
					$this->loadModel('Usermgmt.UserGroups');
					$userEmail['group_name'] = $this->UserGroups->getGroupsByIds($userEmail['user_group_id']);
				}
				$this->loadModel('Usermgmt.UserEmailRecipients');
				$userEmail['total_sent_emails'] = $this->UserEmailRecipients->find()->where(['UserEmailRecipients.user_email_id'=>$userEmail['id'], 'UserEmailRecipients.is_email_sent'=>1])->count();
				$userEmailRecipients = $this->UserEmailRecipients->find()->where(['UserEmailRecipients.user_email_id'=>$userEmailId])->contain(['Users'])->hydrate(false)->toArray();
				$this->set(compact('userEmail', 'userEmailRecipients'));
			} else {
				$this->Flash->error(__('Invalid User Email Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing User Email Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to search emails on send email page
	 *
	 * @access public
	 * @return void
	 */
	public function searchEmails() {
		$results = [];
		$query = '';
		if($this->request->is('ajax')) {
			if(isset($_POST['data']['q'])) {
				$query = $_POST['data']['q'];
				$selectedUserIds = [];
				if(isset($_POST['data']['selIds'])) {
					$selectedUserIds = explode(',', $_POST['data']['selIds']);
				}
				$this->loadModel('Usermgmt.Users');
				$results = $this->Users->find()->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email'])->where(['OR'=>[['Users.first_name LIKE'=>$query.'%'], ['Users.last_name LIKE'=>$query.'%'], ['Users.email LIKE'=>$query.'%@%']], 'Users.email IS NOT NULL', 'Users.email !='=>'', 'Users.active'=>1]);
			}
		}
		$resultToPrint = [];
		foreach($results as $res) {
			$resultToPrint[] = ['id'=>$res['id'], 'text'=>$res['first_name'].' '.$res['last_name'].' ( '.$res['email'].' )'];
		}
		echo json_encode(['q'=>$query, 'results'=>$resultToPrint]);exit;
	}
}