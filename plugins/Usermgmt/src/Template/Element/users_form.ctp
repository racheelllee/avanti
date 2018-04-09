<div class="ca-form">
  <div class="row">
    <div class="col-md-6">
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __('First Name'); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.first_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __("Mother's Last Name"); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.clast_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Mobile Phone'); ?></label>
        <div class="col-md-10">
            <?= $this->Form->input('Users.phone', ['label'=>false, 'div'=>false, 'class'=>'form-control phone']); ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Franquicia'); ?></label>
        <div class="col-md-10">
          <?=
            $this->Form->input('Users.franquicia_id', [
              'type'    => 'select',
              'label'   => false,
              'div'     => false,
              'class'   => 'form-control',
              'options' => $franquicias
            ]);
          ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Día / mes de nacimiento'); ?></label>
          <div class="col-md-2" style="padding-right: 5px;">
          <?= $this->Form->input('Users.day_birthday', [
            'div' => false,
            'label' => false,
            'options' => $days,
            'class' => ['form-control']
          ]); ?>
          </div>
          <div class="col-sm-8" style="padding-left: 0px;">
            <?= $this->Form->input('Users.month_birthday', [
            'div' => false,
            'label' => false,
            'options' => $months,
            'class' => ['form-control']
          ]); ?>
          </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __('Perfil'); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.user_group_id', ['type'=>'select', 'label'=>false, 'div'=>false, 'multiple'=>true, 'class'=>'form-control', 'data-placeholder'=>'Seleccionar perfil']); ?>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __("Father's Last Name"); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.last_name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __('Email'); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Despartments'); ?></label>
        <div class="col-md-10">
          <?=
            $this->Form->input('Users.department_id', [
              'type'    => 'select',
              'label'   => false,
              'div'     => false,
              'class'   => 'form-control',
              'options' => $departamentos
            ]);
          ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Gender'); ?></label>
        <div class="col-md-10">
            <?= $this->Form->input('Users.gender',[
                'type'   =>  'radio',
                'class' => 'form-control',
                'label' => false,
                'hidden' =>  false,
                'options'   =>  $genders
            ]);?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-sm-2 control-label"><?= __('Position'); ?></label>
        <div class="col-sm-10">
          <?= $this->Form->input('Users.position', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
        </div>
      </div>
      <div class="um-form-row form-group">
        <label class="col-md-2 control-label"><?= __('Entry Date'); ?></label>
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
</div>
