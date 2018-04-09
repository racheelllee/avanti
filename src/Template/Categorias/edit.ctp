<?php 
$this->Html->addCrumb(__('Editar Categoría'), ['controller' => 'Categorias', 'action' => 'edit','plugin' => false, $categoria->id]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Editar Categoría'); ?>
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
                <div class="col-xs-4">
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
          </div>

          <div class="col-md-6">
            <div class="um-form-row form-group">
              <label class="col-sm-2 control-label"><?php echo __('Banner'); ?></label>
              <div class="col-sm-10">
                <div class="col-xs-4">
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
          </div>
        </div>

        <div class="col-md-6">
          <div class="um-form-row form-group">
            <div class="col-sm-10">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#imagen"> <i class="fa fa-eye"></i> Ver Imagen </button>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <div class="col-sm-10">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#imagenBanner"> <i class="fa fa-eye"></i> Ver Imagen </button>
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
    
    <div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Guardar'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
      
    </div>
    <?php echo $this->Form->end(); ?>


    <div class="col-md-12">
      <ul id="myTab" class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active">
          <a href="#Producto" id="Producto-tab" role="tab" data-toggle="tab" aria-controls="Producto" aria-expanded="true">Productos</a>
        </li>
        
       
        <li role="presentation" class="">
          <a href="#Filtros" id="Filtros-tab" role="tab" data-toggle="tab" aria-controls="Filtros" aria-expanded="true">Filtros</a>
        </li>

        <li role="presentation" class="">
          <a href="#SEO" id="SEO-tab" role="tab" data-toggle="tab" aria-controls="SEO" aria-expanded="true">SEO</a>
        </li>
      </ul>

      <div id="myTabContent" class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="Producto" aria-labelledBy="Producto-tab" style="padding:20px;">

              <div class="row">
                  <div class="col-xs-1">
                      <b>SKU</b>
                  </div>
                  <div class="col-xs-4">
                      <b>Producto</b>
                  </div>
                  <div class="col-xs-2">
                      <b>Precio Lista</b>
                  </div>
                  <div class="col-xs-2">
                      <b>Precio Promoción</b>
                  </div>
                  <div class="col-xs-2">
                      <b>Precio MSI</b>
                  </div>
              </div>

              <legend></legend>

              <?php foreach ($categoria->productos as $producto) { ?>
                  <div class="row">
                      <div class="col-xs-1">
                          <?php echo $producto->sku; ?>
                      </div>
                      <div class="col-xs-4">
                          <?php echo $producto->nombre; ?>
                      </div>
                     
                      <div class="col-xs-2">
                          $<?php echo number_format($producto->precio,2); ?>
                      </div>
                      <div class="col-xs-2">
                          $<?php echo number_format($producto->precio_promocion,2); ?>
                      </div>
                      <div class="col-xs-2">
                          $<?php echo number_format($producto->precio_meses_sin_intereses,2); ?>
                      </div>
                  </div>
                  <br>
              <?php } ?>

      </div>

      <div role="tabpanel" class="tab-pane fade in" id="Filtros" aria-labelledBy="Filtros-tab"></div>

      <div role="tabpanel" class="tab-pane fade in" id="SEO" aria-labelledBy="SEO-tab">
        <div class="row ca-form">
          <div class="col-lg-8">
            <?= $this->Form->create($categoria); ?>

              <div class="row">
                <div class="col-md-12">
                  <div class="um-form-row form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Meta Titulo'); ?></label>
                    <div class="col-sm-10">
                      <?php echo $this->Form->input('meta_titulo', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="um-form-row form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Meta Descripción'); ?></label>
                    <div class="col-sm-10">
                      <?php echo $this->Form->input('meta_descripcion', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="um-form-row form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Meta Keywords'); ?></label>
                    <div class="col-sm-10">
                      <?php echo $this->Form->input('meta_keywords', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 split-btn">

                      <?php echo $this->Form->Submit(__('Guardar SEO'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
                
              </div>
            <?= $this->Form->end() ?>
          </div>
        </div>



      </div>
      
      
    </div>
  </div>
</div>

      


</div>


<div class="modal inmodal" id="imagen" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content animated">
         <img src="/<?php echo $categoria->imagen_fondo; ?>" width="50%" align="center"/>
      </div>
   </div>
 </div>

 <div class="modal inmodal" id="imagenBanner" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content animated">
         <img src="/<?php echo $categoria->banner; ?>" width="50%" align="center"/>
      </div>
   </div>
 </div>

<script type="text/javascript">

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

  $(document).ready(function() {
   
  
    $( "#Filtros" ).load('/filtros/add/<?php echo $categoria->id; ?>', function() {

        $(document).on({click: function(e){        
                    $.ajax({
                        url: '/filtros/add',
                        type: 'POST',
                        dataType: 'html', 
                        data:$("#form_filtro").serialize(),
                    })
                    .done(function(data) {
                        $('#Filtros').load('/filtros/add/<?php echo $categoria->id; ?>');
                    });
        }}, '.agregar_filtro');


        $(document).on({click: function(e){   

            var id = $(this).data('id');

                    $.ajax({
                        url: '/Opcionesfiltros/add',
                        type: 'POST',
                        dataType: 'html', 
                        data:$("#form_opcionFiltro"+id).serialize(),
                    })
                    .done(function(data) {
                        $('#Filtros').load('/filtros/add/<?php echo $categoria->id; ?>');
                    });
        }}, '.guarda_opcionFiltro');


    $(document).on({click: function(e){   

            var id = $(this).data('id');

                    $.ajax({
                        url: '/Opcionesfiltros/edit',
                        type: 'POST',
                        dataType: 'html', 
                        data:$("#form_opcionFiltro"+id).serialize(),
                    })
                    .done(function(data) {
                        $('#Filtros').load('/filtros/add/<?php echo $categoria->id; ?>');
                    });

        }}, '.editar_opcionFiltro');



    $(document).on({click: function(e){   

            var id = $(this).data('id');

                    $.ajax({
                        url: '/filtros/edit',
                        type: 'POST',
                        dataType: 'html', 
                        data:$("#form_Filtro"+id).serialize(),
                    })
                    .done(function(data) {
                        $('#Filtros').load('/filtros/add/<?php echo $categoria->id; ?>');
                    });

        }}, '.editar_Filtro');


        $(document).on({click: function(e){  

              var opcion_id = $(this).data('id');

                  
                    $.ajax({
                        url: '/Opcionesfiltros/delete',
                        type: 'POST',
                        dataType: 'html', 
                        data:{ opcion_id: opcion_id },
                    })
                    .done(function(data) {
                        $('#Filtros').load('/filtros/add/<?php echo $categoria->id; ?>');
                    });
        }}, '.eliminar_opcionFiltro');

    });

  });



/*
$('#img').click(function (e) {
    $('#myModal img').attr('src', $(this).attr('data-img-url'));
});*/
</script>
