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

class UserGroupsController extends UsermgmtAppController {
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
			'Usermgmt.UserGroups'=>[
				'UserGroups'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by group name, description',
					'condition'=>'multiple',
					'searchFields'=>['UserGroups.name', 'UserGroups.description'],
					'inputOptions'=>['style'=>'width:200px;']
				],
				'UserGroups.registration_allowed'=>[
					'type'=>'select',
					'label'=>'Registration Allowed',
					'options'=>[''=>'Select', '1'=>'Yes', '0'=>'No']
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
		$this->loadModel('Usermgmt.UserGroups');
		if(isset($this->Security) && $this->request->is('ajax')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays all user groups
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->paginate = ['limit'=>10, 'order'=>['UserGroups.id'=>'ASC']];

		if($this->UserAuth->isAdmin())
			$this->Search->applySearch();
		else
			$this->Search->applySearch(['UserGroups.id != ' =>ADMIN_GROUP_ID ] );

		$userGroups = $this->paginate($this->UserGroups)->toArray();
		$allGroups = $this->UserGroups->getAllGroups(false);
		$page = "Groups(s)";
		$this->set(compact('allGroups', 'userGroups','page'));
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_user_groups');
		}
	}
	/**
	 * It is used to add a new group
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		$userGroupEntity = $this->UserGroups->newEntity($this->request->data, ['validate'=>'forAdd']);
		if($this->request->is('post')) {
			$errors = $userGroupEntity->errors();
			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['UserGroups'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					if($this->UserGroups->save($userGroupEntity, ['validate'=>false])) {
						$this->Flash->success(__('The group has been added successfully'));
						$this->redirect(['action'=>'index']);
					} else {
						$this->Flash->error(__('Unable to add group, please try again'));
					}
				}
			}
		}
		$page = "Add Group";
		$parentGroups = $this->UserGroups->getParentGroups();
		$this->set(compact('parentGroups', 'userGroupEntity', 'page'));
	}
	/**
	 * It is used to edit existing group
	 *
	 * @access public
	 * @param integer $userGroupId user group id
	 * @return void
	 */
	public function edit($userGroupId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($userGroupId) {
			$userGroupEntity = $this->UserGroups->find()->where(['UserGroups.id'=>$userGroupId])->first();
			if(!empty($userGroupEntity)) {
				$this->UserGroups->patchEntity($userGroupEntity, $this->request->data, ['validate'=>'forAdd']);
				if($this->request->is(['put', 'post'])) {
					$errors = $userGroupEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['UserGroups']  = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->UserGroups->save($userGroupEntity, ['validate'=>false])) {
								$this->Flash->success(__('The group has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to update group, please try again.'));
							}
						}
					}
				}
				$parentGroups = $this->UserGroups->getParentGroups($userGroupId);
				$this->set(compact('userGroupEntity', 'parentGroups'));
			} else {
				$this->Flash->error(__('Invalid group id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing group id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to delete existing group, it also checks if any user is associated with group before delete
	 *
	 * @access public
	 * @param integer $userGroupId user group id
	 * @return void
	 */
	public function delete($userGroupId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userGroupId)) {
			$userGroup = $this->UserGroups->find()->where(['UserGroups.id'=>$userGroupId])->first();
			if(!empty($userGroup)) {
				if($this->request->is('post')) {
					$this->loadModel('Usermgmt.Users');
					if($this->Users->isUserAssociatedWithGroup($userGroupId)) {
						$this->Flash->warning(__('Sorry some users are associated with this group, You cannot delete this group'));
					} else {
						if(!$this->UserGroups->exists(['UserGroups.parent_id'=>$userGroupId])) {
							if($this->UserGroups->delete($userGroup)) {
								$this->Flash->success(__('Selected group has been deleted successfully'));
							} else {
								$this->Flash->warning(__('Selected group could not be deleted, please try again'));
							}
						} else {
							$this->Flash->error(__('Sorry sub group(s) exist for this group, You cannot delete this group'));
						}
					}
				}
			} else {
				$this->Flash->error(__('Invalid User Group Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Group Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
}