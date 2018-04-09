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
$this->Html->addCrumb(__('My Profile'), ['controller' => 'Users', 'action' => 'myprofile','plugin' => 'Usermgmt']);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('My Profile'); ?>
		</span>
		<span class="panel-title-right">
			
		</span>
	</div>
	<div class="panel-body">
		<div style="display:inline-block;">
			<table class="table-condensed" style="width:auto">
				<tbody>
					<tr>
						<td>
							<div class="profile">
								<img alt="<?php echo h($user['first_name'].' '.$user['last_name']); ?>" src="<?php echo $this->Image->resize('library/'.IMG_DIR, $user['photo'], 200, null, true);?>">
							</div>
						</td>
						<td><h1><?php echo h($user['first_name']).' '.h($user['last_name']);?></h1></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="ca-form">

			<div class="row">
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('First Name'); ?></label>
						<?php echo h($user['first_name']);?>
					</div>
	    		</div>
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __("Father's Last Name"); ?></label>
						<?php echo h($user['last_name']);?>
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __("Mother's Last Name"); ?></label>
						<?php echo h($user['clast_name']);?>
					</div>
	    		</div>
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Email'); ?></label>
						<?php echo h($user['email']);?>
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Mobile Phone'); ?></label>
						<?php echo h($user['phone']);?>
					</div>
	    		</div>
	    		<div class="col-md-6">
					<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Gender'); ?></label>
						<?php echo ($user['gender'] == 'M') ? 'Masculino' : 'Femenino'; ?>
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Día / Mes de Nacimiento'); ?></label>
						<?php echo ( $user['day_birthday'] )? $days[ $user['day_birthday'] ] : '';?> de
						<?php echo ( $user['month_birthday'] )? $months[ $user['month_birthday'] ] : '';?>
					</div>
	    		</div>
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Entry Date'); ?></label>
						<?php echo ($user['entrydate']) ? $user['entrydate']->format('d/m/Y') : '';?>
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-md-6">
	    			
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Despartments'); ?></label>
						<?php echo ( $user['department_id'] )? $departamentos[ $user['department_id'] ] : '';?>
					</div>
	    		</div>
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Position'); ?></label>
						<?php echo h($user['position']);?>
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-md-6">
	    			<div class="um-form-row form-group">
						<label class="control-label"><?php echo __('Perfil'); ?></label>
						<?php echo h($user['user_group_name']);?>
					</div>
	    		</div>
	    		<div class="col-md-6">
	    			
	    		</div>
	    	</div>

    	</div>
	</div>
</div>