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
		$("#usersettings-category-type-existing").click(function(e) {
			$(".existing-category").show();
			$(".new-category").hide();
		});
		$("#usersettings-category-type-new").click(function(e) {
			$(".new-category").show();
			$(".existing-category").hide();
		});
	});
</script>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Add Setting');?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index'], ['class'=>'btn btn-default']);?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'addSettingForm', 'submitButtonId'=>'addSettingSubmitBtn']);?>
		<?php echo $this->Form->create($settingEntity, ['id'=>'addSettingForm', 'class'=>'form-horizontal']);?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Category Type');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.category_type', ['type'=>'radio', 'options'=>['existing'=>'Select Existing', 'new'=>'Add New'], 'div'=>false, 'label'=>false, 'legend'=>false, 'default'=>'existing', 'autocomplete'=>'off']);?>
			</div>
		</div>
		<div class="um-form-row form-group existing-category" style="<?php if(isset($settingEntity['category_type']) && $settingEntity['category_type'] != 'existing') { echo 'display:none'; } ?>">
			<label class="col-sm-2 control-label required"><?php echo __('Category');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.category', ['type'=>'select', 'options'=>$settingCategories, 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="um-form-row form-group new-category" style="<?php if(!isset($settingEntity['category_type']) || $settingEntity['category_type'] != 'new') { echo 'display:none'; } ?>">
			<label class="col-sm-2 control-label required"><?php echo __('Category');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.new_category', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Input Type');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.type', ['type'=>'select', 'options'=>$settingInputTypes, 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Name/Key');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
				<span class='help-block'><?php echo __('for ex. site_name (no space, only small letters, underscore)');?></span>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Display Name');?></label>
			<div class="col-sm-3">
				<?php echo $this->Form->input('UserSettings.display_name', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
				<span class='help-block'><?php echo __('for ex. Enter Your Full Site Name');?></span>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Next'), ['id'=>'addSettingSubmitBtn', 'class'=>'btn btn-primary']);?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>