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
$this->Html->addCrumb(__('Agregar Usuario'), ['controller' => 'Users', 'action' => 'addUser','plugin' => 'Usermgmt']);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Add User'); ?>
		</span>
		<span class="panel-title-right">
			<?php  $this->Html->link(__('Back', true), ['action'=>'index'], ['class'=>'ca-add ca-back']); ?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'addUserForm', 'submitButtonId'=>'addUserSubmitBtn']); ?>
		<?php echo $this->Form->create($userEntity, ['id'=>'addUserForm', 'class'=>'form-horizontal']); ?>
    <div class="ca-form">
    	<div class="row">
			<div class="col-md-6">
				<div class="um-form-row form-group">
					<label class="col-sm-2 control-label"><?php echo __('First Name'); ?></label>
					<div class="col-sm-10">
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
					<label class="col-sm-2 control-label"><?php echo __('Correo Electrónico'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->Form->input('Users.email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
					</div>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="um-form-row form-group">
                    <label class="col-md-2 control-label"><?php echo __('Mobile Phone'); ?></label>
                    <div class="col-md-10">
                        <?= $this->Form->input('Users.phone', ['label'=>false, 'div'=>false, 'class'=>'form-control phone']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
				<div class="um-form-row form-group">
                    <label class="col-md-2 control-label"><?php echo __('Selecciona un Genero'); ?></label>
                    <div class="col-md-10">
                        <?= $this->Form->input('Users.gender',[
                            'type'   =>  'radio',
                            'class' => 'form-control',
                            'label' => false,
                            'hidden' =>  false,
                            'options'   =>  $genders
                        ]);?>
                        <?= $this->Form->input('Users.mock',[
                            'type'   =>  'hidden',
                            'id'     =>  'users-gender',
                        ]);?>
                    </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
            <div class="col-md-6">
                <div class="um-form-row form-group">
                  <label class="col-md-2 control-label"><?php echo __('Día / Mes de Nacimiento'); ?></label>
                    <div class="col-md-4" style="padding-right: 5px;">
		                <?php echo $this->Form->input('Users.day_birthday', [
		                	'div' => false,
		                	'label' => false,
		                	'options' => $days,
		                	'class' => ['select-simple form-control']
		                ]); ?>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                    	<?php echo $this->Form->input('Users.month_birthday', [
		                	'div' => false,
		                	'label' => false,
		                	'options' => $months,
		                	'class' => ['select-simple form-control']
		                ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="um-form-row form-group">
                  <label class="col-md-2 control-label"><?php echo __('Entry Date'); ?></label>
                    <div class="col-md-10">
                      <div class="input-group relative-absolute">
                        <?= $this->Form->input('Users.entrydate', ['type' => 'text','label'=>false,'div'=>false, 'class'=>'form-control maxToDay', 'value' => !empty($userEntity->entrydate)?  $userEntity->entrydate->format('d/m/Y') : '' ]); ?>
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                      </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
           	<div class="col-md-6">
                <div class="um-form-row form-group">
                    <label class="col-md-2 control-label"><?php echo __('Despartments'); ?></label>
                    <div class="col-md-10">
                        <?= 
                          $this->Form->input('Users.department_id', [
                            'type'    => 'select',
                            'label'   => false,
                            'div'     => false,
                            'class'   => 'select-simple form-control',
                            'options' => $departamentos
                          ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
	            <div class="um-form-row form-group">
					<label class="col-sm-2 control-label"><?php echo __('Position'); ?></label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('Users.position', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-6">
                <div class="um-form-row form-group">
					<label class="col-sm-2 control-label"><?php echo __('Perfil'); ?></label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('Users.user_group_id', ['type'=>'select', 'label'=>false, 'div'=>false, 'multiple'=>true, 'class'=>'form-control', 'data-placeholder'=>'Select Group(s)']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
		
		<div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Add User'), ['div'=>false, 'class'=>'btn btn-submit', 'id'=>'addUserSubmitBtn']); ?>
			
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

<script type="text/javascript">

	$(function(){
		$('#users-user-group-id').select2();
	});

</script>
