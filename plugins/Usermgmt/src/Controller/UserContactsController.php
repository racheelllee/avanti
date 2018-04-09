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

class UserContactsController extends UsermgmtAppController {
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
			'Usermgmt.UserContacts'=>[
				'UserContacts'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by name, phone, email, requirement, message',
					'condition'=>'multiple',
					'searchFields'=>['UserContacts.name', 'UserContacts.phone', 'UserContacts.email', 'UserContacts.requirement', 'UserContacts.reply_message'],
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
		$this->loadModel('Usermgmt.UserContacts');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all contacts enquiries
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->paginate = ['limit'=>10, 'order'=>['UserContacts.id'=>'DESC']];
		$this->Search->applySearch();
		$userContacts = $this->paginate($this->UserContacts)->toArray();
		$this->set('userContacts', $userContacts);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_contacts');
		}
	}
	/**
	 * It is used to show contact enquiry form
	 *
	 * @access public
	 * @return void
	 */
	public function contactUs() {
		$userId = $this->UserAuth->getUserId();
		$this->loadModel('Usermgmt.Users');
		if($userId) {
			$user = $this->Users->getUserById($userId);
		}
		if($this->request->is('post') && $this->UserAuth->canUseRecaptha('contactus') && !$this->request->is('ajax')) {
			$this->request->data['UserContacts']['captcha']= (isset($this->request->data['g-recaptcha-response'])) ? $this->request->data['g-recaptcha-response'] : "";
		}
		$userContactEntity = $this->UserContacts->newEntity($this->request->data, ['validate'=>'forContact']);
		if($this->request->is('post')) {
			$errors = $userContactEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserContacts'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					$userContactEntity['user_id'] = $userId;
					$this->UserContacts->save($userContactEntity, ['validate'=>false]);
					$this->__sendMailToAdmin($userContactEntity);
					$this->Flash->success(__('Thank you for contacting us. we will be in touch with you very soon'));
					$this->redirect('/');
				}
			}
		} else {
			if(!empty($user)) {
				$userContactEntity['name'] = $user['first_name'].' '.$user['last_name'];
				$userContactEntity['email'] = $user['email'];
				$userContactEntity['phone'] = $user['user_detail']['cellphone'];
			}
		}
		$this->set(compact('userContactEntity'));
	}
	private function __sendMailToAdmin($userContactEntity) {
		$emailObj = new Email('default');
		$emailObj->emailFormat('both');
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;
		$emailObj->from([$fromConfig=>$fromNameConfig]);
		$emailObj->sender([$fromConfig=>$fromNameConfig]);
		$emailObj->subject(__('Contact Enquiry Received'));
		$requirement = nl2br($userContactEntity['requirement']);
		$body = __('Hi Admin, <br/><br/>A contact enquiry has been saved. Here are the details - <br/><br/>Name- {0} <br/>Email - {1} <br/>Contact No - {2} <br/>Requirement - {3} <br/><br/>Thanks', [$userContactEntity['name'], $userContactEntity['email'], $userContactEntity['phone'], $requirement]);
		if(ADMIN_EMAIL_ADDRESS) {
			$emailObj->to(ADMIN_EMAIL_ADDRESS);
			try{
				$emailObj->send($body);
			} catch (Exception $ex) {
			}
		}
	}
	/**
	 * It is used to send reply of contact enquiry
	 *
	 * @access public
	 * @param integer $userContactId user contact id
	 * @return void
	 */
	public function sendReply($userContactId=null) {
		$confirm = null;
		if(isset($this->request->data['confirmEmail'])) {
			$confirm = 'confirm';
		}
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userContactId)) {
			$userContact = $this->UserContacts->find()->where(['UserContacts.id'=>$userContactId])->first();
			if(!empty($userContact)) {
				$this->loadModel('Usermgmt.UserEmails');
				$this->loadModel('Usermgmt.UserEmailTemplates');
				$this->loadModel('Usermgmt.UserEmailSignatures');

				$userEmailEntity = $this->UserEmails->newEntity($this->request->data, ['validate'=>'forSend']);
				$name = $userContact['name'];
				$confirmRender = false;
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
								$this->request->session()->write('send_reply_email_data', $userEmailEntity);
								$confirmRender = true;
							} else if($confirm == 'confirm') {
								$data = $this->request->session()->read('send_reply_email_data');
								$fromConfig = $data['from_email'];
								$fromNameConfig = $data['from_name'];

								$emailObj = new Email('default');
								$emailObj->from([$fromConfig=>$fromNameConfig]);
								$emailObj->sender([$fromConfig=>$fromNameConfig]);
								$emailObj->subject($data['subject']);
								$emailObj->emailFormat('both');
								$sent = false;
								$emailObj->to($data['to']);
								if(!empty($data['cc_to'])) {
									$data['cc_to'] = array_filter(array_map('trim', explode(',', strtolower($data['cc_to']))));
									$emailObj->cc($data['cc_to']);
								}
								try{
									$result = $emailObj->send($data['modified_message']);
									if($result) {
										$sent = true;
									}
								} catch (Exception $ex){

								}
								if($sent) {
									$this->request->session()->delete('send_reply_email_data');
									$msg = $userContact['reply_message'];
									if(empty($msg)) {
										$userContact['reply_message'] = 'Reply On '.date('d M Y', time()).' at '.date('h:i A', time()).'<br/>'.$data['modified_message'];
									} else {
										$userContact['reply_message'] = 'Reply On '.date('d M Y', time()).' at '.date('h:i A', time()).'<br/>'.$data['modified_message'].'<br/><br/>'.$msg;
									}
									$this->UserContacts->save($userContact, ['validate'=>false]);
									$this->Flash->success(__('Contact Reply has been sent successfully'));
									$this->redirect(['action'=>'index', 'page'=>$page]);
								} else {
									$this->Flash->error(__('We could not send Reply Email'));
									$this->redirect(['action'=>'sendReply', $userContactId]);
								}
							}
						}
					}
				} else {
					$userEmailEntity['from_name'] = EMAIL_FROM_NAME;
					$userEmailEntity['from_email'] = EMAIL_FROM_ADDRESS;
					$userEmailEntity['to'] = $userContact['email'];
					$userEmailEntity['subject'] = 'Re: '.SITE_NAME;
					$userEmailEntity['message'] = '<br/><p>-------------------------------------------<br/>On '.$userContact['created']->format('d M Y').' at '.$userContact['created']->format('h:i A').'<br/>'.h($userContact['name']).' wrote:</p>'.$userContact['requirement'];
					if($this->request->session()->check('send_reply_email_data')) {
						$userEmailEntity = $this->request->session()->read('send_reply_email_data');
						$this->request->session()->delete('send_reply_email_data');
					}
				}
				if(!$confirmRender) {
					$templates = $this->UserEmailTemplates->getEmailTemplates();
					$signatures = $this->UserEmailSignatures->getEmailSignatures();
				}
				$this->set(compact('userEmailEntity', 'name', 'templates', 'signatures', 'userContactId'));
				if($confirmRender) {
					$this->render('send_reply_confirm');
				}
			} else {
				$this->Flash->error(__('Invalid Contact Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing Contact Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
}