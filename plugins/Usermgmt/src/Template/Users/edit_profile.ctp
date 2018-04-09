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
$this->Html->addCrumb(__('Edit Profile'), ['controller' => 'Users', 'action' => 'editProfile','plugin' => 'Usermgmt']);
?>
<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Edit Profile'); ?>
		</span>
		<span class="panel-title-right">
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'editProfileForm', 'submitButtonId'=>'editProfileSubmitBtn']); ?>
		<?php echo $this->Form->create($userEntity, ['type'=>'file', 'id'=>'editProfileForm', 'class'=>'form-horizontal']); ?>


		<?php $changeUserName = (ALLOW_CHANGE_USERNAME || empty($userEntity['username'])) ? false : true; ?>

		<div class="ca-form">

			<div class="row">
				<div class="col-md-6">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label required"><?php echo __('First Name'); ?></label>
						<div class="col-md-10">
							<?php echo $this->Form->input('Users.first_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
			        <div class="um-form-row form-group">
			          <label class="col-sm-2 control-label"><?php echo __("Father's Last Name"); ?></label>
			          <div class="col-sm-10">
			            <?php echo $this->Form->input('Users.last_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			          </div>
			        </div>
			      </div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="um-form-row form-group">
			          <label class="col-sm-2 control-label"><?php echo __("Mother's Last Name"); ?></label>
			          <div class="col-sm-10">
			            <?php echo $this->Form->input('Users.clast_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
			          </div>
			        </div>
				</div>
				<div class="col-md-6">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label"><?php echo __('Photo');?></label>
						<div class="col-md-10">
							<?php echo $this->Form->input('Users.photo_file', ['type'=>'file', 'label'=>false, 'div'=>false]);?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 split-btn">
		    	<?php echo $this->Form->Submit(__('Update Profile'), ['class'=>'btn btn-submit', 'id'=>'editProfileSubmitBtn']); ?>
		  	</div>
		</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>