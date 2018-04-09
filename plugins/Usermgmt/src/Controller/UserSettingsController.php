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

class UserSettingsController extends UsermgmtAppController {
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components = ['Usermgmt.Search'];
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
	public $searchFields = [
		'index'=>[
			'Usermgmt.UserSettings'=>[
				'UserSettings.display_name'=>[
					'type'=>'text',
					'label'=>'Setting Name',
					'inputOptions'=>['style'=>'width:300px;']
				],
				'UserSettings.category'=>[
					'type'=>'select',
					'condition'=>'=',
					'label'=>'Category',
					'model'=>'Usermgmt.UserSettings',
					'selector'=>'getSettingCategories'
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
		$this->loadModel('Usermgmt.UserSettings');
		if(isset($this->Security) && ($this->request->is('ajax') || $this->request['action'] == 'cakelog' || $this->request['action'] == 'editSetting')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all settings
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->paginate = ['limit'=>10, 'order'=>['UserSettings.id'=>'ASC']];

		// si no es un usuario AdminWebpoint que no pueda ver o modificar admin_group_id
		if($this->UserAuth->isAdmin())
			$this->Search->applySearch();
		else
			$this->Search->applySearch(['UserSettings.name != ' =>"admin_group_id" ] );

		//$this->Search->applySearch();
		$userSettings = $this->paginate($this->UserSettings)->toArray();
		$this->loadModel('Usermgmt.SettingOptions');
		foreach($userSettings as $key=>$row) {
			if($row['type'] == 'dropdown' || $row['type'] == 'radio') {
				$userSettings[$key]['value'] = $this->SettingOptions->getTitleById($row['value']);
			}
		}
		$this->set('userSettings', $userSettings);
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_settings');
		}
	}
	/**
	 * It is used to add setting
	 *
	 * @access public
	 * @return void
	 */
	public function addSetting() {
		if(!empty($this->request->data) && isset($this->request->data['UserSettings']['category_type'])) {
			if($this->request->data['UserSettings']['category_type'] == 'existing') {
				unset($this->request->data['UserSettings']['new_category']);
			} else if($this->request->data['UserSettings']['category_type'] == 'new') {
				unset($this->request->data['UserSettings']['category']);
			}
		}
		$settingEntity = $this->UserSettings->newEntity($this->request->data, ['validate'=>'forAdd']);
		if($this->request->is('post')) {
			$errors = $settingEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserSettings'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					if($settingEntity['category_type'] == 'new') {
						$settingEntity['category'] = $settingEntity['new_category'];
					}
					$settingEntity['name'] = strtolower($settingEntity['name']);
					if($this->UserSettings->save($settingEntity, ['validate'=>false])) {
						$this->Flash->success(__('New setting has been added successfully, please add value for it'));
						$this->redirect(['action'=>'editSetting', $settingEntity['id']]);
					} else {

						$this->Flash->error(__('Unable to update setting, please try again'));
					}
				}
			}
		}
		$settingCategories = $this->UserSettings->getSettingCategories();
		$settingInputTypes = $this->UserSettings->getSettingInputTypes();
		$this->set(compact('settingCategories', 'settingInputTypes', 'settingEntity'));
	}
	/**
	 * It is used to edit setting value
	 *
	 * @access public
	 * @param integer $settingId setting id
	 * @return void
	 */
	public function editSetting($settingId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($settingId) {
			$settingEntity = $this->UserSettings->find()
								->where(['UserSettings.id'=>$settingId])
								->contain(['UserSettingOptions'])
								->first();
			if(!empty($settingEntity)) {
				$this->loadModel('Usermgmt.UserSettingOptions');
				$this->loadModel('Usermgmt.SettingOptions');
				if(!empty($this->request->data) && isset($this->request->data['UserSettings']['category_type'])) {
					if($this->request->data['UserSettings']['category_type'] == 'existing') {
						unset($this->request->data['UserSettings']['new_category']);
					} else if($this->request->data['UserSettings']['category_type'] == 'new') {
						unset($this->request->data['UserSettings']['category']);
					}
					$selectedType = $this->request->data['UserSettings']['type'];
					$this->request->data['UserSettings']['value'] = $this->request->data['UserSettings'][$selectedType.'_value'];
				} 
				$this->UserSettings->patchEntity($settingEntity, $this->request->data, ['validate'=>'forAdd']);
				
				if($this->request->is(['put', 'post'])) { 
					$errors = $settingEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['UserSettings'] = $errors;
						}
						echo json_encode($response);exit;
					} else { 
						if(empty($errors)) {
							if(!empty($this->request->data['UserSettings']['options']) && in_array($settingEntity['type'], ['dropdown', 'radio'])) {
								$existingIds = []; 
								foreach($settingEntity['user_setting_options'] as $option) {
									$existingIds[$option['setting_option_id']] = $option['id'];
								}
								foreach($this->request->data['UserSettings']['options'] as $option) {
									$pos = strpos($option, 'newoption-');
									if($pos !== false) {
										$newoption = implode('', explode('newoption-', $option, 2));
										$settingOption = $this->SettingOptions->find()->where(['SettingOptions.title'=>$newoption])->first();
										if(empty($settingOption)) {
											$settingOption = $this->SettingOptions->newEntity();
											$settingOption['title'] = $newoption;
											$this->SettingOptions->save($settingOption, ['validate'=>false]);
										}
										if($settingEntity['value'] == $option) {
											$settingEntity['value'] = $settingOption['id'];
										}
										$option = $settingOption['id'];
									}
									if(isset($existingIds[$option])) {
										unset($existingIds[$option]);
									} else {
										$userSettingOption = $this->UserSettingOptions->newEntity();
										$userSettingOption['user_setting_id'] = $settingId;
										$userSettingOption['setting_option_id'] = $option;
										$this->UserSettingOptions->save($userSettingOption, ['validate'=>false]);
									}
								}
								if(!empty($existingIds)) {
									$this->UserSettingOptions->deleteAll(['user_setting_id'=>$settingId, 'id IN'=>$existingIds]);
								}
							}
							if($settingEntity['category_type'] == 'new') {
								$settingEntity['category'] = $settingEntity['new_category'];
							}
							if($settingEntity['type'] == 'upload'){
								$ext = explode(".", $settingEntity['upload_value']['name']);
								$img = 'FilesUserSettings_'.strtotime(date('Y-m-d H:i:s')).'.'.end($ext);
            					$ruta =  WWW_ROOT.'files/'.$img;
            					$tmp = $settingEntity['upload_value']['tmp_name'];
            					move_uploaded_file($tmp, $ruta);
            					$settingEntity['value'] = $img;
							}
							$settingEntity['name'] = strtolower($settingEntity['name']);
							if($this->UserSettings->save($settingEntity, ['validate'=>false])) {
								$this->__deleteCache();
								$this->Flash->success(__('Selected setting has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to update setting, please try again'));
							}
						}
					}
				} else {
					$this->request->data['UserSettings'][$settingEntity['type'].'_value'] = $settingEntity['value'];
				}
				$settingCategories = $this->UserSettings->getSettingCategories();
				$settingInputTypes = $this->UserSettings->getSettingInputTypes();
				$settingOptions = $this->SettingOptions->getSettingOptions(false);
				$userSettingOptions = $this->UserSettingOptions->getUserSettingOptions($settingId, false);
				$this->set(compact('settingId', 'settingCategories', 'settingInputTypes', 'userSettingOptions', 'settingEntity', 'settingOptions'));
			} else {
				$this->Flash->error(__('Invalid setting id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing setting id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to delete cache of permissions and used when any permission gets changed
	 *
	 * @access private
	 * @return void
	 */
	private function __deleteCache() {
		$iterator = new \RecursiveDirectoryIterator(CACHE);
		foreach(new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
			$path_info = pathinfo($file);
			if(!in_array($path_info['basename'], ['.svn', '.', '..'])) {
				if($path_info['dirname'] == TMP.'cache') {
					if(!is_dir($file->getPathname()) && strpos($path_info['basename'], 'UserMgmt_all_settings') !== false) {
						@unlink($file->getPathname());
					}
				}
			}
		}
	}
	/**
	 * It is used to display cake log files
	 *
	 * @access public
	 * @param string $filename file name
	 * @return void
	 */
	public function cakelog($filename=null) {
		$fullpath = LOGS;
		if($this->request->isPost()) {
			$fp = fopen($fullpath.$filename, "w");
			fwrite($fp, $this->request->data['UserSettings']['logfile']);
			fclose($fp);
			$this->Flash->success(__('{0} has been modified successfully', [$filename]));
			$this->redirect(['action'=>'cakelog']);
		}
		$logFiles = glob($fullpath."*.log");
		$this->set(compact('logFiles', 'filename'));
	}
	/**
	 * It is used to create backup of log file
	 *
	 * @access public
	 * @param string $filename file name
	 * @return void
	 */
	public function cakelogbackup($filename=null) {
		if($this->request->isPost()) {
			if(!empty($filename)) {
				$filepath = LOGS.$filename;
				if(file_exists($filepath)) {
					$pathinfo = pathinfo($filepath);
					$newfile = $pathinfo['filename'].'_'.date('d-M-Y_H-i', time()).'.'.$pathinfo['extension'];
					if(copy($filepath, LOGS.$newfile)) {
						$this->Flash->success(__('{0} has been copied to {1}', [$filename, $newfile]));
					} else {
						$this->Flash->error(__('{0} file could not be copied', [$filename]));
					}
				} else {
					$this->Flash->warning(__('{0} file does not exist', [$filename]));
				}
			} else {
				$this->Flash->error(__('Missing Filename'));
			}
		}
		$this->redirect(['action'=>'cakelog']);
	}
	/**
	 * It is used to delete log file
	 *
	 * @access public
	 * @param string $filename file name
	 * @return void
	 */
	public function cakelogdelete($filename=null) {
		if($this->request->isPost()) {
			if(!empty($filename)) {
				$filepath = LOGS.$filename;
				if(file_exists($filepath)) {
					if(unlink($filepath)) {
						$this->Flash->success(__('{0} has been deleted successfully', [$filename]));
					} else {
						$this->Flash->error(__('{0} file could not be deleted', [$filename]));
					}
				} else {
					$this->Flash->warning(__('{0} file does not exist', [$filename]));
				}
			} else {
				$this->Flash->error(__('Missing Filename'));
			}
		}
		$this->redirect(['action'=>'cakelog']);
	}
	/**
	 * It is used to make empty log file
	 *
	 * @access public
	 * @param string $filename file name
	 * @return void
	 */
	public function cakelogempty($filename=null) {
		if($this->request->isPost()) {
			if(!empty($filename)) {
				$filepath = LOGS.$filename;
				$f = @fopen($filepath, "r+");
				if($f !== false) {
					ftruncate($f, 0);
					fclose($f);
					$this->Flash->success(__('{0} has been emptied', [$filename]));
				} else {
					$this->Flash->warning(__('{0} file does not exist', [$filename]));
				}
			} else {
				$this->Flash->error(__('Missing Filename'));
			}
		}
		$this->redirect(['action'=>'cakelog']);
	}

	public function configuracion() {
	
		if($this->request->is('post')) {
			
			foreach ($this->request->data as $k => $value) {
				$setting = $this->UserSettings->find('all')
					->where([ 'UserSettings.name' => $k ])->first();

				if($setting){
					$setting->value = $value;
					$this->UserSettings->save($setting);
				}
			}

			$this->__deleteCache();
			$this->Flash->success(__('Las variables de sistema fueron actualizadas'));
		}

		$settings = $this->UserSettings->find('all')
								->where([ 'UserSettings.id IN' => explode(',', SETTINGS_IMAGENES) ])->toArray();

		$this->set(compact('settings'));
	}
}