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

class SettingOptionsController extends UsermgmtAppController {
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
	 * This controller uses search filters in following functions for ex index, online function
	 *
	 * @var array
	 */
	public $searchFields = [
		'index'=>[
			'Usermgmt.SettingOptions'=>[
				'SettingOptions'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by title',
					'condition'=>'multiple',
					'searchFields'=>['SettingOptions.title'],
					'inputOptions'=>['style'=>'width:200px;']
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
		$this->loadModel('Usermgmt.SettingOptions');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all setting options
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->paginate = ['limit'=>50, 'order'=>['SettingOptions.title'=>'ASC']];
		$this->Search->applySearch();
		$settingOptions = $this->paginate($this->SettingOptions)->toArray();
		$this->set(compact('settingOptions'));
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_setting_options');
		}
	}
	/**
	 * It is used to add setting option
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		$settingOptionEntity = $this->SettingOptions->newEntity($this->request->data, ['validate'=>'forAdd']);
		if($this->request->is('post')) {
			$errors = $settingOptionEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['SettingOptions'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					if($this->SettingOptions->save($settingOptionEntity, ['validate'=>false])) {
						$this->Flash->success(__('The Setting Option has been added successfully'));
						$this->redirect(['action'=>'add']);
					} else {
						$this->Flash->error(__('Unable to save Setting Option, please try again'));
					}
				}
			}
		}
		$this->set(compact('settingOptionEntity'));
	}
	/**
	 * It is used to edit setting option
	 *
	 * @access public
	 * @param integer $settingOptionId setting option id
	 * @return void
	 */
	public function edit($settingOptionId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($settingOptionId) {
			$settingOptionEntity = $this->SettingOptions->find()->where(['SettingOptions.id'=>$settingOptionId])->first();
			if(!empty($settingOptionEntity)) {
				$this->SettingOptions->patchEntity($settingOptionEntity, $this->request->data, ['validate'=>'forAdd']);
				if($this->request->is(['post', 'put'])) {
					$errors = $settingOptionEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['SettingOptions'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->SettingOptions->save($settingOptionEntity, ['validate'=>false])) {
								$this->Flash->success(__('The Setting Option has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to save Setting Option, please try again'));
							}
						}
					}
				}
			} else {
				$this->Flash->error(__('Invalid Setting Option id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing Setting Option id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
		$this->set(compact('settingOptionEntity'));
	}
	/**
	 * It is used to delete setting option
	 *
	 * @access public
	 * @param integer $settingOptionId setting option id
	 * @return void
	 */
	public function delete($settingOptionId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($settingOptionId)) {
			$settingOption = $this->SettingOptions->find()->where(['SettingOptions.id'=>$settingOptionId])->first();
			if(!empty($settingOption)) {
				if($this->request->is('post')) {
					$this->loadModel('UserSettingOptions');
					if(!$this->UserSettingOptions->exists(['UserSettingOptions.setting_option_id'=>$settingOptionId])) {
						if($this->SettingOptions->delete($settingOption)) {
							$this->Flash->success(__('Selected setting option is deleted successfully'));
						} else {
							$this->Flash->error(__('Unable to delete setting option, please try again'));
						}
					} else {
						$this->Flash->error(__('This setting option exists in other tables so cannot be deleted'));
					}
				}
			} else {
				$this->Flash->error(__('Invalid Setting Option Id'));
			}
		} else {
			$this->Flash->error(__('Missing Setting Option Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
}