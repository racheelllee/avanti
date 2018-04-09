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
<style type="text/css">
	.chosen-container {
		width:100% !important;
	}
	.chosen-choices .search-field .default {
		width:auto !important;
	}
	.chosen-container .chosen-drop {
		width:100% !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function(e) {
	if($.fn.chosen) {
		$("#useremails-user-group-id").chosen();
		$("#useremails-user-id").ajaxChosen({
			dataType: 'json',
			type: 'POST',
			url: urlForJs+'usermgmt/UserEmails/searchEmails'
		},{
			loadingImg: urlForJs+'usermgmt/img/loading-circle.gif'
		});
	}
	$('#useremails-type-users').click(function() {
		$("#groupSearch").hide();
		$("#manualEmail").hide();
		$("#userSearch").show();
	});
	$('#useremails-type-groups').click(function() {
		$("#userSearch").hide();
		$("#manualEmail").hide();
		$("#groupSearch").show();
	});
	$('#useremails-type-manual').click(function() {
		$("#userSearch").hide();
		$("#groupSearch").hide();
		$("#manualEmail").show();
	});
});
</script>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Send Mail'); ?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index'], ['class'=>'btn btn-default']); ?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'sendMailForm', 'submitButtonId'=>'sendMailSubmitBtn']); ?>
		<?php echo $this->Form->create($userEmailEntity, ['id'=>'sendMailForm', 'class'=>'form-horizontal', 'novalidate'=>true]); ?>
		<?php
			$userSearch = $groupSearch = $manualEmail = 'none';
			if(!isset($userEmailEntity['type']) || (isset($userEmailEntity['type']) && $userEmailEntity['type'] == 'USERS')) {
				$userSearch = '';
			}
			if(isset($userEmailEntity['type']) && $userEmailEntity['type'] == 'GROUPS') {
				$groupSearch = '';
			}
			if(isset($userEmailEntity['type']) && $userEmailEntity['type'] == 'MANUAL') {
				$manualEmail = '';
			}
		?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Type'); ?></label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('UserEmails.type', ['type'=>'radio', 'options'=>['USERS'=>'Selected Users', 'GROUPS'=>'Group Users', 'MANUAL'=>'Manual Emails'], 'div'=>false, 'label'=>false, 'legend'=>false, 'default'=>'USERS', 'autocomplete'=>'off']); ?>
			</div>
		</div>
		<div class="um-form-row form-group" id='userSearch' style="display:<?php echo $userSearch; ?>">
			<label class="col-sm-2 control-label required"><?php echo __('Select User(s)'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.user_id', ['type'=>'select', 'multiple'=>true, 'options'=>$sel_users, 'label'=>false, 'div'=>false, 'autocomplete'=>'off', 'data-placeholder'=>'Select User(s)', 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group" id='groupSearch' style="display:<?php echo $groupSearch; ?>">
			<label class="col-sm-2 control-label required"><?php echo __('Select Groups(s)'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.user_group_id', ['type'=>'select', 'multiple'=>true, 'options'=>$groups, 'div'=>false, 'label'=>false, 'autocomplete'=>'off', 'data-placeholder'=>'Select Group(s)', 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group" id='manualEmail' style="display:<?php echo $manualEmail; ?>">
			<label class="col-sm-2 control-label required"><?php echo __('To Email(s)'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.to_email', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
				<span class='tagline'><?php echo __('multiple emails comma separated'); ?></span>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('CC To'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.cc_to', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
				<span class='tagline'><?php echo __('multiple emails comma separated'); ?></span>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('From Name'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.from_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('From Email'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.from_email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Subject'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.subject', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Select Template'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.template', ['type'=>'select', 'options'=>$templates, 'div'=>false, 'label'=>false, 'autocomplete'=>'off', 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Select Signature'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('UserEmails.signature', ['type'=>'select', 'options'=>$signatures, 'div'=>false, 'label'=>false, 'autocomplete'=>'off', 'class'=>'form-control']); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Schedule Date'); ?></label>
			<div class="col-sm-8">
				<?php echo $this->Form->input('UserEmails.schedule_date', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datetimepicker', 'style'=>'width: 200px', 'autocomplete'=>'off']); ?>
				<span class='help-block'><?php echo __('If you enter schedule date, emails will not be send right now. You need to setup cron job to send scheduled emails. Please refer to documentation for cron job setup.');?></span>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Message'); ?></label>
			<div class="col-sm-8">
		<?php	if(strtoupper(DEFAULT_HTML_EDITOR) == 'TINYMCE') {
					echo $this->Tinymce->textarea('UserEmails.message', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en'], 'umcode');
				} else if(strtoupper(DEFAULT_HTML_EDITOR) == 'CKEDITOR') {
					echo $this->Ckeditor->textarea('UserEmails.message', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en', 'uiColor'=>'#14B8C4'], 'full');
				}?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Next'), ['class'=>'btn btn-primary', 'id'=>'sendMailSubmitBtn']); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>