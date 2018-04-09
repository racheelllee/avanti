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
$this->Html->addCrumb(__('Edit Static Page'), ['controller' => 'StaticPages', 'action' => 'edit','plugin' => 'Usermgmt', $staticPageEntity->id]);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Edit Static Page'); ?>
		</span>
		<span class="panel-title-right">
			
		</span>
	</div>
	<div class="panel-body ca-form">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'addPageForm', 'submitButtonId'=>'editPageSubmitBtn']); ?>
		<?php echo $this->Form->create($staticPageEntity, ['id'=>'addPageForm', 'class'=>'form-horizontal']); ?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Page Name'); ?></label>
			<div class="col-sm-4 required">
				<?php echo $this->Form->input('StaticPages.page_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
				<?php  __('For ex. Contact Us, About Us'); ?>
			</div>
		</div>
		
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Page Title'); ?></label>
			<div class="col-sm-4">
				<?php echo $this->Form->input('StaticPages.page_title', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
				<?php  __('For ex. Your Contact Details'); ?>
			</div>
		</div>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label"><?php echo __('Page Content'); ?></label>
			<div class="col-sm-12 required">
		<?php	
				if(strtoupper(DEFAULT_HTML_EDITOR) == 'TINYMCE') {
					echo $this->Tinymce->textarea('StaticPages.page_content', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:800px', 'class'=>'form-control tinymce'], ['language'=>'en'], 'umcode');
				} else if(strtoupper(DEFAULT_HTML_EDITOR) == 'CKEDITOR') {
					echo $this->Ckeditor->textarea('StaticPages.page_content', ['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:800px', 'class'=>'form-control'], ['language'=>'en', 'uiColor'=>'#14B8C4'], 'umcode');
				}?>
			</div>
		</div>
		<div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Save Page'), ['div'=>false, 'class'=>'btn btn-submit', 'id'=>'editPageSubmitBtn']); ?>
			
		</div>	
		<?php echo $this->Form->end(); ?>
	</div>
</div>