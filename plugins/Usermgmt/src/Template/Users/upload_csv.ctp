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
	ol.instructions li {
		margin-bottom:10px;
	}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Add Multiple Users'); ?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index'], ['class'=>'btn btn-default']); ?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create('User', ['class'=>'form-horizontal', 'type'=>'file']); ?>
		<div class="um-form-row form-group">
			<label class="col-sm-2 control-label required"><?php echo __('Select csv file'); ?></label>
			<div class="col-sm-2">
				<?php echo $this->Form->input('csv_file', ['type'=>'file', 'label'=>false, 'div'=>false, 'style'=>'width:auto;display:inline']); ?>
			</div>
			<div class="col-sm-2">
				<?php echo $this->Form->Submit(__('Upload'), ['class'=>'btn btn-primary', 'div'=>false, 'style'=>'margin-bottom:0']); ?>
			</div>
		</div>
		<hr/>
		<?php echo $this->Form->end(); ?>
		<div style="margin-left:20px;">
			<strong style="margin-left:5px;"><?php echo __('Instructions for CSV file'); ?></strong>
			<br/><br/>
			<ol class="instructions">
				<li><?php echo __('First line should be table fields name'); ?></li>
				<li><?php echo __('You can add one or more than one users'); ?></li>
				<li><?php echo __('leave blank for empty values'); ?></li>
				<li>
					<?php echo __('For user group id field value should be in following'); ?>
					<?php foreach($userGroups as $key=>$val) {
						echo "<br/><strong>For ".$val." set ".$key."</strong>";
					} ?>
				</li>
				<li><?php echo __('For multiple groups set group ids comma separated without space for e.g. 1,2'); ?></li>
				<li>
					<?php echo __('For gender field value should be in following'); ?>
					<?php foreach($genders as $key=>$val) {
						echo "<br/><strong>".$key."</strong>";
					} ?>
				</li>
				<li><?php echo __('For Birthday date format should be Ymd format for e.g. 1999-01-25'); ?></li>
				<li><a href='<?php echo SITE_URL.'usermgmt/files/sample_multiple_users.csv'?>' target='_blank'><?php echo __('Sample CSV File');?></a> <?php echo __('for multiple users');?></li>
			</ol>
		</div>
	</div>
</div>