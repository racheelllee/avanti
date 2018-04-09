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

class UserSettingsTable extends UsermgmtAppTable {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		$this->hasMany('Usermgmt.UserSettingOptions');
		$this->belongsTo('Usermgmt.SettingOptions', ['foreignKey'=>'value']);
	}
	public function validationForAdd($validator) {
		$validator
			->notEmpty('category_type', __('Please select category type'))
			->notEmpty('category', __('Please select category'))
			->notEmpty('new_category', __('Please enter new category'))
			->notEmpty('type', __('Please select input type'))
			->notEmpty('name', __('Please enter setting name'))
			->add('name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid name'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This name already exist')
				]
			])
			->notEmpty('display_name', __('Please enter setting display name'));
		return $validator;
	}
	/**
	 * Used to get all settings
	 *
	 * @access public
	 * @return array
	 */
	public function getAllUserSettings() {
		$settings = [];
		$result = $this->find()
				->select(['UserSettings.name', 'UserSettings.value', 'UserSettings.type'])
				->hydrate(false)
				->toArray();
		foreach($result as $row) {
			if($row['type'] == 'dropdown' || $row['type'] == 'radio') {
				$row['value'] = $this->SettingOptions->getTitleById($row['value']);
			}
			$settings[$row['name']]['value'] = trim($row['value']);
		}
		return $settings;
	}
	/**
	 * Used to get settings categories
	 *
	 * @access public
	 * @return array
	 */
	public function getSettingCategories($select=true) {
		$settingCategories = [];
		$defaultCategories = ['FACEBOOK'=>'Facebook', 'TWITTER'=>'Twitter', 'GOOGLE'=>'Google', 'YAHOO'=>'Yahoo', 'LINKEDIN'=>'LinkedIn', 'FOURSQUARE'=>'Foursquare', 'RECAPTCHA'=>'Recaptcha', 'EMAIL'=>'Email', 'PERMISSION'=>'Permission', 'GROUP'=>'Group', 'USER'=>'User', 'SITE'=>'Site', 'OTHER'=>'Other'];
		$result = $this->find()
				->select(['UserSettings.category'])
				->where(['UserSettings.category IS NOT NULL', 'UserSettings.category !='=>''])
				->group(['UserSettings.category'])
				->order(['UserSettings.category'=>'ASC'])
				->hydrate(false)
				->toArray();
		if($select) {
			$settingCategories[''] = __('Select Category');
		}
		foreach($result as $row) {
			$settingCategories[$row['category']] = ucwords(strtolower($row['category']));
		}
		$settingCategories = array_merge($settingCategories, $defaultCategories);
		ksort($settingCategories);
		return $settingCategories;
	}
	/**
	 * Used to get settings input types
	 *
	 * @access public
	 * @return array
	 */
	public function getSettingInputTypes($select=true) {
		$inputTypes = [''=>__('Select Input Type'), 'input'=>__('Text Input'), 'checkbox'=>__('Checkbox Input'), 'dropdown'=>__('Dropdown Input'), 'radio'=>__('Radio Input'), 'textarea'=>__('Textarea Input'), 'tinymce'=>__('Tinymce Editor'), 'ckeditor'=>__('CK Editor'), 'upload'=>__('Upload')];
		if(!$select) {
			unset($inputTypes['']);
		}
		return $inputTypes;
	}
}