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

class CronJobsController extends UsermgmtAppController {
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
	 * It displays all sent Emails
	 *
	 * @access public
	 * @return void
	 */
	public function sendScheduledEmails() {
		ini_set('memory_limit', '256M');
		ini_set('max_execution_time', 5200);
		$this->loadModel('Usermgmt.ScheduledEmails');
		$this->loadModel('Usermgmt.ScheduledEmailRecipients');
		$this->loadModel('Usermgmt.UserEmails');
		$this->loadModel('Usermgmt.UserEmailRecipients');
		$date = date('Y-m-d H:i:s');
		$scheduledEmails = $this->ScheduledEmails
								->find()
								->where(['ScheduledEmails.is_sent'=>0, 'ScheduledEmails.schedule_date <='=>$date])
								->order(['ScheduledEmails.created'=>'ASC'])
								->all();
		$ecount = $rcount = 0;
		foreach($scheduledEmails as $row) {
			if(empty($row['user_email_id'])) {
				$userEmail = $this->UserEmails->newEntity();
				$userEmail['type'] = $row['type'];
				$userEmail['user_group_id'] = $row['user_group_id'];
				$userEmail['cc_to'] = $row['cc_to'];
				$userEmail['from_name'] = $row['from_name'];
				$userEmail['from_email'] = $row['from_email'];
				$userEmail['subject'] = $row['subject'];
				$userEmail['message'] = $row['message'];
				$userEmail['sent_by'] = $row['scheduled_by'];

				if($this->UserEmails->save($userEmail, ['validate'=>false])) {
					$row['user_email_id'] = $userEmail['id'];
					$this->ScheduledEmails->save($row, ['validate'=>false]);
				} else {
					continue;
				}
			}
			while(1) {
				// we are fetching recipients one by one to get with latest status. It will avoid duplicate email issue from multiple cron job executions.
				$recipient = $this->ScheduledEmailRecipients
								->find()
								->where(['ScheduledEmailRecipients.scheduled_email_id'=>$row['id'], 'ScheduledEmailRecipients.is_email_sent'=>0])
								->order(['ScheduledEmailRecipients.id'=>'ASC'])
								->first();

				if(!empty($recipient)) {
					$this->sendAndSaveEmail($row, $recipient);
					$rcount++;
				} else {
					break;
				}
			}
			if(!empty($row['cc_to'])) {
				$row['cc_to'] = array_filter(array_map('trim', explode(',', strtolower($row['cc_to']))));
				foreach($row['cc_to'] as $ccEmail) {
					$this->sendAndSaveEmail($row, array('email_address'=>$recipient));
				}
			}
			if(!$this->ScheduledEmailRecipients->find()->where(['ScheduledEmailRecipients.scheduled_email_id'=>$row['id'], 'ScheduledEmailRecipients.is_email_sent'=>0])->count()) {
				$row['is_sent'] = 1;
				unset($row['modified']);
				$this->ScheduledEmails->save($row, ['validate'=>false]);
			}
			$ecount++;
		}
		echo __('{0} Scheduled Emails and {1} recipients processed', $ecount, $rcount);
		exit;
	}
	private function sendAndSaveEmail($data, $recipient) {
		$fromConfig = $data['from_email'];
		$fromNameConfig = $data['from_name'];
		$emailObj = new Email('default');
		$emailObj->from([$fromConfig=>$fromNameConfig]);
		$emailObj->sender([$fromConfig=>$fromNameConfig]);
		$emailObj->subject($data['subject']);
		$emailObj->emailFormat('both');
		$emailObj->to($recipient['email_address']);
		$userEmailRecipient = $this->UserEmailRecipients->newEntity();
		$userEmailRecipient['is_email_sent'] = 0;
		try {
			$result = $emailObj->send($data['message']);
			if($result) {
				$userEmailRecipient['is_email_sent'] = 1;
			}
		} catch (Exception $ex){
		}
		if(!empty($recipient['id']) && $userEmailRecipient['is_email_sent']) {
			$userEmailRecipient['user_email_id'] = $data['user_email_id'];
			$userEmailRecipient['user_id'] = $recipient['user_id'];
			$userEmailRecipient['email_address'] = $recipient['email_address'];
			$this->UserEmailRecipients->save($userEmailRecipient, ['validate'=>false]);

			$recipient['is_email_sent'] = 1;
			unset($recipient['modified']);
			$this->ScheduledEmailRecipients->save($recipient, ['validate'=>false]);
		}
	}
}