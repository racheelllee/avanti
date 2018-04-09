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
use Cake\Cache\Cache;
use Cake\Utility\Inflector;

class UserGroupsTable extends UsermgmtAppTable {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		$this->hasMany('Usermgmt.UserGroupPermissions');
	}
	public function validationForAdd($validator) {
		$validator
			->notEmpty('name', __('Please enter user group name'))
			->add('name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid name'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This name already exist'),
					'last'=>true
				]
			]);
		return $validator;
	}
	/**
	 * Used to check permissions of group
	 *
	 * @access public
	 * @param string $controller controller name
	 * @param string $action action name
	 * @param string $plugin plugin name
	 * @param integer $userGroupID group id
	 * @return boolean
	 */
	public function isUserGroupAccess($controller, $action, $plugin, $prefix, $userGroupID) {
		if(!PERMISSIONS) {
			return true;
		}
		$userGroupIDArray = array_map('trim', explode(',', $userGroupID));
		if(in_array(ADMIN_GROUP_ID, $userGroupIDArray) && !ADMIN_PERMISSIONS) {
			return true;
		}
		$permissions = $this->getPermissions($userGroupID);
		$access = Inflector::camelize($controller).'/'.$action;
		if($plugin) {
			$access = $plugin.'/'.$access;
		}
		if($prefix) {
			$access = $prefix.'/'.$access;
		}
		$access = strtolower($access);
		if(is_array($permissions) && in_array($access, $permissions)) {
			return true;
		}
		return false;
	}
	/**
	 * Used to check permissions of guest group
	 *
	 * @access public
	 * @param string $controller controller name
	 * @param string $action action name
	 * @param string $plugin plugin name
	 * @return boolean
	 */
	public function isGuestAccess($controller, $action, $plugin=null, $prefix=null) {
		if(PERMISSIONS) {
			return $this->isUserGroupAccess($controller, $action, $plugin, $prefix, GUEST_GROUP_ID);
		} else {
			return true;
		}
	}
	/**
	 * Used to get permissions from cache or database of a group
	 *
	 * @access public
	 * @param integer $userGroupID group id
	 * @return array
	 */
	public function getPermissions($userGroupID) {
		$userGroupIDCache = str_replace(',', '-', $userGroupID);
		// using the cake cache to store rules
		$cacheKey = 'rules_for_group_'.$userGroupIDCache;
		$permissions = Cache::read($cacheKey, 'UserMgmtPermissions');
		if($permissions === false) {
			$permissions = [];
			$userGroupIDArray = array_map('trim', explode(',', $userGroupID));

			$actions = $this->UserGroupPermissions->find()
				->select(['UserGroupPermissions.controller', 'UserGroupPermissions.action', 'UserGroupPermissions.plugin', 'UserGroupPermissions.prefix'])
				->where(['UserGroupPermissions.user_group_id IN'=>$userGroupIDArray, 'UserGroupPermissions.allowed'=>1, 'UserGroups.parent_id'=>0])
				->contain(['UserGroups'])
				->hydrate(false)
				->toArray();
			foreach($actions as $action) {
				$actionUrl = $action['controller'].'/'.$action['action'];
				if(!empty($action['plugin'])) {
					$actionUrl = $action['plugin'].'/'.$actionUrl;
				}
				if(!empty($action['prefix'])) {
					$actionUrl = strtolower(str_replace('.', '/', $action['prefix'])).'/'.$actionUrl;
				}
				$permissions[] = strtolower($actionUrl);
			}

			$actions = $this->UserGroupPermissions->find()
				->select(['UserGroupPermissions.controller', 'UserGroupPermissions.action', 'UserGroupPermissions.plugin', 'UserGroupPermissions.prefix'])
				->where(['UserGroupPermissions.user_group_id IN'=>$userGroupIDArray, 'UserGroupPermissions.allowed'=>1, 'UserGroups.parent_id !='=>0])
				->contain(['UserGroups'])
				->hydrate(false)
				->toArray();
			foreach($actions as $action) {
				$actionUrl = $action['controller'].'/'.$action['action'];
				if(!empty($action['plugin'])) {
					$actionUrl = $action['plugin'].'/'.$actionUrl;
				}
				if(!empty($action['prefix'])) {
					$actionUrl = strtolower(str_replace('.', '/', $action['prefix'])).'/'.$actionUrl;
				}
				$permissions[] = strtolower($actionUrl);
			}

			$userGroups = $this->find()
				->select(['UserGroups.id', 'UserGroups.parent_id'])
				->where(['UserGroups.id IN'=>$userGroupIDArray, 'UserGroups.parent_id !='=>0])
				->hydrate(false)
				->toArray();
			$userGroupIDArrayTmp = $userGroupChildIDArrayTmp = [];
			foreach($userGroups as $userGroup) {
				if(!in_array($userGroup['parent_id'], $userGroupIDArray)) {
					$userGroupIDArrayTmp[] = $userGroup['parent_id'];
					$userGroupChildIDArrayTmp[] = $userGroup['id'];
				}
			}
			if(!empty($userGroupIDArrayTmp)) {
				$actions = $this->UserGroupPermissions->find()
					->select(['UserGroupPermissions.controller', 'UserGroupPermissions.action', 'UserGroupPermissions.plugin', 'UserGroupPermissions.prefix'])
					->where(['UserGroupPermissions.user_group_id IN'=>$userGroupIDArrayTmp, 'UserGroupPermissions.allowed'=>1, 'UserGroups.parent_id'=>0])
					->contain(['UserGroups'])
					->hydrate(false)
					->toArray();
				$permissionsTmp1 = [];
				foreach($actions as $action) {
					$actionUrl = $action['controller'].'/'.$action['action'];
					if(!empty($action['plugin'])) {
						$actionUrl = $action['plugin'].'/'.$actionUrl;
					}
					if(!empty($action['prefix'])) {
						$actionUrl = strtolower(str_replace('.', '/', $action['prefix'])).'/'.$actionUrl;
					}
					$permissionsTmp1[] = strtolower($actionUrl);
				}
				$permissionsTmp1 = array_unique($permissionsTmp1);

				$actions = $this->UserGroupPermissions->find()
					->select(['UserGroupPermissions.controller', 'UserGroupPermissions.action', 'UserGroupPermissions.plugin', 'UserGroupPermissions.prefix'])
					->where(['UserGroupPermissions.user_group_id IN'=>$userGroupChildIDArrayTmp, 'UserGroupPermissions.allowed'=>0, 'UserGroups.parent_id !='=>0])
					->contain(['UserGroups'])
					->hydrate(false)
					->toArray();
				$permissionsTmp2 = [];
				foreach($actions as $action) {
					$actionUrl = $action['controller'].'/'.$action['action'];
					if(!empty($action['plugin'])) {
						$actionUrl = $action['plugin'].'/'.$actionUrl;
					}
					if(!empty($action['prefix'])) {
						$actionUrl = strtolower(str_replace('.', '/', $action['prefix'])).'/'.$actionUrl;
					}
					$permissionsTmp2[] = strtolower($actionUrl);
				}
				$permissionsTmp2 = array_unique($permissionsTmp2);

				$permissionsTmp1 = array_diff($permissionsTmp1, $permissionsTmp2);
				$permissions = array_merge($permissions, $permissionsTmp1);
			}
			if(is_array($permissions)) {
				$permissions = array_unique($permissions);
			}
			Cache::write($cacheKey, $permissions, 'UserMgmtPermissions');
		}
		return $permissions;
	}
	/**
	 * Used to get group names with ids without guest group
	 *
	 * @access public
	 * @return array
	 */
	public function getUserGroups($sel=true) {
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.name', 'UserGroups.parent_id'])
				->where(['UserGroups.name !='=>'Guest'])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.parent_id', 'UserGroups.name'])
				->hydrate(false)
				->toArray();
		$userGroups = [];
		if($sel) {
			$userGroups[''] = __('Select');
		}
		foreach($result as $row) {
			if($row['parent_id'] == 0) {
				$userGroups[$row['id']] = $row['name'];
				foreach($result as $row1) {
					if($row1['parent_id'] == $row['id']) {
						$userGroups[$row1['id']] = '.....'.$row1['name'];
					}
				}
			}
		}
		return $userGroups;
	}
	/**
	 * Used to get group names with ids for registration
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupsForRegistration($sel=true) {
		$userGroups = [];
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.name'])
				->where(['UserGroups.registration_allowed'=>1])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.name'])
				->hydrate(false)
				->toArray();
		if($sel) {
			$userGroups[''] = __('Select');
		}
		foreach($result as $row) {
			$userGroups[$row['id']] = $row['name'];
		}
		return $userGroups;
	}
	/**
	 * Used to get group names by groupd ids
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupsByIds($groupIds, $returnArray=false) {
		$userGroups = [];
		if(!is_array($groupIds)) {
			$groupIds = explode(',', $groupIds);
		}
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.name'])
				->where(['UserGroups.id IN'=>$groupIds])
				->order(['UserGroups.name'])
				->hydrate(false)
				->toArray();
		foreach($result as $row) {
			$userGroups[$row['id']] = $row['name'];
		}
		if(!$returnArray) {
			$userGroups = implode(', ', $userGroups);
		}
		return $userGroups;
	}
	/**
	 * Used to get all groups
	 *
	 * @access public
	 * @return array
	 */
	public function getAllGroups($sel=true) {
		$userGroups = [];
		if($sel) {
			$userGroups[''] = __('Select');
		}
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.name'])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.name'=>'ASC'])
				->hydrate(false)
				->toArray();
		foreach($result as $row) {
			$userGroups[$row['id']] = $row['name'];
		}
		return $userGroups;
	}
	/**
	 * Used to get parent group names with ids without guest group
	 *
	 * @access public
	 * @return array
	 */
	public function getParentGroups($skipGroupId=0) {
		$userGroups = [];
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.name'])
				->where(['UserGroups.name !='=>'Guest', 'UserGroups.parent_id'=>0])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.id'=>'ASC'])
				->hydrate(false)
				->toArray();
		$userGroups[0] = __('No Group');
		foreach($result as $row) {
			if(!($skipGroupId && $row['id'] == $skipGroupId)) {
				$userGroups[$row['id']] = $row['name'];
			}
		}
		return $userGroups;
	}
	/**
	 * Used to get group names with ids
	 *
	 * @access public
	 * @return array
	 */
	public function getParentGroupDetails() {
		$userGroups = $this->find()
				->select(['UserGroups.id', 'UserGroups.name', 'UserGroups.parent_id'])
				->where(['UserGroups.parent_id'=>0])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.id'])
				->hydrate(false)
				->toArray();
		return $userGroups;
	}
	/**
	 * Used to get sub group names with ids
	 *
	 * @access public
	 * @return array
	 */
	public function getSubGroupDetails() {
		$userGroups = $this->find()
				->select(['UserGroups.id', 'UserGroups.name', 'UserGroups.parent_id'])
				->where(['UserGroups.parent_id !='=>0])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.id'])
				->hydrate(false)
				->toArray();
		return $userGroups;
	}
	/**
	 * Used to get parent group ids
	 *
	 * @access public
	 * @return array
	 */
	public function getParentGroupIds($subGroupIds) {
		$userGroups = [];
		$result = $this->find()
				->select(['UserGroups.id', 'UserGroups.parent_id'])
				->where(['UserGroups.id IN'=>$subGroupIds])
				->where( [ 'UserGroups.id !=' => ADMIN_GROUP_ID ])
				->order(['UserGroups.id'])
				->hydrate(false)
				->toArray();
		foreach($result as $row) {
			$userGroups[$row['id']] = $row['parent_id'];
		}
		return $userGroups;
	}
}