<?php 
$this->Html->addCrumb(__('Editar Sucursal'), ['controller' => 'Sucursal', 'action' => 'edit', 'plugin' => false, $sucursal->id]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Editar Sucursal'); ?>
    </span>
    <span class="panel-title-right">
      
    </span>
  </div>
  <div class="panel-body">
    <?= $this->Form->create($sucursal, ['type' => 'file']); ?>
      <div class="ca-form">
        <div class="row">

        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Nombre'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('name', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Horario'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('horario', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Teléfonos'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('telefono', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Dirección'); ?></label>
            <div class="col-sm-11">
              <?php echo $this->Form->input('direccion', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('URL'); ?></label>
            <div class="col-sm-11">
              <?php echo $this->Form->input('url', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('IFRAME'); ?></label>
            <div class="col-sm-11">
              <?php echo $this->Form->input('iframe', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>


      </div>
    </div>
    
    <div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Guardar'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
      
    </div>
    <?php echo $this->Form->end(); ?>






  </div>
</div>
