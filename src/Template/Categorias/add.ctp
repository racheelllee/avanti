<?php 
$this->Html->addCrumb(__('Agregar Categoría'), ['controller' => 'Categorias', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Agregar Categoría'); ?>
    </span>
    <span class="panel-title-right">
      
    </span>
  </div>
  <div class="panel-body">
    <?= $this->Form->create($categoria, ['type' => 'file']); ?>
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
            <label class="col-sm-2 control-label"><?php echo __('Categoría'); ?></label>
            <div class="col-sm-10">
              <?= $this->Form->input('parent_id', array('options'=>$categorias, 'label'=>'Categoria Padre', 'empty'=>'Categoria Padre', 'label'=>false, 'class'=>'select-simple form-control')) ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('URL'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('url', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
            </div>
          </div>
        </div>
        
        <div class="col-md-12" style="padding:0px;">
          <div class="col-md-6">
            <div class="um-form-row form-group">
              <label class="col-sm-2 control-label"><?php echo __('Imagen Ménu'); ?></label>
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
                            <input type="file" name="imagen_fondo"> </span>
                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Eliminar </a>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="um-form-row form-group">
              <label class="col-sm-2 control-label"><?php echo __('Banner'); ?></label>
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
                            <input type="file" name="banner"> </span>
                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Eliminar </a>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Producto Select -->
          <div class="col-md-12">
            <div class="um-form-row form-group">
              <label class="col-sm-2 control-label"><?php echo __('Producto destacado'); ?></label>
              <div class="col-sm-10">
                <?= $this->Form->input('producto_id', array('options'=>$productos, 'label'=>'Producto Destacado', 'empty'=>'Producto Destacado', 'label'=>false, 'class'=>'select-simple form-control')) ?>
              </div>
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


<script>

      var slug = function(str) {
      str = str.replace(/^\s+|\s+$/g, ''); // trim
      str = str.toLowerCase();
      
      // remove accents, swap ñ for n, etc
      var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
      var to   = "aaaaeeeeiiiioooouuuunc------";
      for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
      }
  
      str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

        return str;
      }
  
      
      $('#nombre').keyup(function () {

        var url = slug($('#nombre').val());

        $('#url').val(url);
      });





        

        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
</script>




