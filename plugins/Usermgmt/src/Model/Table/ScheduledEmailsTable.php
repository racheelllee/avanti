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
namespace Usermgmt\Model\Table;
use Usermgmt\Model\Table\UsermgmtAppTable;
use Cake\Validation\Validator;
use Cake\Validation\Validation;

class ScheduledEmailsTable extends UsermgmtAppTable {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		$this->belongsTo('Usermgmt.Users', ['foreignKey'=>'scheduled_by']);
		$this->hasMany('Usermgmt.ScheduledEmailRecipients', ['dependent'=>true]);
	}
	public function validationForSend($validator) {
		$validator
			->notEmpty('to', __('Please enter to email'))
			->notEmpty('from_name', __('Please enter from name'))
			->notEmpty('from_email', __('Please enter from email'))
			->notEmpty('subject', __('Please enter email subject'))
			->notEmpty('message', __('Please enter email message'))
			->notEmpty('schedule_date', __('Please enter schedule date'))
			->add('to', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				]
			])
			->add('from_email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				]
			])
			->allowEmpty('cc_to')
			->add('cc_to', [
				'validFormat'=>[
					'rule'=>'checkValidEmails',
					'provider'=>'table',
					'message'=>__('Please enter valid email(s)'),
					'last'=>true
				]
			])
			->add('schedule_date', [
				'mustBeFutureDate'=>[
					'rule'=>'checkForScheduledDate',
					'provider'=>'table',
					'message'=>__('Please enter future date'),
					'last'=>true
				]
			]);
		return $validator;
	}
	/**
	 * Used to check scheduled date
	 *
	 * @access public
	 * @return boolean
	 */
	public function checkForScheduledDate($value, $context) {
		if(is_object($value)) {
			$value = $value->format('Y-m-d H:i:s');
		}
		if(!empty($value) && strtotime($value) < time()) {
			return false;
		}
		return true;
	}
}