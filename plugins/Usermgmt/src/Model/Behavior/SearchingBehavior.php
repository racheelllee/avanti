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
namespace Usermgmt\Model\Behavior;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Query;

class SearchingBehavior extends Behavior {

	var $searchValues = [];
	var $model;
	var $alias;
	var $config = [];
	var $settings = [];
	var $originalConditions = [];
	var $applySearch = false;

	public function __construct(Table $table, array $config = []) {
		$this->model = $table;
		$this->alias = $table->alias();
		$this->config = $config;
		parent::__construct($table, $config);
	}
	public function initialize(array $config) {
		$default = ['type'=>'text', 'condition'=>'like'];
		foreach($config as $key=>$value) {
			$this->settings[$this->alias][$key] = array_merge($default, $value);
		}
		$this->searchValues[$this->alias] = [];
	}
	function setSearchValues($values = array()) {
		$this->searchValues[$this->alias] = array_merge($this->searchValues[$this->alias], $values);
	}
	function setSearchSetting($originalConditions) {
		$this->applySearch = true;
		$this->originalConditions = $originalConditions;
	}
	function beforeFind(Event $event, Query $query, $options, $primary) {
		if($this->applySearch) {
			if(!isset($this->settings[$this->alias])) {
				return $query;
			}
			$settings = $this->settings[$this->alias];
			$values = $this->searchValues[$this->alias];
			if(isset($_POST['data']['search_clear']) && $_POST['data']['search_clear']==1) {
				return $query;
			}
			$conditions = $this->originalConditions;
			foreach($settings as $field=>$options) {
				$fieldModelName = $this->alias;
				$fieldName = $field;
				if(strpos($field, '.') !== false) {
					list($fieldModelName, $fieldName) = explode('.', $field);
				}
				if(!isset($values[$fieldModelName][$fieldName]) && isset($options['default'])) {
					$values[$fieldModelName][$fieldName] = $options['default'];
				}
				if(!isset($values[$fieldModelName][$fieldName]) || is_null($values[$fieldModelName][$fieldName])) {
					// no value to search with, just skip this field
					continue;
				}
				$searchValue = $values[$fieldModelName][$fieldName];
				if(isset($options['searchField'])) {
					$fieldName = $options['searchField'];
					if(strpos($fieldName, '.') !== false) {
						list($fieldModelName, $fieldName) = explode('.', $fieldName);
					}
				}
				$realSearchField = sprintf('%s.%s', $fieldModelName, $fieldName);
				switch($options['type']) {
					case 'text':
						if(strlen(trim(strval($searchValue))) == 0) {
							continue;
						}
						switch($options['condition']) {
							case 'like':
							case 'contains':
								$conditions[$realSearchField.' like'] = '%'.$searchValue.'%';
								break;
							case 'startswith':
								$conditions[$realSearchField.' like'] = $searchValue.'%';
								break;
							case 'endswith':
								$conditions[$realSearchField.' like'] = '%'.$searchValue;
								break;
							case '=':
								$conditions[$realSearchField] = $searchValue;
								break;
							case '<':
								$conditions[$realSearchField.' <'] = $searchValue;
								break;
							case '>':
								$conditions[$realSearchField.' >'] = $searchValue;
								break;
							case '<=':
								if($searchValue == date('Y-m-d', strtotime($searchValue))) {
									$searchValue = date('Y-m-d 23:59:59', strtotime($searchValue));
								}
								$conditions[$realSearchField.' <='] = $searchValue;
								break;
							case '>=':
								if($searchValue == date('Y-m-d', strtotime($searchValue))) {
									$searchValue = date('Y-m-d 00:00:00', strtotime($searchValue));
								}
								$conditions[$realSearchField.' >='] = $searchValue;
								break;
							case 'comma':
								$conditions['OR'] = [[$realSearchField=>$searchValue], [$realSearchField.' like'=>$searchValue.',%'], [$realSearchField.' like'=>'%,'.$searchValue.',%'], [$realSearchField.' like'=>'%,'.$searchValue]];
								break;
							case 'multiple':
								if(isset($options['searchFields'])) {
									$cond = [];
									if(!isset($options['searchBreak']) || $options['searchBreak']) {
										$valueArray = explode(' ', $searchValue);
										foreach($valueArray as $v) {
											if(!empty($v)) {
												if($this->is_date($v)) {
													$v = date('Y-m-d', strtotime($v));
												}
												foreach($options['searchFields'] as $searchField) {
													$cond[] = [$searchField.' like'=>'%'.$v.'%'];
												}
											}
										}
									} else {
										$v = $searchValue;
										if(!empty($v)) {
											if($this->is_date($v)) {
												$v = date('Y-m-d', strtotime($v));
											}
											foreach($options['searchFields'] as $searchField) {
												$cond[] = [$searchField.' like'=>'%'.$v.'%'];
											}
										}
									}
									$conditions['OR'] = $cond;
								}
								break;
							default:
								$conditions[$realSearchField.' '.$options['condition']] = $searchValue;
								break;
						}
						break;
					case 'select':
						if(strlen(trim(strval($searchValue))) == 0) {
							if(isset($conditions[$realSearchField])) {
								unset($conditions[$realSearchField]);
							}
							continue;
						}
						switch($options['condition']) {
							case 'comma':
								$conditions['OR'] = [[$realSearchField=>$searchValue], [$realSearchField.' like'=>$searchValue.',%'], [$realSearchField.' like'=>'%,'.$searchValue.',%'], [$realSearchField.' like'=>'%,'.$searchValue]];
								break;
							default:
								$conditions[$realSearchField] = $searchValue;
								break;
						}
						break;
					case 'checkbox':
						$conditions[$realSearchField] = $searchValue;
						break;
				}
			}
			$query->where($conditions, [], true);
		}
		$this->applySearch = false;
		return $query;
	}
	function is_date($str) {
		if(is_numeric($str)) {
			return false;
		}
		$stamp = strtotime( $str );
		if(!is_numeric($stamp) || $stamp < 0) {
			return false;
		}
		$month = date( 'm', $stamp );
		$day = date( 'd', $stamp );
		$year = date( 'Y', $stamp );
		if(checkdate($month, $day, $year)) {
			return true;
		}
		return false;
	}
}