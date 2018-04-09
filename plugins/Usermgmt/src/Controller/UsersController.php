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
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Time;

class UsersController extends UsermgmtAppController {
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components = ['Usermgmt.Search', 'Usermgmt.UserConnect'];
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
			'Usermgmt.Users'=>[
				'Users'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Buscar por nombre, usuario, email',
					'condition'=>'multiple',
					'searchFields'=>['Users.first_name', 'Users.last_name', 'Users.username', 'Users.email'],
					'searchFunc'=>['plugin'=>'Usermgmt', 'controller'=>'Users', 'function'=>'indexSearch'],
					'inputOptions'=>['style'=>'width:200px;']
				]/*,
				'Users.id'=>[
					'type'=>'text',
					'condition'=>'=',
					'label'=>'User Id',
					'inputOptions'=>['style'=>'width:50px;']
				],
				'Users.user_group_id'=>[
					'type'=>'select',
					'condition'=>'comma',
					'label'=>'Group',
					'model'=>'Usermgmt.UserGroups',
					'selector'=>'getUserGroups'
				],
				'Users.email_verified'=>[
					'type'=>'select',
					'label'=>'Email Verified',
					'options'=>[''=>'Select', '0'=>'No', '1'=>'Yes']
				],
				'Users.active'=>[
					'type'=>'select',
					'label'=>'Status',
					'options'=>[''=>'Select', '1'=>'Active', '0'=>'Inactive']
				],
				'Users.created1'=>[
					'type'=>'text',
					'condition'=>'>=',
					'label'=>'From',
					'searchField'=>'created',
					'inputOptions'=>['style'=>'width:100px;', 'class'=>'datepicker']
				],
				'Users.created2'=>[
					'type'=>'text',
					'condition'=>'<=',
					'label'=>'To',
					'searchField'=>'created',
					'inputOptions'=>['style'=>'width:100px;', 'class'=>'datepicker']
				]*/
			]
		],
		'online'=>[
			'Usermgmt.UserActivities'=>[
				'UserActivities'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by name, email, ip address',
					'condition'=>'multiple',
					'searchFields'=>['Users.first_name', 'Users.last_name', 'Users.email', 'UserActivities.ip_address'],
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
		$this->loadModel('Usermgmt.Users');
		$this->Users->userAuth = $this->UserAuth;
		$this->Auth->allow(['login', 'logout', 'register', 'userVerification', 'forgotPassword', 'activatePassword', 'accessDenied', 'emailVerification']);
		if(isset($this->Security) && ($this->request->is('ajax') || $this->request['action'] == 'login' || $this->request['action'] == 'addMultipleUsers')) {
			$this->Security->config('unlockedActions', [$this->request['action']]);
		}
	}
	/**
	 * It displays dashboard for logged in user
	 *
	 * @access public
	 * @return array
	 */
	public function dashboard() {
		/* Do here something for user */
	}
	/**
	 * It displays all userss
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->paginate = ['order'=>['Users.id'=>'DESC']];
		
		$user = $this->UserAuth->getUser();

		if($this->UserAuth->isAdmin())
			$this->Search->applySearch(['Users.deleted' => FALSE]);
		else
			$this->Search->applySearch(['Users.user_group_id != ' => ADMIN_GROUP_ID, 'Users.deleted' => FALSE]);
		
		$users = $this->paginate($this->Users)->toArray();
		$this->loadModel('Usermgmt.UserGroups');
		foreach($users as $key=>$user) {
			$users[$key]['user_group_name'] = $this->UserGroups->getGroupsByIds($user['user_group_id']);
		}
		$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forAddUser', 'associated'=>['UserDetails'=>['validate'=>'forAddUser']]]);
		$this->loadModel('Usermgmt.UserGroups');
		$userGroups = $this->UserGroups->getUserGroups(false);
		
		$options = [['value'=>'M', 'text'=>'Masculino'], ['value'=>'F', 'text'=>'Femenino']];

		$page = "List of Users";

		$days = $this->Users->getDays();
		$months = $this->Users->getMonth();

		$this->set(compact('users', 'userEntity', 'userGroups', 'options', 'page', 'days', 'months'));
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/all_users');
		}
	}
	/**
	 * It displays search suggestions on all users index page
	 *
	 * @access public
	 * @return void
	 */
	public function indexSearch() {
		$resultToPrint = [];
		if($this->request->is('ajax')) {
			$results = [];
			if(isset($_GET['term'])) {
				$query = $_GET['term'];
				$results = $this->Users->find()
							->select(['Users.username', 'Users.first_name', 'Users.last_name', 'Users.email'])
							->where(['OR'=>[['Users.username LIKE'=>$query.'%'], ['Users.first_name LIKE'=>$query.'%'], ['Users.last_name LIKE'=>$query.'%'], ['Users.email LIKE'=>'%'.$query.'%@%']]])
							->hydrate(false)
							->toArray();
			}
			$usernames = $names = $emails = [];
			foreach($results as $res) {
				if(stripos($res['first_name'], $query) !== false || stripos($res['last_name'], $query) !== false) {
					$names[] = $res['first_name'].' '.$res['last_name'];
				}
				if(stripos($res['email'], $query) !== false) {
					$emails[] = $res['email'];
				}
				if(stripos($res['username'], $query) !== false) {
					$usernames[] = $res['username'];
				}
			}
			$names = array_unique($names);
			$emails = array_unique($emails);
			$usernames = array_unique($usernames);
			$res = array_merge($usernames, $names, $emails);
			foreach($res as $row) {
				$resultToPrint[] = ['name'=>$row];
			}
		}
		echo json_encode($resultToPrint);exit;
	}
	/**
	 * It displays all online users with in specified time
	 *
	 * @access public
	 * @return void
	 */
	public function online() {
		$this->loadModel('Usermgmt.UserActivities');
		$cond = [];
		$cond['UserActivities.modified >'] = date('Y-m-d H:i:s', strtotime('-'.VIEW_ONLINE_USER_TIME.' minutes', time()));
		$cond['UserActivities.logout'] = 0;
		$this->paginate = ['limit'=>10, 'order'=>['UserActivities.last_action'=>'DESC'], 'conditions'=>$cond, 'contain'=>['Users']];
		$this->Search->applySearch($cond);
		$users = $this->paginate($this->UserActivities)->toArray();
		$page = 'Online Users';
		$this->set(compact('users','page'));
		if($this->request->is('ajax')) {
			$this->viewBuilder()->layout('ajax');
			$this->render('/Element/online_users');
		}
	}
	/**
	 * It is used to add user
	 *
	 * @access public
	 * @return void
	 */
	public function addUser() {
		$this->loadModel('Usermgmt.UserDetails');
		if(!empty($this->request->data)) {
			if(is_array($this->request->data['Users']['user_group_id'])) {
				sort($this->request->data['Users']['user_group_id']);
				$this->request->data['Users']['user_group_id'] = implode(',', $this->request->data['Users']['user_group_id']);
			}
		}

		$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forAddUser', 'associated'=>['UserDetails'=>['validate'=>'forAddUser']]]);

		$userEntity['password'] = $this->UserAuth->generatePassword();
		
		if($this->request->is('post')) {
			
			$errors = $userEntity->errors();

			if($this->request->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success', 'entity'=>$userEntity];
				} else {
					$response = ['error'=>1, 'message'=>'failure', 'entity'=>$userEntity];
					$response['data']['Users'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					$userEntity['active'] = 1;
					$userEntity['email_verified'] = 1;
					$userEntity['created_by'] = $this->UserAuth->getUserId();
					$password = $userEntity['password'];
					$userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);
					$userEntity['first_name'] = $userEntity['first_name'];

		            if(!empty($this->request->data['Users']['entrydate'])){
		                $userEntity['entrydate'] = new Time(str_replace('/','-', @$this->request->data['Users']['entrydate']),  DEFAULT_TIME_ZONE  );
		            }
		          	
					if($this->Users->save($userEntity, ['validate'=>false])) {
						if(!isset($userEntity['user_detail']['id'])) {
							$userId = $userEntity['id'];
							$this->loadModel('Usermgmt.UserDetails');
							$userDetailEntity = $this->UserDetails->newEntity();
							$userDetailEntity['user_id'] = $userId;
							$this->UserDetails->save($userDetailEntity, ['validate'=>false]);

							//$this->Users->sendRegistrationMail($userEntity, $password);
							$this->Users->sendWellcomePasswordMail($userEntity);
						}
						$this->Flash->success(__('The user has been added successfully'));
						$this->redirect('/usermgmt/users');
					} else {
						$this->Flash->error(__('Unable to save user, please try again'));
					}
				}
			}
		}
		$this->loadModel('Usermgmt.UserGroups');
		$userGroups = $this->UserGroups->getUserGroups(false);

		$genders = [['value'=>'M', 'text'=>'Masculino'], ['value'=>'F', 'text'=>'Femenino']];

		$this->loadModel('Departments');
		$departamentos = $this->Departments->getDepartamentos(false);

		$days = $this->Users->getDays();
		$months = $this->Users->getMonth();

		$this->set(compact('userGroups', 'userEntity','genders','departamentos','days','months'));
	}
	/**
	 * It is used to edit user
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function editUser($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($userId) {
			$userEntity = $this->Users->getUserById($userId);
			if(!empty($userEntity)) {
				$this->loadModel('Usermgmt.UserDetails');
				if(!empty($this->request->data)) {
					if(is_array($this->request->data['Users']['user_group_id'])) {
						sort($this->request->data['Users']['user_group_id']);
						$this->request->data['Users']['user_group_id'] = implode(',', $this->request->data['Users']['user_group_id']);
					}
				}
				$oldUserGroupId = $userEntity['user_group_id'];
				$this->Users->patchEntity($userEntity, $this->request->data, ['validate'=>'forEditUser', 'associated'=>['UserDetails'=>['validate'=>'forEditUser']]]);
				if($this->request->is(['post', 'put'])) {
					$errors = $userEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['Users'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if(!empty($this->request->data['Users']['photo_file']['tmp_name']) && is_uploaded_file($this->request->data['Users']['photo_file']['tmp_name']))
							{
								$path_info = pathinfo($this->request->data['Users']['photo_file']['name']);
								chmod($this->request->data['Users']['photo_file']['tmp_name'], 0644);
								$photo = time().mt_rand().".".$path_info['extension'];
								$fullpath = WWW_ROOT."library".DS.IMG_DIR;
								if(!is_dir($fullpath)) {
									mkdir($fullpath, 0777, true);
								}
								move_uploaded_file($this->request->data['Users']['photo_file']['tmp_name'], $fullpath.DS.$photo);
								$existing_photo = $userEntity['photo'];
								$userEntity['photo'] = $photo;
								if(!empty($existing_photo) && file_exists($fullpath.DS.$existing_photo)) {
									unlink($fullpath.DS.$existing_photo);
								}
							}
							$userEntity['modified_by'] = $this->UserAuth->getUserId();
							if($oldUserGroupId != $userEntity['user_group_id']) {
								$this->loadModel('Usermgmt.UserActivities');
								$this->UserActivities->updateAll(['logout'=>1], ['user_id'=>$userId]);
							}
	
							if(!empty($this->request->data['Users']['entrydate'])){
				                $userEntity['entrydate'] = new Time(str_replace('/','-', @$this->request->data['Users']['entrydate']),  DEFAULT_TIME_ZONE  );
				            }

							if($this->Users->save($userEntity, ['validate'=>false])) {
								$this->Flash->success(__('The user has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to save user, please try again'));
							}
						}
					}
				} else {
					if(!empty($userEntity['bday'])) {
						$userEntity['bday'] = $userEntity['bday']->format('Y-m-d');
					}
					if(!empty($userEntity['user_group_id'])) {
						$userEntity['user_group_id'] = explode(',', $userEntity['user_group_id']);
					}
				}
			} else {
				$this->Flash->error(__('Invalid user id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing user id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
		$this->loadModel('Usermgmt.UserGroups');
		$userGroups = $this->UserGroups->getUserGroups(false);
		$genders = [['value'=>'M', 'text'=>'Masculino'], ['value'=>'F', 'text'=>'Femenino']];

		$this->loadModel('Departments');
		$departamentos = $this->Departments->getDepartamentos(false);

		$days = $this->Users->getDays();
		$months = $this->Users->getMonth();

		$this->set(compact('userGroups', 'userEntity', 'genders','departamentos','days','months'));
	}
	/**
	 * It displays user's full details
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function viewUser($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if($userId) {
			$user = $this->Users->getUserById($userId);
			if(!empty($user)) {
				$this->loadModel('Usermgmt.UserGroups'); 
				$user['group_name'] = $this->UserGroups->getGroupsByIds($user['user_group_id']);
				$user['created_by'] = $this->Users->getNameById($user['created_by']);
			} else {
				$this->Flash->error(__('Invalid user id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing user id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
		$days = $this->Users->getDays();
		$months = $this->Users->getMonth();
		$this->loadModel('Departments');
		$departamentos = $this->Departments->getDepartamentos(false);
		
		$this->set(compact('user', 'userId','months','days','departamentos'));
	}
	/**
	 * It is used to delete user
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function deleteUser($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			
			$user->deleted = TRUE;
			$user->email = time()."_borrado_".$user->email;

			if(!empty($user)) {
				if($this->request->is('post')) {
					if($this->Users->save($user)) {
						$this->loadModel('UserDetails');
						$this->loadModel('LoginTokens');
						$this->loadModel('UserActivities');
						$this->UserDetails->deleteAll(['user_id'=>$userId]);
						$this->LoginTokens->deleteAll(['user_id'=>$userId]);
						$this->UserActivities->updateAll(['deleted'=>1], ['user_id'=>$userId]);
						$this->Flash->success(__('Selected user is deleted successfully'));
					} else {
						$this->Flash->error(__('Unable to delete user, please try again'));
					}
				}
			} else {
				$this->Flash->error(__('Invalid User Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
	/**
	 * It is used to activate user
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function setActive($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				if($this->request->is('post')) {
					$userEntity = $this->Users->newEntity();
					$userEntity['id'] = $userId;
					$userEntity['active'] = 1;
					$this->Users->save($userEntity, ['validate'=>false]);
					$this->loadModel('Usermgmt.UserActivities');
					$this->UserActivities->updateAll(['logout'=>0], ['user_id'=>$userId]);
					$this->Flash->success(__('Selected user is activated successfully'));
				}
			} else {
				$this->Flash->error(__('Invalid User Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
	/**
	 * It is used to inactivate user
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function setInactive($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				if($this->request->is('post')) {
					$userEntity = $this->Users->newEntity();
					$userEntity['id'] = $userId;
					$userEntity['active'] = 0;
					$this->Users->save($userEntity, ['validate'=>false]);
					$this->loadModel('Usermgmt.UserActivities');
					$this->UserActivities->updateAll(['logout'=>1], ['user_id'=>$userId]);
					$this->Flash->success(__('Selected user is de-activated successfully'));
				}
			} else {
				$this->Flash->error(__('Invalid User Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
	/**
	 * It is used to mark verified email of user from all users page
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function verifyEmail($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if($user) {
				if($this->request->is('post')) {
					$userEntity = $this->Users->newEntity();
					$userEntity['id'] = $userId;
					$userEntity['email_verified'] = 1;
					$this->Users->save($userEntity, ['validate'=>false]);
					$this->Flash->success(__('Email of selected user is verified successfully'));
					$this->redirect(['action'=>'index', 'page'=>$page]);
				}
			} else {
				$this->Flash->error(__('Invaid User Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to change password of user by admin
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function changeUserPassword($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forChangeUserPassword']);
				if($this->request->is('post')) {
					$errors = $userEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['Users'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							$userEntity['id'] = $userId;
							$userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);
							$this->Users->save($userEntity, ['validate'=>false]);
							$this->loadModel('Usermgmt.LoginTokens');
							$this->LoginTokens->deleteAll(['user_id'=>$userId]);
							$this->Flash->success(__('Password for {0} changed successfully', [$user['first_name'].' '.$user['last_name']]));
							$this->redirect(['action'=>'index', 'page'=>$page]);
						}
					}
				}
				$this->set(compact('userEntity', 'user'));
			} else {
				$this->Flash->error(__('Invalid User Id'));
				$this->redirect(['action'=>'index', 'page'=>$page]);
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
			$this->redirect(['action'=>'index', 'page'=>$page]);
		}
	}
	/**
	 * It is used to logout user by Admin from online users page
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return void
	 */
	public function logoutUser($userId=null) {
		$page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				if($this->request->is('post')) {
					$this->loadModel('Usermgmt.UserActivities');
					$this->UserActivities->updateAll(['logout'=>1], ['user_id'=>$userId]);
					//$this->Flash->success(__('User is successfully signed out'));
				}
			} else {
				$this->Flash->error(__('Invalid User Id'));
			}
		} else {
			$this->Flash->error(__('Missing User Id'));
		}
		$this->redirect(['action'=>'online', 'page'=>$page]);
	}
	/**
	 *  It is used to view user's permissions
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function viewUserPermissions($userId) {
		$name = '';
		$permissions = [];
		if(!empty($userId)) {
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				$name = trim($user['first_name'].' '.$user['last_name']);
				$userGroupIDArray = array_map('trim', explode(',', $user['user_group_id']));
				$this->loadModel('Usermgmt.UserGroupPermissions');
				$result = $this->UserGroupPermissions->find()->where(['UserGroupPermissions.user_group_id IN'=>$userGroupIDArray, 'UserGroupPermissions.allowed'=>1])->order(['UserGroupPermissions.plugin'=>'ASC', 'UserGroupPermissions.controller'=>'ASC'])->contain(['UserGroups'])->toArray();
				foreach($result as $row) {
					if(empty($row['plugin'])) {
						$conAct = $row['controller'].'/'.$row['action'];
					} else {
						$conAct = $row['plugin'].'/'.$row['controller'].'/'.$row['action'];
					}
					if(isset($permissions[$conAct])) {
						$permissions[$conAct]['group'] .= ', '.$row['user_group']['name'];
					} else {
						$permissions[$conAct]['plugin'] = $row['plugin'];
						$permissions[$conAct]['controller'] = $row['controller'];
						$permissions[$conAct]['action'] = $row['action'];
						$permissions[$conAct]['group'] = $row['user_group']['name'];
					}
				}
			}
		}
		$this->set(compact('permissions', 'name'));
	}
	/**
	 * It is used to upload csv file to add multiple users
	 *
	 * @access public
	 * @return void
	 */
	public function uploadCsv() {
		if($this->request->is('post')) {
			if(!empty($this->request->data['csv_file']['tmp_name']) && is_uploaded_file($this->request->data['csv_file']['tmp_name'])) {
				$path_info = pathinfo($this->request->data['csv_file']['name']);
				if(strtolower($path_info['extension']) == 'csv') {
					chmod($this->request->data['csv_file']['tmp_name'], 0644);
					$filename = time().".".$path_info['extension'];
					$fullpath = WWW_ROOT."files".DS."csv_users";
					if(!is_dir($fullpath)) {
						mkdir($fullpath, 0777, true);
					}
					move_uploaded_file($this->request->data['csv_file']['tmp_name'], $fullpath.DS.$filename);
					$this->redirect(['action'=>'addMultipleUsers', $filename]);
				} else {
					$this->Flash->warning(__('Please upload CSV file only'));
				}
			} else {
				$this->Flash->error(__('Please upload CSV file'));
			}
		}
		$this->loadModel('Usermgmt.UserGroups');
		$userGroups = $this->UserGroups->getUserGroups(false);
		$genders = $this->Users->getGenders(false);
		$page = "Add Multiple Users";
		$this->set(compact('userGroups', 'genders', 'page'));
	}
	/**
	 * It is used to add multiple users by Admin
	 *
	 * @access public
	 * @param string $csv_file csv file name
	 * @return void
	 */
	public function addMultipleUsers($csv_file=null) {
		$this->set('csv_file', $csv_file);
		if($csv_file) {
			$fullpath = WWW_ROOT."files".DS."csv_users";
			if(file_exists($fullpath.DS.$csv_file)) {
				$userEntities = $this->Users->newEntity();
				$users = [];
				if($this->request->is('post')) {
					$selectedUsersCount = 0;
					$this->Users->multiUsers = $this->request->data;
					if(isset($this->request->data['Users'])) {
						foreach($this->request->data['Users'] as $key=>$row) {
							if(is_array($row['user_group_id'])) {
								sort($row['user_group_id']);
								$this->request->data['Users'][$key]['user_group_id'] = implode(',', $row['user_group_id']);
							}
							if(!empty($row['bday'])) {
								$this->request->data['Users'][$key]['bday'] = new Time($row['bday']);
							}
							if(isset($row['usercheck']) && $row['usercheck']) {
								$selectedUsersCount += 1;
							}
						}
					}
					if($selectedUsersCount > 0) {
						$userEntities = $this->Users->patchEntities($userEntities, $this->request->data['Users'], ['validate'=>'forMultipleUsers', 'associated'=>['UserDetails'=>['validate'=>'forMultipleUsers']]]);
					}
					$errors = [];
					foreach($userEntities as $key=>$userEntity) {
						$userError = $userEntity->errors();
						if(isset($userEntity['usercheck']) && $userEntity['usercheck']) {
							if(!empty($userError)) {
								$errors[$key] = $userError;
							}
						} else {
							unset($userEntities[$key]);
						}
					}
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							foreach($errors as $key=>$val) {
								foreach($val as $k=>$v) {
									$response['data']['Users'][$key.'_'.$k] = $v;
								}
							}
						}
						echo json_encode($response);exit;
					} else {
						foreach($this->request->data['Users'] as $key=>$row) {
							if(!is_array($row['user_group_id'])) {
								$this->request->data['Users'][$key]['user_group_id']  = explode(',', $row['user_group_id']);
							}
						}
						if($selectedUsersCount > 0) {
							if(empty($errors)) {
								foreach($userEntities as $key=>$row) {
									$userEntity = $row;
									$userEntity['password'] = $this->UserAuth->makeHashedPassword($row['password']);
									$userEntity['active'] = 1;
									$userEntity['email_verified'] = 1;
									$userEntity['created_by'] = $this->UserAuth->getUserId();
									$this->Users->save($userEntity, ['validate'=>false, 'associated'=>['UserDetails'=>['validate'=>false]]]);
								}
								$this->Flash->success(__('All users information have been saved'));
								$this->redirect(['action'=>'index']);
							}
						} else {
							$this->Flash->warning(__('Please select at least one user to add'));
						}
					}
				} else {
					$i = $j = 0;
					$dataFound = false;
					$fields1 = $fields2 = [];
					if(($handle = fopen($fullpath.DS.$csv_file, "r")) !== false) {
						while(($data = fgetcsv($handle, 1000, ",")) !== false) {
							if($i == 0) {
								$fields1 = $data;
								if(!empty($data[0])) {
									$dataFound = true;
								}
								foreach($data as $key=>$val) {
									$val = trim($val);
									if(in_array($val, ['user_group_id', 'first_name', 'last_name', 'username', 'email', 'password', 'gender', 'bday'])) {
										$fields2[$key] = null;
									} else if(in_array($val, ['location', 'cellphone'])) {
										$fields2[$key] = 'user_detail';
									}
								}
							} else {
								if($dataFound) {
									foreach($data as $key=>$val) {
										$val = trim($val);
										if($fields1[$key] == 'bday') {
											$val = date('Y-m-d', strtotime($val));
										}
										if($fields1[$key] == 'user_group_id') {
											$val = explode(',', $val);
										}
										if(is_null($fields2[$key])) {
											$users['Users'][$j][$fields1[$key]] = $val;
										} else {
											$users['Users'][$j][$fields2[$key]][$fields1[$key]] = $val;
										}
										$users['Users'][$j]['usercheck'] = 1;
									}
									$j++;
								}
							}
							$i++;
						}
						fclose($handle);
					}
					if(!empty($users)) {
						$this->request->data = $users;
						$this->request->data['Select']['all'] = 1;
					} else {
						$this->Flash->info(__('Invalid or empty data in CSV file, please try again'));
						$this->redirect(['action'=>'uploadCsv']);
					}
				}
				$this->loadModel('Usermgmt.UserGroups');
				$userGroups = $this->UserGroups->getUserGroups();
				$genders = $this->Users->getGenders();
				$this->set(compact('userGroups', 'genders', 'userEntities', 'users'));
			} else {
				$this->Flash->info(__('CSV file was not uploaded or does not exist, please try again'));
				$this->redirect(['action'=>'uploadCsv']);
			}
		} else {
			$this->redirect(['action'=>'uploadCsv']);
		}
	}
	/**
	 * It displays Access Denied Page if user wants to view the page without permission
	 *
	 * @access public
	 * @return void
	 */
	public function accessDenied() {

	}
	/**
	 * It is used to login user
	 *
	 * @access public
	 * @param string $connect social connect name like, fb, twt
	 * @return void
	 */
	public function login($connect=null) {
		if($this->UserAuth->isLogged()) {
			if($connect) {
				$this->render('popup');
			} else {
				$this->redirect(['action'=>'dashboard']);
			}
		}
		if($connect == 'fb') {
			$this->login_facebook();
			$this->render('popup');
		} elseif($connect == 'twt') {
			$this->login_twitter();
			$this->render('popup');
		} elseif($connect == 'gmail') {
			$this->login_gmail();
			$this->render('popup');
		} elseif($connect == 'ldn') {
			$this->login_linkedin();
			$this->render('popup');
		} elseif($connect == 'fs') {
			$this->login_foursquare();
			$this->render('popup');
		} elseif($connect == 'yahoo') {
			$this->login_yahoo();
			$this->render('popup');
		} else {
			if($this->request->is('post') && $this->UserAuth->canUseRecaptha('login') && !$this->request->is('ajax')) {
				$this->request->data['Users']['captcha'] = (isset($this->request->data['g-recaptcha-response'])) ? $this->request->data['g-recaptcha-response'] : "";
			}
			$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forLogin']);
			if($this->request->is('post')) {
				$errors = $userEntity->errors();
				if(empty($errors)) {
					$email = $userEntity['email'];
					$password = $userEntity['password'];
					$user = $this->Users->findByUsernameOrEmail($email, $email)
								->contain('UserDetails')
								->first();
					$errorMsg = "";
					$loginValid = false;
					if(!empty($user) && $this->UserAuth->checkPassword($password, $user['password'])) {
						if($user['active']) {
							if($user['email_verified']) {
								$loginValid = true;
							} else {
								$errorMsg = __('Your email has not been confirmed please verify your email or contact to admin', true);
							}
						} else {
							$errorMsg = __('Sorry your account is not active, please contact to admin', true);
						}
					} else {
						$this->UserAuth->setBadLoginCount();
						$errorMsg = __('Incorrect Email/Username or Password', true);
					}
				}
				if($this->request->is('ajax')) {
					if(empty($errors) && $loginValid) {
						$response = ['error'=>0, 'message'=>'success'];
					} else {
						$response = ['error'=>1, 'message'=>'failure'];
						if(empty($errorMsg)) {
							$response['data']['Users'] = $errors;
						} else {
							if($this->UserAuth->captchaOnBadLogin()) {
								// need to submit login for captcha validation
								$response = ['error'=>0, 'message'=>'success'];
							} else {
								$response['data']['Users'] = ['email'=>[$errorMsg]];
							}
						}
					}
					echo json_encode($response);exit;
				} else {
					if(empty($errors) && $loginValid) {
						
						$user = $user->toArray();
						
						if( $user['terms_and_conditions'] == TRUE || isset( $this->request->data['Users']['terms_and_conditions'] ) &&  $this->request->data['Users']['terms_and_conditions'] == '1'){

							if( isset( $this->request->data['Users']['terms_and_conditions'] ) || $user['active'] == 1){
								$userEntity = $this->Users->getUserById( $user['id'] );
								$userEntity->terms_and_conditions = TRUE;
								$this->Users->save($userEntity);
							}

							$this->UserAuth->login($user);
							if(!empty($userEntity['remember'])) {
								$this->UserAuth->persist('2 weeks');
							}

							$this->redirect($this->Auth->redirectUrl());

						}else {
							$this->Flash->error('Acepta Términos y Condiciones');
						}

					} else {
						if(!empty($errorMsg)) {
							$this->Flash->error($errorMsg);
						}
						$this->request->data['Users']['password'] = '';
					}
				}
			}
			$this->set(compact('userEntity'));
		}

		$this->viewBuilder()->layout('login');
	}
	private function add_social_user($socialData) {
		$userForLogin = [];
		if(SITE_REGISTRATION) {
			$userEntity = $this->Users->newEntity();
			$userEntity['user_group_id'] = DEFAULT_GROUP_ID;
			if(!empty($socialData['username'])) {
				$userEntity['username'] = $this->generateUserName($socialData['username']);
			} else {
				$userEntity['username'] = $this->generateUserName($socialData['name']);
			}
			$password = $this->UserAuth->generatePassword();
			$userEntity['password'] = $this->UserAuth->makeHashedPassword($password);
			$userEntity['first_name'] = $socialData['first_name'];
			$userEntity['last_name'] = $socialData['last_name'];
			$userEntity['gender'] = $socialData['gender'];
			$userEntity['active'] = 1;
			if(!empty($socialData['email'])) {
				$userEntity['email'] = $socialData['email'];
				$userEntity['email_verified'] = 1;
			}
			$userEntity['ip_address'] = $this->request->clientIp();
			if(!empty($socialData['picture'])) {
				$userEntity['photo'] = $this->updateProfilePic($socialData['picture']);
			}
			if($this->Users->save($userEntity, ['validate'=>false])) {
				$userId = $userEntity['id'];
				if(!isset($userEntity['user_detail']['id'])) {
					$this->loadModel('Usermgmt.UserDetails');
					$userDetailEntity = $this->UserDetails->newEntity();
					$userDetailEntity['user_id'] = $userId;
					$userDetailEntity['location'] = $socialData['location'];
					$this->UserDetails->save($userDetailEntity, ['validate'=>false]);
				}
				if(!empty($socialData['id'])) {
					$this->UserSocials->add_social_account($socialData, $userId);
				}
				$userForLogin = $this->Users->getUserById($userId);
				if(CHANGE_PASSWORD_ON_SOCIAL_REGISTRATION) {
					$this->request->session()->write('Auth.SocialChangePassword', true);
				}
			}
		} else {
			$this->Flash->info(__('Sorry new registration is currently disabled, please try again later'));
		}
		return $userForLogin;
	}
	private function login_social_user($userForLogin, $socialData) {
		if(!empty($userForLogin)) {
			if($userForLogin['active']) {
				$photoPath = WWW_ROOT."library".DS.IMG_DIR.DS.$userForLogin['photo'];
				if((empty($userForLogin['photo']) || !file_exists($photoPath)) && !empty($socialData['picture'])) {
					$userForLogin['photo'] = $this->updateProfilePic($socialData['picture']);
				}
				$this->Users->save($userForLogin, ['validate'=>false]);
				$userForLogin = $userForLogin->toArray();
				$changePassword = $this->request->session()->read('Auth.SocialChangePassword');
				$this->UserAuth->login($userForLogin);
				if(!empty($changePassword)) {
					$this->request->session()->write('Auth.SocialLogin', true);
					$this->request->session()->write('Auth.SocialChangePassword', true);
				}
			} else {
				$this->Flash->info(__('Sorry your account is not active, please contact to admin'));
			}
		}
	}
	private function login_facebook() {
		$this->viewBuilder()->layout('');
		$fbData = $this->UserConnect->facebook_connect();
		if(!empty($fbData['redirectURL'])) {
			$this->redirect($fbData['redirectURL']);
		} else {
			if(!empty($fbData['id'])) {
				$fbData['type'] = 'FACEBOOK';
				$this->loadModel('Usermgmt.UserSocials');
				$userByFbId = $userByFbEmail = $userForLogin = [];
				$userSocial = $this->UserSocials->find()->where(['UserSocials.type'=>$fbData['type'], 'UserSocials.socialid'=>$fbData['id']])->first();
				if(!empty($fbData['email'])) {
					$userByFbEmail = $this->Users->getUserByEmail($fbData['email']);
				}
				if(!empty($userSocial)) {
					$userSocial['access_token'] = $fbData['access_token'];
					$this->UserSocials->save($userSocial, ['validate'=>false]);
					$userByFbId = $this->Users->getUserById($userSocial['user_id']);
				} else if(!empty($userByFbEmail)) {
					$this->UserSocials->add_social_account($fbData, $userByFbEmail['id']);
				}
				if(!empty($userByFbId) && !empty($userByFbEmail)) {
					$userForLogin = $userByFbId;
				} else if(!empty($userByFbId)) {
					if(empty($userByFbId['email']) && !empty($fbData['email'])) {
						$userByFbId['email'] = $fbData['email'];
					}
					$userForLogin = $userByFbId;
				} else if(!empty($userByFbEmail)) {
					$userForLogin = $userByFbEmail;
				} else {
					$userForLogin = $this->add_social_user($fbData);
				}
				$this->login_social_user($userForLogin, $fbData);
			}
		}
	}
	private function login_twitter() {
		$this->viewBuilder()->layout('');
		$twtData = $this->UserConnect->twitter_connect();
		if(!empty($twtData['redirectURL'])) {
			$this->redirect($twtData['redirectURL']);
		} else {
			if(!empty($twtData['id'])) {
				$twtData['type'] = 'TWITTER';
				$this->loadModel('Usermgmt.UserSocials');
				$userForLogin = [];
				$userSocial = $this->UserSocials->find()->where(['UserSocials.type'=>$twtData['type'], 'UserSocials.socialid'=>$twtData['id']])->first();
				if(!empty($userSocial)) {
					$userSocial['access_token'] = $twtData['access_token'];
					$userSocial['access_secret'] = $twtData['access_secret'];
					$this->UserSocials->save($userSocial, ['validate'=>false]);
					$userForLogin = $this->Users->getUserById($userSocial['user_id']);
				}
				if(empty($userForLogin)) {
					$userForLogin = $this->add_social_user($twtData);
				}
				$this->login_social_user($userForLogin, $twtData);
			}
		}
	}
	private function login_linkedin() {
		$this->viewBuilder()->layout('');
		$ldnData = $this->UserConnect->linkedin_connect();
		if(!empty($ldnData['redirectURL'])) {
			$this->redirect($ldnData['redirectURL']);
		} else {
			if(!empty($ldnData['id'])) {
				$ldnData['type'] = 'LINKEDIN';
				$this->loadModel('Usermgmt.UserSocials');
				$userByLdnId = $userByLdnEmail = $userForLogin = [];
				$userSocial = $this->UserSocials->find()->where(['UserSocials.type'=>$ldnData['type'], 'UserSocials.socialid'=>$ldnData['id']])->first();
				if(!empty($ldnData['email'])) {
					$userByLdnEmail = $this->Users->getUserByEmail($ldnData['email']);
				}
				if(!empty($userSocial)) {
					$userSocial['access_token'] = $ldnData['access_token'];
					$this->UserSocials->save($userSocial, ['validate'=>false]);
					$userByLdnId = $this->Users->getUserById($userSocial['user_id']);
				} else if(!empty($userByLdnEmail)) {
					$this->UserSocials->add_social_account($ldnData, $userByLdnEmail['id']);
				}
				if(!empty($userByLdnId) && !empty($userByLdnEmail)) {
					$userForLogin = $userByLdnId;
				} else if(!empty($userByLdnId)) {
					if(empty($userByLdnId['email']) && !empty($ldnData['email'])) {
						$userByLdnId['email'] = $ldnData['email'];
					}
					$userForLogin = $userByLdnId;
				} else if(!empty($userByLdnEmail)) {
					$userForLogin = $userByLdnEmail;
				} else {
					$userForLogin = $this->add_social_user($ldnData);
				}
				$this->login_social_user($userForLogin, $ldnData);
			}
		}
	}
	private function login_foursquare() {
		$this->viewBuilder()->layout('');
		$fsData = $this->UserConnect->foursquare_connect();
		if(!empty($fsData['redirectURL'])) {
			$this->redirect($fsData['redirectURL']);
		} else {
			if(!empty($fsData['id'])) {
				$fsData['type'] = 'FOURSQUARE';
				$this->loadModel('Usermgmt.UserSocials');
				$userByFsId = $userByFsEmail = $userForLogin = [];
				$userSocial = $this->UserSocials->find()->where(['UserSocials.type'=>$fsData['type'], 'UserSocials.socialid'=>$fsData['id']])->first();
				if(!empty($fsData['email'])) {
					$userByFsEmail = $this->Users->getUserByEmail($fsData['email']);
				}
				if(!empty($userSocial)) {
					$userSocial['access_token'] = $fsData['access_token'];
					$this->UserSocials->save($userSocial, ['validate'=>false]);
					$userByFsId = $this->Users->getUserById($userSocial['user_id']);
				} else if(!empty($userByFsEmail)) {
					$this->UserSocials->add_social_account($fsData, $userByFsEmail['id']);
				}
				if(!empty($userByFsId) && !empty($userByFsEmail)) {
					$userForLogin = $userByFsId;
				} else if(!empty($userByFsId)) {
					if(empty($userByFsId['email']) && !empty($fsData['email'])) {
						$userByFsId['email'] = $fsData['email'];
					}
					$userForLogin = $userByFsId;
				} else if(!empty($userByFsEmail)) {
					$userForLogin = $userByFsEmail;
				} else {
					$userForLogin = $this->add_social_user($fsData);
				}
				$this->login_social_user($userForLogin, $fsData);
			}
		}
	}
	private function login_gmail() {
		$this->viewBuilder()->layout('');
		$gmailData = $this->UserConnect->gmail_connect();
		if(!empty($gmailData['redirectURL'])) {
			$this->redirect($gmailData['redirectURL']);
		} else {
			if(!empty($gmailData['email'])) {
				$userForLogin = $this->Users->getUserByEmail($gmailData['email']);
				if(empty($userForLogin)) {
					$userForLogin = $this->add_social_user($gmailData);
				}
				$this->login_social_user($userForLogin, $gmailData);
			}
		}
	}
	private function login_yahoo() {
		$this->viewBuilder()->layout('');
		$yahooData = $this->UserConnect->yahoo_connect();
		if(!empty($yahooData['redirectURL'])) {
			$this->redirect($yahooData['redirectURL']);
		} else {
			if(!empty($yahooData['email'])) {
				$userForLogin = $this->Users->getUserByEmail($yahooData['email']);
				if(empty($userForLogin)) {
					$userForLogin = $this->add_social_user($yahooData);
				}
				$this->login_social_user($userForLogin, $yahooData);
			}
		}
	}
	/**
	 * It is used to logout user from the site
	 *
	 * @access public
	 * @param boolean $msg true for flash message on logout
	 * @return void
	 */
	public function logout($msg=true) {
		$this->UserAuth->logout();
		if($msg) {
			//$this->Flash->success(__('You are successfully signed out'));
		}
	}
	/**
	 * It is used to generate unique username
	 *
	 * @access private
	 * @param string $name user's name to generate username
	 * @return void
	 */
	private function generateUserName($name=null) {
		$name = str_replace(' ', '', strtolower($name));
		$username = '';
		if(!empty($name)) {
			$username = $name;
			while($this->Users->exists(['Users.username'=>$username]) || $this->Users->isBanned2($username)) {
				$username = $name.'_'.rand(1000, 9999);
			}
		}
		return $username;
	}
	/**
	 *  It is used to update profile pic from given url
	 *
	 * @access private
	 * @param url $file_location url of pic
	 * @return void
	 */
	private function updateProfilePic($file_location) {
		$fullpath = WWW_ROOT."library".DS.IMG_DIR;
		if(!is_dir($fullpath)) {
			mkdir($fullpath, 0777, true);
		}
		$imgContent = file_get_contents($file_location);
		$photo = time().mt_rand().".jpg";
		$tempfile = $fullpath.DS.$photo;
		$fp = fopen($tempfile, "w");
		fwrite($fp, $imgContent);
		fclose($fp);
		return $photo;
	}
	/**
	 * It is used to register a user
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
		$userId = $this->UserAuth->getUserId();
		if($userId) {
			$this->redirect(['action'=>'dashboard']);
		}
		if(SITE_REGISTRATION) {
			$this->loadModel('Usermgmt.UserGroups');
			$userGroups = $this->UserGroups->getGroupsForRegistration();
			if($this->request->is('post') && $this->UserAuth->canUseRecaptha('registration') && !$this->request->is('ajax')) {
				$this->request->data['Users']['captcha'] = (isset($this->request->data['g-recaptcha-response'])) ? $this->request->data['g-recaptcha-response'] : "";
			}
			$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forRegister']);
			if($this->request->is('post')) {
				$errors = $userEntity->errors();
				if($this->request->is('ajax')) {
					if(empty($errors)) {
						$response = ['error'=>0, 'message'=>'success'];
					} else {
						$response = ['error'=>1, 'message'=>'failure'];
						$response['data']['Users'] = $errors;
					}
					echo json_encode($response);exit;
				} else {
					if(empty($errors)) {
						if(!isset($this->request->data['Users']['user_group_id'])) {
							$userEntity['user_group_id'] = DEFAULT_GROUP_ID;
						}
						if(!EMAIL_VERIFICATION) {
							$userEntity['email_verified'] = 1;
						}
						$userEntity['active'] = 1;
						$userEntity['ip_address'] = $this->request->clientIp();
						$userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);
						$userEntity['first_name'] = $userEntity['first_name'];
						$userEntity['last_name'] = $userEntity['last_name'];
						if($this->Users->save($userEntity, ['validate'=>false])) {
							$userId = $userEntity['id'];
							$this->loadModel('Usermgmt.UserDetails');
							$userDetailEntity = $this->UserDetails->newEntity();
							$userDetailEntity['user_id'] = $userId;
							$this->UserDetails->save($userDetailEntity, ['validate'=>false]);
							if(EMAIL_VERIFICATION) {
								$this->Users->sendVerificationMail($userEntity);
							}
							if(SEND_REGISTRATION_MAIL) {
								$this->Users->sendRegistrationMail($userEntity);
							}
							if(isset($userEntity['active']) && $userEntity['active'] && !EMAIL_VERIFICATION) {
								$user = $this->Users->getUserById($userId);
								$user = $user->toArray();
								$this->UserAuth->login($user);
								$this->redirect($this->Auth->redirectUrl());
							} else {
								$this->Flash->success(__('We have sent an email to you, please confirm your registration'));
								$this->redirect(['action'=>'login']);
							}
						} else {
							$this->Flash->error(__('Unable to register user, please try again'));
						}
					}
				}
			}
			$this->set(compact('userGroups', 'userEntity'));
		} else {
			$this->Flash->info(__('Sorry new registration is currently disabled, please try again later'));
			$this->redirect(['action'=>'login']);
		}
		$this->viewBuilder()->layout('login');
	}
	/**
	 * It displays loggedin users profile details
	 *
	 * @access public
	 * @return void
	 */
	public function myprofile() {
		$userId = $this->UserAuth->getUserId();
		$user = $this->Users->getUserById($userId);
		if(!empty($user)) {
			$this->loadModel('Usermgmt.UserGroups');
			$user['user_group_name'] = $this->UserGroups->getGroupsByIds($user['user_group_id']);
			$page = "My Profile";
			$days = $this->Users->getDays();
			$months = $this->Users->getMonth();
			$this->loadModel('Departments');
			$departamentos = $this->Departments->getDepartamentos(false);
			$this->set(compact('user', 'page','months','days','departamentos'));
		} else {
			$this->Flash->info(__('Profile details not found'));
			$this->redirect(['action'=>'dashboard']);
		}
	}
	/**
	 * It is used to edit personal profile by user
	 *
	 * @access public
	 * @return void
	 */
	public function editProfile() {
		$userId = $this->UserAuth->getUserId();
		if(!empty($userId)) {
			$userEntity = $this->Users->getUserById($userId);
			if(!empty($userEntity)) {
				$userOldEmail = $userEntity['email'];
				$this->loadModel('Usermgmt.UserDetails');
				if(!ALLOW_CHANGE_USERNAME && !empty($userEntity['username'])) {
					unset($this->request->data['Users']['username']);
				}
				$this->Users->patchEntity($userEntity, $this->request->data, ['validate'=>'forEditProfile', 'associated'=>['UserDetails'=>['validate'=>'forEditProfile']]]);
				if($this->request->is(['post', 'put'])) {
					$errors = $userEntity->errors();
					if($this->request->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['Users'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if(!empty($this->request->data['Users']['photo_file']['tmp_name']) && is_uploaded_file($this->request->data['Users']['photo_file']['tmp_name']))
							{
								$path_info = pathinfo($this->request->data['Users']['photo_file']['name']);
								chmod($this->request->data['Users']['photo_file']['tmp_name'], 0644);
								$photo = time().mt_rand().".".$path_info['extension'];
								$fullpath = WWW_ROOT."library".DS.IMG_DIR;
								if(!is_dir($fullpath)) {
									mkdir($fullpath, 0777, true);
								}
								move_uploaded_file($this->request->data['Users']['photo_file']['tmp_name'], $fullpath.DS.$photo);
								$existing_photo = $userEntity['photo'];
								$userEntity['photo'] = $photo;
								$this->request->session()->write('Auth.User.photo',$photo);
								if(!empty($existing_photo) && file_exists($fullpath.DS.$existing_photo)) {
									unlink($fullpath.DS.$existing_photo);
								}
							}
							if(!$this->UserAuth->isAdmin() && $userOldEmail != $userEntity['email']) {
								$userEntity['email_verified'] = 0;
								$this->Users->sendVerificationMail($userEntity);
								$this->loadModel('Usermgmt.LoginTokens');
								$this->LoginTokens->deleteAll(['user_id'=>$userId]);
							}
							unset($userEntity['user_group_id']);
							if(empty($userEntity['ip_address'])) {
								$userEntity['ip_address'] = $this->request->clientIp();
							}
							if(!empty($this->request->data['Users']['bday'])) {
								$userEntity['bday'] = new Time($this->request->data['Users']['bday']);
							}
							$this->Users->save($userEntity, ['validate'=>false]);
							$this->Flash->success(__('Your profile has been successfully updated'));
							$this->redirect(['action'=>'myprofile']);
						}
					}
				} else {
					if(!empty($userEntity['bday'])) {
						$userEntity['bday'] = $userEntity['bday']->format('Y-m-d');
					}
				}
				$genders = $this->Users->getGenders();
				$page = "Edit Profile";
				$this->set(compact('userEntity', 'genders', 'page'));
			} else {
				$this->Flash->error(__('Invalid User Id'));
				$this->redirect(['action'=>'myprofile']);
			}
		} else {
			$this->Flash->error(__('Invalid User Id'));
			$this->redirect(['action'=>'myprofile']);
		}
	}
	/**
	 * It is used to change password
	 *
	 * @access public
	 * @return void
	 */
	public function changePassword() {
		$userId = $this->UserAuth->getUserId();
		if($userId) {
			$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forChangePassword']);
			if($this->request->is('post')) {
				$errors = $userEntity->errors();
				if(empty($errors)) {
					$userEntity['id'] = $userId;
					$userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);
					$this->Users->save($userEntity, ['validate'=>false]);
					$this->loadModel('Usermgmt.LoginTokens');
					$this->LoginTokens->deleteAll(['user_id'=>$userId]);
					if(SEND_PASSWORD_CHANGE_MAIL) {
						$userEntity = $this->Users->find()->where(['Users.id'=>$userId])->first();
						$this->Users->sendChangePasswordMail($userEntity);
					}
					$this->request->session()->delete('Auth.SocialChangePassword');
					$this->Flash->success(__('Password changed successfully'));
					$this->redirect(['action'=>'dashboard']);
				}
			}
			$page = "Change Password";
			$this->set(compact('userEntity', 'page'));
		} else {
			$this->Flash->error(__('Invalid User Id'));
			$this->redirect(['action'=>'dashboard']);
		}
	}
	/**
	 * It is used to delete user account by itself If allowed by admin in All settings
	 *
	 * @access public
	 * @return void
	 */
	public function deleteAccount() {
		$userId = $this->UserAuth->getUserId();
		if(!empty($userId)) {
			if($this->request->is('post')) {
				if(ALLOW_DELETE_ACCOUNT && $userId != 1) {
					$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
					if($this->Users->delete($user)) {
						$this->loadModel('UserDetails');
						$this->loadModel('LoginTokens');
						$this->loadModel('UserActivities');
						$this->UserDetails->deleteAll(['user_id'=>$userId]);
						$this->LoginTokens->deleteAll(['user_id'=>$userId]);
						$this->UserActivities->updateAll(['deleted'=>1], ['user_id'=>$userId]);
						$this->Flash->success(__('Your account is successfully deleted'));
						$this->logout(false);
					}
				} else {
					$this->Flash->info(__('You are not allowed to delete account'));
				}
			}
		}
		$this->redirect(['action'=>'dashboard']);
	}
	/**
	 * It is used to reset password, this function sends email with link to reset the password
	 *
	 * @access public
	 * @return void
	 */
	public function forgotPassword() {
		if($this->request->is('post') && $this->UserAuth->canUseRecaptha('forgotPassword') && !$this->request->is('ajax')) {
			$this->request->data['Users']['captcha'] = (isset($this->request->data['g-recaptcha-response'])) ? $this->request->data['g-recaptcha-response'] : "";
		}
		$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forForgotPassword']);
		if($this->request->is('post')) {
			$errors = $userEntity->errors();
			if(empty($errors)) {
				$email = $userEntity['email'];
				$user = $this->Users->findByUsernameOrEmail($email, $email)->first();
				if(!empty($user)) {
					if($user['email_verified'] == 1) {
						$this->Users->sendForgotPasswordMail($user);
						$this->Flash->success(__('We have sent an email to you, please click on the link in your email to reset your password'));
					} else {
						$this->Flash->info(__('Your registration has not been confirmed yet please verify your email address before reset password'));
					}
					$this->redirect(['action'=>'login']);
				} else {
					$this->Flash->error(__('Incorrect Email/Username'));
				}
			}
		}
		$this->set(compact('userEntity'));
		$this->viewBuilder()->layout('login');
	}
	/**
	 *  It is used to reset password when users clicks the link in their email
	 *
	 * @access public
	 * @return void
	 */
	public function activatePassword() {
		$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forActivatePassword']);
		$ident = $activate = '';
		if(!empty($_GET['ident']) && !empty($_GET['activate'])) {
			if($this->request->is('post')) {
				$errors = $userEntity->errors();
				if(empty($errors)) {
					$userId = $_GET['ident'];
					$activateKey = $_GET['activate'];
					$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
					if(!empty($user)) {
						$thekey = $this->Users->getActivationKey($user['email'].$user['password']);
						if($thekey === $activateKey) {
							$userEntity['id'] = $userId;
							$userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);
							$this->Users->save($userEntity, ['validate'=>false]);
							$this->Flash->success(__('Your password has been reset successfully'));
							$this->redirect(['action'=>'login']);
						} else {
							$this->Flash->info(__('Something went wrong, please send password reset link again'));
						}
					} else {
						$this->Flash->info(__('Something went wrong, please click again on the link in email'));
					}
				}
			}
		} else {
			$this->Flash->info(__('Something went wrong, please click again on the link in email'));
		}
		$this->set(compact('userEntity'));
		$this->viewBuilder()->layout('login');
	}
	/**
	 * It is used to send email verification mail to user with link to verify the email address
	 *
	 * @access public
	 * @return void
	 */
	public function emailVerification() {
		if($this->request->is('post') && $this->UserAuth->canUseRecaptha('emailVerification') && !$this->request->is('ajax')) {
			$this->request->data['Users']['captcha'] = (isset($this->request->data['g-recaptcha-response'])) ? $this->request->data['g-recaptcha-response'] : "";
		}
		$userEntity = $this->Users->newEntity($this->request->data, ['validate'=>'forEmailVerification']);
		if($this->request->is('post')) {
			$errors = $userEntity->errors();
			if(empty($errors)) {
				$email = $userEntity['email'];
				$user = $this->Users->findByUsernameOrEmail($email, $email)->first();
				if(!empty($user)) {
					if($user['email_verified'] == 0) {
						$this->Users->sendVerificationMail($user);
						$this->Flash->success(__('We have sent an email to you, please confirm your email address'));
					} else {
						$this->Flash->success(__('Your email is already verified'));
					}
					$this->redirect(['action'=>'login']);
				} else {
					$this->Flash->error(__('Incorrect Email/Username'));
				}
			}
		}
		$this->set(compact('userEntity'));
	}
	/**
	 * It is used to verify user's email address when user click on the link sent to their email address
	 *
	 * @access public
	 * @return void
	 */
	public function userVerification() {
		if(isset($_GET['ident']) && isset($_GET['activate'])) {
			$userId = $_GET['ident'];
			$activateKey = $_GET['activate'];
			$user = $this->Users->find()->where(['Users.id'=>$userId])->first();
			if(!empty($user)) {
				if(!$user['email_verified']) {
					$password = $user['password'];
					$theKey = $this->Users->getActivationKey($user['email'].$password);
					if($activateKey === $theKey) {
						$user['email_verified'] = 1;
						$this->Users->patchEntity($user, ['validate'=>false]);
						$result = $this->Users->save($user, ['validate'=>false]);
						$this->Flash->success(__('Thank you, your email has been verified successfully'));
					}
				} else {
					$this->Flash->success(__('Thank you, your email is already verified'));
				}
			} else {
				$this->Flash->info(__('Sorry something went wrong, please click on the link again'));
			}
		} else {
			$this->Flash->info(__('Sorry something went wrong, please click on the link again'));
		}
		$this->redirect(['action'=>'login']);
	}
	/**
	 *  It id used to delete cache of cakephp on production
	 *
	 * @access public
	 * @return void
	 */
	public function deleteCache() {
		Configure::write('debug', 1);
		$iterator = new \RecursiveDirectoryIterator(CACHE);
		$success = true;
		foreach(new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
			$path_info = pathinfo($file);
			if(!in_array($path_info['basename'], ['.svn', '.', '..'])) {
				if($path_info['dirname'] == CACHE.'models') {
					if(!unlink($file->getPathname())) {
						$success = false;
					}
				}
				if($path_info['dirname'] == CACHE.'persistent') {
					if(!unlink($file->getPathname())) {
						$success = false;
					}
				}
				if($path_info['dirname'] == CACHE.'views') {
					if(!unlink($file->getPathname())) {
						$success = false;
					}
				}
				if($path_info['dirname'] == TMP.'cache') {
					if(!is_dir($file->getPathname()) && strpos($path_info['basename'], 'UserMgmt_') !== false) {
						if(!unlink($file->getPathname())) {
							$success = false;
						}
					}
				}
			}
		}
		$this->loadModel('Usermgmt.UserSettings');
		$expression = new QueryExpression('value = value + 1');
		$this->UserSettings->updateAll([$expression], ['name'=>'qrdn']);
		$this->loadModel('Usermgmt.UserActivities');
		$this->UserActivities->deleteAll(['1'=>'1']);
		if($success) {
			$this->Flash->success(__('Cache has been deleted successfully'));
			$this->redirect(['action'=>'dashboard']);
		} else {
			echo __('Cache was not deleted, please delete it manually.');
			exit;
		}
	}


	public function sendEmail($userId = null){

		$entity =  $this->Users->get($userId);

		if( isset( $entity['email'] ) && !empty( $entity['email'] ) ){
			if( $entity['email_verified'] == 1 ){
				$this->Users->sendWellcomePasswordMail($entity);
				$this->Flash->success(__('La invitación se envío correctamente.'));
			}else{
				$this->Flash->info(__('El registro aún no ha sido confirmado.'));
			}
		}else{
			$this->Flash->error(__('Este usuario no tiene correo electrónico.'));
		}

		$this->redirect(['action'=>'index']);
	}
}