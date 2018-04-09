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
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Permission Changes'); ?>
		</span>
	</div>
	<div class="panel-body">
		<h2><?php echo __('Controllers Not Added in Permission');?></h2>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th><?php echo __('Prefix'); ?></th>
					<th><?php echo __('Plugin'); ?></th>
					<th><?php echo __('Controller'); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php	foreach($filesControllerActions as $key=>$val) {
					if(!isset($dbControllerActions[$key])) {
						$keyArr = explode(':', $key);
						echo "<tr>";
							echo "<td>".str_replace('.', '/', $keyArr[0])."</td>";
							echo "<td>".$keyArr[1]."</td>";
							echo "<td>".$keyArr[2]."</td>";
						echo "</tr>";
					}
				}?>
			</tbody>
		</table>
		<br/>
		<h2><?php echo __('Actions Not Added in Permission'); ?></h2>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th><?php echo __('Prefix'); ?></th>
					<th><?php echo __('Plugin'); ?></th>
					<th><?php echo __('Controller'); ?></th>
					<th><?php echo __('Action'); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php	foreach($filesControllerActions as $key=>$val) {
					$keyArr = explode(':', $key);
					foreach($val as $act) {
						if(!isset($dbControllerActions[$key][$act])) {
							echo "<tr>";
								echo "<td>".str_replace('.', '/', $keyArr[0])."</td>";
								echo "<td>".$keyArr[1]."</td>";
								echo "<td>".$keyArr[2]."</td>";
								echo "<td>".$act."</td>";
							echo "</tr>";
						}
					}
				}?>
			</tbody>
		</table>
		<br/>
		<h2><?php echo __('Extra Controllers Added in Permission Table'); ?></h2>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th><?php echo __('Prefix'); ?></th>
					<th><?php echo __('Plugin'); ?></th>
					<th><?php echo __('Controller'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
		<?php	foreach($dbControllerActions as $key=>$val) {
					if(!isset($filesControllerActions[$key])) {
						$keyArr = explode(':', $key);
						echo "<tr>";
							echo "<td>".str_replace('.', '/', $keyArr[0])."</td>";
							echo "<td>".$keyArr[1]."</td>";
							echo "<td>".$keyArr[2]."</td>";
							$prefix = ($keyArr[0]) ? $keyArr[0] : 'false';
							$plugin = ($keyArr[1]) ? $keyArr[1] : 'false';
							echo "<td>".$this->Form->postlink(__('Remove'), ['controller'=>'UserGroupPermissions', 'action'=>'printPermissionChanges', 'plugin'=>'Usermgmt', $prefix, $plugin, $keyArr[2]], ['class'=>'btn btn-primary', 'confirm'=>__('Are you sure, you want to delete permissions of this controller along with it\'s actions?')])."</td>";
						echo "</tr>";
					}
				}?>
			</tbody>
		</table>
		<br/>
		<h2><?php echo __('Extra Actions Added in Permission Table'); ?></h2>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th><?php echo __('Prefix'); ?></th>
					<th><?php echo __('Plugin'); ?></th>
					<th><?php echo __('Controller'); ?></th>
					<th><?php echo __('Action'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
		<?php	foreach($dbControllerActions as $key=>$val) {
					$keyArr = explode(':', $key);
					foreach($val as $act) {
						if(!isset($filesControllerActions[$key][$act])) {
							echo "<tr>";
								echo "<td>".str_replace('.', '/', $keyArr[0])."</td>";
								echo "<td>".$keyArr[1]."</td>";
								echo "<td>".$keyArr[2]."</td>";
								echo "<td>".$act."</td>";
								$prefix = ($keyArr[0]) ? $keyArr[0] : 'false';
								$plugin = ($keyArr[1]) ? $keyArr[1] : 'false';
								echo "<td>".$this->Form->postlink(__('Remove'), ['controller'=>'UserGroupPermissions', 'action'=>'printPermissionChanges', 'plugin'=>'Usermgmt', $prefix, $plugin, $keyArr[2], $act], ['class'=>'btn btn-primary btn-sm', 'confirm'=>__('Are you sure, you want to delete permissions of this action?')])."</td>";
							echo "</tr>";
						}
					}
				}?>
			</tbody>
		</table>
	</div>
</div>