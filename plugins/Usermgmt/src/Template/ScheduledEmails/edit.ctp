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
			<?php echo __('Edit Scheduled Email'); ?>
		</span>
		<span class="panel-title-right">
			<?php $page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;?>
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index', 'page'=>$page], ['class'=>'btn btn-default']);?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'scheduledEmailForm', 'submitButtonId'=>'scheduledEmailSubmitBtn']); ?>
		<?php echo $this->Form->create($scheduledEmailEntity, ['id'=>'scheduledEmailForm', 'class'=>'form-horizontal', 'novalidate'=>true]); ?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Type'); ?></label>
			<div class="col-sm-3">
				<?php if($scheduledEmailEntity['type'] == 'USERS') {
					echo __('Selected Users');
				} else if($scheduledEmailEntity['type'] == 'GROUPS') {
					echo __('Group Users');
				} else {
					echo __('Manual Emails');
				} ?>
			</div>
		</div>
		<?php if($scheduledEmailEntity['type'] == 'GROUPS') { ?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Group(s)'); ?></label>
			<div class="col-sm-3">
				<?php
				$groupNames = [];
				$scheduledEmailEntity['user_group_id'] = explode(',', $scheduledEmailEntity['user_group_id']);
				foreach($scheduledEmailEntity['user_group_id'] as $groupId) {
					$groupNames[] = $groups[$groupId];
				}
				echo implode(', ', $groupNames);?>
			</div>
		</div>
		<?php } ?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('CC To'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('ScheduledEmails.cc_to', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
				<span class='tagline'><?php echo __('multiple emails comma separated'); ?></span>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('From Name'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('ScheduledEmails.from_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('From Email'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('ScheduledEmails.from_email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Subject'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('ScheduledEmails.subject', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Schedule Date'); ?></label>
			<div class="col-sm-8">
				<?php echo $this->Form->input('ScheduledEmails.schedule_date', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datetimepicker', 'style'=>'width: 200px', 'autocomplete'=>'off']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Message'); ?></label>
			<div class="col-sm-8">
		<?php	if(strtoupper(DEFAULT_HTML_EDITOR) == 'TINYMCE') {
					echo $this->Tinymce->textarea('ScheduledEmails.message', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en'], 'umcode');
				} else if(strtoupper(DEFAULT_HTML_EDITOR) == 'CKEDITOR') {
					echo $this->Ckeditor->textarea('ScheduledEmails.message', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en', 'uiColor'=>'#14B8C4'], 'full');
				}?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Update'), ['class'=>'btn btn-primary', 'id'=>'scheduledEmailSubmitBtn']); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>