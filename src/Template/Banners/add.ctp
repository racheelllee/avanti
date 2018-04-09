<?php 
$this->Html->addCrumb(__('Agregar Banners'), ['controller' => 'Categorias', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Agregar Banners'); ?>
    </span>
    <span class="panel-title-right">
      
    </span>
  </div>
  <div class="panel-body">
    <?= $this->Form->create($banner, ['type' => 'file']); ?>
      <div class="ca-form">
        <div class="row">
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Nombre'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('nombre', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Posición'); ?></label>
            <div class="col-sm-10">
              <?= $this->Form->input('principal', array('options'=>$tipos, 'label'=>'Tipo', 'label'=>false, 'class'=>'select-simple form-control')) ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('URL'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('url', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'value'=>'#']); ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Imagen'); ?></label>
            <div class="col-sm-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="input-group input-large">
                      <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                          <i class="fa fa-picture-o fileinput-exists"></i>&nbsp;
                          <span class="fileinput-filename"> </span>
                      </div>
                      <span class="input-group-addon btn default btn-file" style="font-size: 10px;">
                          <span class="fileinput-new"> Selecciona una Imagen </span>
                          <span class="fileinput-exists"> Cambiar </span>
                          <input type="file" name="imagen"> </span>
                      <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Eliminar </a>
                  </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Vigencia Inicio'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('vigencia_inicio', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker']); ?>
            </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Vigencia Fin'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('vigencia_fin', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker']); ?>
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

