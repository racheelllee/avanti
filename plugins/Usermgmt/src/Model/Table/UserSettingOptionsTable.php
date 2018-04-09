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

class UserSettingOptionsTable extends UsermgmtAppTable {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		$this->belongsTo('Usermgmt.SettingOptions');
		$this->belongsTo('Usermgmt.UserSettings');
	}
	/**
	 * Used to get all setting options
	 *
	 * @access public
	 * @return array
	 */
	public function getUserSettingOptions($settingId, $sel=true) {
		$userSettingOptions = [];
		if($sel) {
			$userSettingOptions[''] = __('Select');
		}
		$result = $this->find()
				->select(['UserSettingOptions.id', 'SettingOptions.id', 'SettingOptions.title'])
				->where(['UserSettingOptions.user_setting_id'=>$settingId])
				->order(['SettingOptions.title'=>'ASC'])
				->contain(['SettingOptions'])
				->hydrate(false)
				->toArray();
		foreach($result as $row) {
			$userSettingOptions[$row['setting_option']['id']] = $row['setting_option']['title'];
		}
		return $userSettingOptions;
	}
}