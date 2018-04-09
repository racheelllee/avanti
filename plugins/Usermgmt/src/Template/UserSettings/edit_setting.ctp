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
		$("#usersettings-type").change(function(e) {
			$.umpuso.showInput();
		});
		$(".optionLink").click(function(e) {
			e.preventDefault();
			$('#settingOptionsModal').modal({
				keyboard: false
			});
		});
		$(document).on('click', '.selected-setting-options .soption', function(e) {
			var pelem = $(this).closest('li');
			$('.available-setting-options').append($(pelem));
			$.umpuso.sortOptions('.available-setting-options');
			$.umpuso.updateOptions();
		});
		$(document).on('click', '.available-setting-options .soption', function(e) {
			var pelem = $(this).closest('li');
			$('.selected-setting-options').append($(pelem));
			$.umpuso.sortOptions('.selected-setting-options');
			$.umpuso.updateOptions();
		});
		var tmpvalue = 9999999999;
		$(document).on('click', '.addNewOption', function(e) {
			e.preventDefault();
			var newoption = $.trim($(".new-option-section #new-option").val());
			if(newoption) {
				var tobeadded = true;
				var alloptions = $('.selected-setting-options li');
				$.each(alloptions, function (key, val) {
					if($(this).find('.option-title').html() == newoption) {
						tobeadded = false;
						alert('This option alreay exist in selected options');
						return false;
					}
				});
				var alloptions = $('.available-setting-options li');
				$.each(alloptions, function (key, val) {
					if($(this).find('.option-title').html() == newoption) {
						tobeadded = false;
						alert('This option alreay exist in available options');
						return false;
					}
				});
				if(tobeadded) {
					var html = '<li><label for="available-options-'+tmpvalue+'"><input type="checkbox" class="soption" checked="checked" name="options[]" value="newoption-'+newoption+'" id="available-options-'+tmpvalue+'"><span class="option-title">'+newoption+'</span></label></li>';
					$('.selected-setting-options').append($(html));
					$(".new-option-section #new-option").val('');
					$.umpuso.sortOptions('.selected-setting-options');
					$.umpuso.updateOptions();
					tmpvalue++;
				}
			} else {
				alert('Please enter new option value');
			}
		});
		$.umpuso.showInput();
	});
	(function($) {
		$.umpuso = {
			updateOptions: function() {
				var alloptions = $('.selected-setting-options li');
				if($("#usersettings-type").val() == 'dropdown') {
					var selected = $('#usersettings-dropdown-value').val();
					var dpoptions = '<option selected="selected" value="">Select</option>';
					$.each(alloptions, function (key, val) {
						dpoptions += '<option value="'+$(this).find('.soption').val()+'">'+$(this).find('.option-title').html()+'</option>';
					});
					$('#usersettings-dropdown-value').html(dpoptions);
					$('#usersettings-dropdown-value').val(selected);
				} else if($("#usersettings-type").val() == 'radio') {
					var selected = '';
					if($(".radioValue input[type='radio']:checked").length) {
						selected = $(".radioValue input[type='radio']:checked").val();
					}
					var raoptions = '<div class="input radio"><input type="hidden" value="" name="UserSettings[radio_value]">';
					$.each(alloptions, function (key, val) {
						val = $(this).find('.soption').val();
						var checked = '';
						if(selected == val) {
							var checked = 'checked="checked"';
						}
						raoptions += '<label for="usersettings-radio-value-'+val+'"><input type="radio" id="usersettings-radio-value-'+val+'" value="'+val+'" name="UserSettings[radio_value]" '+checked+'>'+$(this).find('.option-title').html()+'</label>';
					});
					raoptions += '</div>';
					$('.radioValue').html(raoptions);
				}
				$('.selected_options').html('');
				$.each(alloptions, function (key, val) {
					$('.selected_options').append('<input type="hidden" value="'+$(this).find('.soption').val()+'" name="UserSettings[options]['+key+']">');
				});
			},
			sortOptions: function(idx) {
				var alloptions = $(idx+' li');
				alloptions.sort(function(a, b) {
					return $(a).find('.option-title').text().toUpperCase().localeCompare($(b).find('.option-title').text().toUpperCase());
				});
				$.each(alloptions, function (key, val) {
					$(idx).append($(this));
				});
			},
			showInput: function() {
				var type = $("#usersettings-type").val();
				$(".inputValue, .checkboxValue, .dropdownValue, .radioValue, .tinymceValue, .ckeditorValue, .textareaValue, .optionLink, .uploadValue").hide();
				if(type) {
					$('.'+type+"Value").show();
					if(type == 'dropdown' || type == 'radio') {
						$(".optionLink").show();
						$.umpuso.updateOptions();
					}
				}
			}
		}
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Edit Setting');?>
		</span>
		<span class="panel-title-right">
			<?php $page = (isset($this->request->query['page'])) ? $this->request->query['page'] : 1;?>
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index', 'page'=>$page], ['class'=>'btn btn-default']);?>
		</span>
	</div>
	<div class="panel-body">
		<div class="well"><span class="label label-danger">Please Note</span> Do not edit Name/Key for existing settings, it may break your site code.</div>
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'editSettingForm', 'submitButtonId'=>'editSettingSubmitBtn']);?>
		<?php echo $this->Form->create($settingEntity, ['id'=>'editSettingForm', 'class'=>'form-horizontal', 'enctype' => 'multipart/form-data']);?>
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
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Value');?></label>
	<?php
			echo "<div class='col-sm-3 inputValue'>".$this->Form->input('UserSettings.input_value', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control'])."</div>";

			echo "<div class='col-sm-1 checkboxValue'>".$this->Form->input('UserSettings.checkbox_value', ['type'=>'checkbox', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'style'=>'height: auto'])."</div>";

			echo "<div class='col-sm-3 dropdownValue'>".$this->Form->input('UserSettings.dropdown_value', ['type'=>'select', 'options'=>$userSettingOptions, 'empty'=>__('Select'), 'label'=>false, 'div'=>false, 'class'=>'form-control'])."</div>";

			echo "<div class='col-sm-3 radioValue'>".$this->Form->input('UserSettings.radio_value', ['type'=>'radio', 'options'=>$userSettingOptions, 'label'=>false, 'div'=>false, 'legend'=>false, 'class'=>'form-control'])."</div>";

			echo "<div class='col-sm-5 textareaValue'>".$this->Form->input('UserSettings.textarea_value', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'class'=>'form-control'])."</div>";

			echo "<div class='col-sm-8 tinymceValue'>".$this->Tinymce->textarea('UserSettings.tinymce_value', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:300px', 'class'=>'form-control'], ['language'=>'en'], 'umcode')."</div>";

			echo "<div class='col-sm-8 ckeditorValue'>".$this->Ckeditor->textarea('UserSettings.ckeditor_value', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:300px', 'class'=>'form-control'], ['language'=>'en', 'uiColor'=>'#14B8C4'], 'full')."</div>";

			echo "<div class='col-sm-3 uploadValue'>".$this->Form->input('UserSettings.upload_value', ['type' => 'file', 'label'=>false, 'div'=>false, 'class'=>'form-control'])."</div>";

			echo $this->Html->link(__('Add/Remove Options', true), '#', ['class'=>'btn btn-primary btn-xs optionLink']);
		?>
		</div>
		<div class="um-button-row">
			<div class="selected_options">
		<?php	$i = 0;
				foreach($userSettingOptions as $key=>$val) {
					echo "<input type='hidden' value='".$key."' name='UserSettings[options][".$i."]'>";
					$i++;
				}?>
			</div>
			<?php echo $this->Form->Submit(__('Update Setting'), ['id'=>'editSettingSubmitBtn', 'class'=>'btn btn-primary']);?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
<div class="modal fade" role="dialog" aria-labelledby="settingOptionsLabel" id="settingOptionsModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Selected Options');?></div>
					<div class="panel-body">
						<ul class="setting-options selected-setting-options">
				<?php	foreach($userSettingOptions as $key=>$val) {
							echo "<li>";
								echo "<label for='available-options-".$key."'>";
									echo "<input id='available-options-".$key."' type='checkbox' value='".$key."' name='options[]' checked='checked' class='soption'>";
									echo "<span class='option-title'>".$val."</span>";
								echo "</label>";
							echo "</li>";
						}?>
						</ul>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Available Options');?></div>
					<div class="panel-body">
						<ul class="setting-options available-setting-options">
				<?php	foreach($settingOptions as $key=>$val) {
							if(!isset($userSettingOptions[$key])) {
								echo "<li>";
									echo "<label for='available-options-".$key."'>";
										echo "<input id='available-options-".$key."' type='checkbox' value='".$key."' name='options[]' class='soption'>";
										echo "<span class='option-title'>".$val."</span>";
									echo "</label>";
								echo "</li>";
							}
						}?>
						</ul>
					</div>
				</div>
				<div class="new-option-section">
					<label><?php echo __('Add New Option');?></label>
					<?php echo $this->Form->input('new_option', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']);?>
					<br/>
					<?php echo $this->Html->link(__('Add Option', true), '#', ['class'=>'btn btn-primary btn-xs addNewOption']);?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Done');?></button>
			</div>
		</div>
	</div>
</div>