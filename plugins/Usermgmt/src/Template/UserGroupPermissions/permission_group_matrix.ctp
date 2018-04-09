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
<script type="text/javascript">
	$(function(){
		$('.contcheckall').change(function() {
			if($(this).is(':checked')) {
				$(".contcheck").prop("checked", true);
			} else {
				$(".contcheck").prop("checked", false);
			}
		});
		$('.grpcheckall').change(function() {
			if($(this).is(':checked')) {
				$(".grpcheck").prop("checked", true);
			} else {
				$(".grpcheck").prop("checked", false);
			}
		});
		$('#perOptions').click(function() {
			$('#perOptionsDetails').slideToggle();
		});
	});
	function validateForm() {
		if(!$(".contcheck").is(':checked')) {
			alert("<?php echo __('Please select atleast one controller to get permissions');?>");
			return false;
		} else {
		}
		return true;
	}
</script>
<style type="text/css">
	.input.checkbox {
		margin:0;
	}
	.input.checkbox input {
		margin:0;
		position:relative;
	}
</style>


<?php 

$this->Html->addCrumb(__('Parent Group Permissions Matrix'), ['controller' => 'UserGroupPermissions', 'action' => 'permissionGroupMatrix','plugin' => 'Usermgmt']);


?>


<?php $this->assign('title', __('Parent Group Permissions Matrix')   );  ?>
<?php $this->assign('header_title', __('Parent Group Permissions Matrix')   );  ?>





<div id='per_loading_text' class="note note-warning">
     

    <?php echo __('Please wait while page is loading...');?>


</div>





<div class="portlet light bordered">
	<div class="portlet-title">
		
			<div class="caption">
			<span class="caption-subject font-dark bold uppercase"><i class="fa fa-list"></i></span>
			</div>

			<div class="actions">

				<div class="btn-group">
						<a class="btn  btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <?= __('Actions')?>
                                                                        <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                        	<li>
                <?php echo "<a id='perOptions'  href='javascript:void(0)'>".__('Choose Options')."</a>"; ?>
                            </li>

                            <li>
                            	<?php echo $this->Html->link(__('Check Permission Changes'), ['controller'=>'UserGroupPermissions', 'action'=>'printPermissionChanges', 'plugin'=>'Usermgmt']);?>

                            </li>
                        </ul>
						

				</div>
				 
			</div>
	</div>
	<div class="portlet-body">
		
		<div class="note note note-info">
                                           <p> <?php echo $this->Html->image(SITE_URL.'usermgmt/img/approve.png', ['alt'=>__('Yes')]); ?>
                                            <?php echo __("The group has permission of controller's action");?> </p>
        </div>

        <div class="note note-danger">
                                            
                                           <p><?php echo $this->Html->image(SITE_URL.'usermgmt/img/remove.png', ['alt'=>__('No')]); ?> 
                                           		<?php echo __("The group has not permission of controller's action");?>
                                           </p>
        </div>




        <div style="display:<?php if(!empty($selectedControllers)) { echo 'none'; } ?>" id="perOptionsDetails">
			<?php echo $this->Form->create($userGroupPermissionEntity, ['onSubmit'=>'return validateForm()']); ?>

			
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					
					<div class="caption">
                        <i class="fa fa-users"></i><?= __('Groups') ?> 
                    </div>
				</div>

				<div class="portlet-body">
					<div class="table-scrollable" >
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php
										$checked = false;
										if(!empty($userGroupPermissionEntity['sel_grp_all']) || count($userGroups) == count($selectedUserGroups)) {
											$checked = true;
										}
										echo $this->Form->input('UserGroupPermissions.sel_grp_all', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'checked'=>$checked, 'class'=>'grpcheckall']); ?>
									</th>
									<th><?php echo __('Group');?></th>
								</tr>
							</thead>
							<tbody>
						<?php	if(!empty($userGroups)) {
									foreach($userGroups as $group) {
										$checked = false;
										if(!empty($selectedUserGroupIds[$group['id']])) {
											$checked = true;
										}
										echo "<tr>";
											echo "<td>";
												echo $this->Form->input('UserGroupPermissions.GroupList.'.$group['id'].'.grpcheck', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'hiddenField'=>false, 'checked'=>$checked, 'class'=>'grpcheck']);
											echo "</td>";
											echo "<td>".$group['name']."</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					
					<div class="caption">
                        <i class="fa fa-list"></i><?= __('Permisos') ?> 
                    </div>
				</div>

				<div class="portlet-body">

			<div class="table-scrollable" >
				<table class="table table-hover">
					<thead>
						<tr>
							<th><?php
								$checked = false;
								if(!empty($userGroupPermissionEntity['sel_cont_all'])) {
									$checked = true;
								}
								echo $this->Form->input('UserGroupPermissions.sel_cont_all', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'checked'=>$checked, 'class'=>'contcheckall']); ?>
							</th>
							<?php if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID ): ?> 
							<th><?php echo __('Prefix'); ?></th>
							<?php endif; ?>
							<?php if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID ): ?> 
							<th><?php echo __('Plugin'); ?></th>
							<?php endif; ?>
							<th><?php echo __('Module'); ?></th>
						</tr>
					</thead>
					<tbody>
				<?php	if(!empty($allControllerClasses)) {
							foreach($allControllerClasses as $key=>$controllerClass) {
								$ppc = $controllerClass['prefix'].":".$controllerClass['plugin'].":".$controllerClass['controller'];
								$checked = false;
								if(!empty($selectedControllers[$ppc])) {
									$checked = true;
								}
								echo "<tr>";
									echo "<td>";
										echo $this->Form->input('UserGroupPermissions.ControllerList.'.$key.'.name', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'hiddenField'=>false, 'checked'=>$checked, 'class'=>'contcheck', 'value'=>$ppc]);
									echo "</td>";
									if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID )
									echo "<td>".str_replace('.', '/', $controllerClass['prefix'])."</td>";
									if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID )
									echo "<td>".$controllerClass['plugin']."</td>";
									echo "<td>".$controllerClass['controller']."</td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
				</table>
				<div style="float:left">
				<?php echo $this->Form->Submit(__('Get Permissions'), ['class'=>'btn btn-primary']); ?>
				</div>
			</div>
			</div>
			</div>
			
			<div class="clearfix"></div>
			<?php echo $this->Form->end(); ?>
		</div>




<?php	if(!empty($selectedControllers)) { ?>


<div class="portlet box blue-hoki">
				<div class="portlet-title">
					
					<div class="caption">
                        <i class="fa fa-list"></i><?= __('Matrix') ?> 
                    </div>
				</div>

				<div class="portlet-body">


<div class="table-scrollable">
			<table class="table table-hover groupMatrix" style='width:auto'>
				<thead>
					<tr id='per_float_header' >
						
						<?php if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID ): ?>
						<th><div style='width:100px'><?php echo __('Prefix');?></div></th>
						<?php endif; ?>

						<?php if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID ): ?>
						<th><div style='width:100px'><?php echo __('Plugin');?></div></th>
						<?php endif; ?>
						<th><div style='width:100px'><?php echo __('Controller');?></div></th>
						<th><div style='width:130px'><?php echo __('Action');?></div></th>
						<?php foreach($selectedUserGroups as $group) {
							echo "<th style='padding:0;text-align:center;'><div class='break-word' style='width:65px'>".$group['name']."</div></th>";
						} ?>
					</tr>
				</thead>
				<tbody>
			<?php	foreach($selectedControllers as $key=>$row) {
						$ppc = $row['prefix'].':'.$row['plugin'].':'.$row['controller'];
						$plugin = ($row['plugin']) ? $row['plugin'] : 'false';
						$prefix = ($row['prefix']) ? $row['prefix'] : 'false';
						if(!empty($row['actions'])) {
							foreach($row['actions'] as $action) {
								echo "<tr>";
									
									if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID )
									echo "<td><div class='break-word' style='width:100px'>".str_replace('.', '/', $row['prefix'])."</div></td>";
									

									if( $this->UserAuth->getGroupId() == ADMIN_GROUP_ID )

									echo "<td><div class='break-word' style='width:100px'>".$row['plugin']."</div></td>";


									echo "<td><div class='break-word' style='width:100px'>".$row['controller']."</div></td>";
									echo "<td><div class='break-word' style='width:130px'>".$action;
									if(!empty($funcDesc[$ppc][$action])) {
										echo "<br/><span style='color:red;font-size:10px;font-style:italic'>".$funcDesc[$ppc][$action]."</span>";
									}
									echo "</div></td>";
									foreach($selectedUserGroups as $group) {
										echo "<td style='text-align:center;padding:5px' class='permission'><div style='width:55px;height:20px;margin:0px auto;'>";
											if(isset($dbPermissions[$ppc][$action][$group['id']]) && $dbPermissions[$ppc][$action][$group['id']] == 1) {
												$img = $this->Html->image(SITE_URL.'usermgmt/img/approve.png', ['alt'=>__('Yes')]);
											} else {
												$img = $this->Html->image(SITE_URL.'usermgmt/img/remove.png', ['alt'=>__('No')]);
											}
											echo $this->Html->link($img, ['action'=>'changePermission', $row['controller'], $action, $group['id'], $plugin, $prefix], ['escape'=>false, 'class'=>'changePermission', 'title'=>$group['name'].' (Click to change permission)']);
										echo "</div></td>";
									}
								echo "</tr>";
							}
						}
						if(!empty($actions)) {
							echo "<tr><td colspan='".(count($selectedUserGroups) + 3)."'><br/></td></tr>";
						}
					} ?>
				</tbody>
			</table>

			</div>

			</div>
			</div>
		<?php } ?>


	</div>

</div>




</div>