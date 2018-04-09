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
		$('.emailcheckall').change(function() {
			if($(this).is(':checked')) {
				$(".emailcheck").prop("checked", true);
			} else {
				$(".emailcheck").prop("checked", false);
			}
		});
	});
	function validateForm() {
		if(!$(".emailcheck").is(':checked')) {
			alert("<?php echo __('Please select atleast one user to send email');?>");
			return false;
		} else {
			if(<?php echo (empty($userEmailEntity['schedule_date'])) ? 1 : 0; ?>) {
				if(!confirm("<?php echo __('Are you sure, you want to continue sending emails?');?>")) {
					return false;
				}
			}
		}
		return true;
	}
</script>
<style type="text/css">
	.input.checkbox {
		margin:0;
	}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Confirm Sending Email'); ?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Edit', true), ['action'=>'send'], ['class'=>'btn btn-default']); ?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create($userEmailEntity, ['onSubmit'=>'return validateForm()']); ?>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<tbody>
				<tr>
					<th><?php echo __('Email Type');?></th>
					<td>
						<?php if($userEmailEntity['type'] == 'USERS') {
							echo __('Selected Users');
						} else if($userEmailEntity['type'] == 'GROUPS') {
							echo __('Group Users');
						} else {
							echo __('Manual Emails');
						} ?>
					</td>
				</tr>
				<?php if($userEmailEntity['type'] == 'GROUPS') { ?>
					<tr>
						<th><?php echo __('Group(s)');?></th>
						<td><?php
							$groupNames = [];
							foreach($userEmailEntity['user_group_id'] as $groupId) {
								$groupNames[] = $groups[$groupId];
							}
							echo implode(', ', $groupNames);?>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<th><?php echo __('CC Email(s)');?></th>
					<td><?php echo $userEmailEntity['cc_to']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('From Name');?></th>
					<td><?php echo $userEmailEntity['from_name']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('From Email');?></th>
					<td><?php echo $userEmailEntity['from_email']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('Email Subject');?></th>
					<td><?php echo $userEmailEntity['subject']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('Schedule Date');?></th>
					<td><?php
						if(!empty($userEmailEntity['schedule_date'])) {
							echo $userEmailEntity['schedule_date']->format('d-M-Y h:i A');
						}?>
					</td>
				</tr>
				<tr>
					<th><?php echo __('Email Message');?></th>
					<td><?php echo $userEmailEntity['modified_message']; ?></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th><?php echo __('#'); ?></th>
					<th style="vertical-align: top"><?php echo $this->Form->input('UserEmails.sel_all', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'checked'=>true, 'class'=>'emailcheckall', 'style'=>'margin-left:0px;']); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Email'); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php	if(!empty($users)) {
					$i = 1;
					foreach($users as $row) {
						$trclass = '';
						$checked = true;
						$cls = 'emailcheck';
						if(empty($row['email'])) {
							$trclass = 'error';
							$checked = false;
							$cls = '';
						}
						echo "<tr class='".$trclass."'>";
							echo "<td>".$i."</td>";
							echo "<td>";
								echo $this->Form->input('UserEmails.EmailList.'.$i.'.emailcheck', ['type'=>'checkbox', 'div'=>false, 'label'=>false, 'checked'=>$checked, 'class'=>$cls, 'hiddenField'=>false, 'style'=>'margin-left:0px']);
								echo $this->Form->input('UserEmails.EmailList.'.$i.'.uid', ['type'=>'hidden', 'value'=>$row['id']]);
								echo $this->Form->input('UserEmails.EmailList.'.$i.'.email', ['type'=>'hidden', 'value'=>$row['email']]);
							echo "</td>";
							echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
							echo "<td>".$row['email']."</td>";
						echo "</tr>";
						$i++;
					}
				} else {
					echo "<tr><td colspan=7><br/><br/>".__('No Users')."</td></tr>";
				} ?>
			</tbody>
		</table>
		<div class="um-button-row">
			<?php if(!empty($userEmailEntity['schedule_date'])) {
				echo $this->Form->Submit(__('Schedule Email'), ['class'=>'btn btn-primary', 'name'=>'confirmEmail']);
			} else {
				echo $this->Form->Submit(__('Send Email'), ['class'=>'btn btn-primary', 'name'=>'confirmEmail']);
			}?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>