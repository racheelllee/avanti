<?php 
  use Cake\I18n\Time;
?>
<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>"addUsersForm$user->id", 'submitButtonId'=>"addUserSubmitBtn$user->id"]); ?>
<?php echo $this->Form->create($user, ['id'=>"addUsersForm$user->id", 'url' =>['action' => "editUser"], 'class'=>'form-horizontal']); ?>
        
        <div class="row">
          <!-- BEGIN FORM-->
                <div class="col-md-12" style="padding: 20px;">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo __('First Name'); ?></label>
                        <div class="col-md-6">
                            <?= $this->Form->input('Users.first_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo __("Father's Last Name"); ?></label>
                        <div class="col-md-6">
                            <?= $this->Form->input('Users.last_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo __("Mother's Last Name"); ?></label>
                        <div class="col-md-6">
                            <?= $this->Form->input('Users.clast_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo __('Email'); ?></label>
                        <div class="col-md-6">
                            <div class="input-group relative-absolute">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <?= $this->Form->input('Users.email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo __('User Profile'); ?></label>
                        <div class="col-md-6">
                            <?= $this->Form->input('Users.user_group_id', ['type'=>'select', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'options' => $userGroups]); ?>

                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label"><?php echo __('Birth Date'); ?></label>
                        <div class="col-md-6">
                          <div class="input-group relative-absolute">
                            <?= $this->Form->input('Users.bday', ['type' => 'text','label'=>false,'div'=>false, 'class'=>'form-control maxToDay','value' => (!empty( $user->bday ))? $user->bday->format('d/m/Y'):""]); ?>
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                          </div>
                            
                        </div>
                    </div>
                    
                      <div class="form-group">
                          <label class="col-md-4 control-label"><?php echo __('Gender'); ?></label>
                          <div class="col-md-6">

                                <?= $this->Form->input('Users.gender',[
                                    'type'   =>  'radio',
                                    'class' => 'form-control',
                                    'label' => false,
                                    'hidden' =>  false,
                                    'options'   =>  $options
                                ]);?>
                          </div>
                      </div>
                    
                    
                </div>
           
            <!-- END FORM-->
        </div>
        <div class="modal-footer">
          <div class="col-md-6">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
          <div class="col-md-4">
            
             <?php echo $this->Form->Submit(__('Update User'), ['div'=>false, 'class'=>'btn btn-span btn-md w-btnAddUsers', 'id'=>"addUserSubmitBtn$user->id"]); ?>
          </div>
        </div>

         <?php echo $this->Form->end(); ?>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('.maxToDay').datepicker({
            format: 'dd/mm/yyyy',
            endDate: new Date()
        });
        FormInputMask.init();
    });

    var FormInputMask = function () {
    
                var handleInputMasks = function () {
                    
                    $(".phone").inputmask("99-9999-9999", {
                        placeholder: " ",
                        clearMaskOnLostFocus: true
                    }); 
                }
                return {
                    //main function to initiate the module
                    init: function () {
                        handleInputMasks();
                    }
                };

            }();
</script>