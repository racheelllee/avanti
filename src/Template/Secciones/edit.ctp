<?php 
$this->Html->addCrumb(__('Editar Sección'), ['controller' => 'Categorias', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Editar Sección'); ?>
    </span>
    <span class="panel-title-right">
      
    </span>
  </div>
  <div class="panel-body">
    <?= $this->Form->create($seccion, ['type' => 'file']); ?>
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
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              &nbsp;<br>&nbsp;
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Color Fondo'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('nombre_background', ['label'=>false, 'div'=>false, 'class'=>'form-control minicolors']); ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?php echo __('Color Letra'); ?></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('nombre_color', ['label'=>false, 'div'=>false, 'class'=>'form-control minicolors']); ?>
            </div>
          </div>
        </div>

      </div>
    </div>
    
    <div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Guardar'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
      
    </div>
    <?php echo $this->Form->end(); ?>





          <div class="col-lg-12">
            <br><br>
        
            <ul id="myTab" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="">
                <a href="#Relacionados" id="Relacionados-tab" role="tab" data-toggle="tab" aria-controls="Relacionados" aria-expanded="false">Productos</a>
              </li>
            </ul>
          </div>
       
          <div class="col-lg-12">
            <div id="myTabContent" class="tab-content" style="min-height: 700px">

              <div role="tabpanel" class="tab-pane fade in active" id="Relacionados" aria-labelledBy="Relacionados-tab">

                <div class="row">
                  <div class="col-lg-12" id="RelacionadosLista"></div>
                </div>

                <div class="row">
                  <div class="col-lg-12" id="RelacionadosBusqueda"></div>
                </div>

              </div>

            </div>
          </div>


  </div>
</div>

<script type="text/javascript">
  $('.minicolors').minicolors();

  $(document).ready(function() {

      $( "#RelacionadosLista" ).load('/secciones/listProducto/<?php echo $seccion->id; ?>', function() {

          $(document).on({click: function(e){  

                var producto_relacionado_id = $(this).data('id');

                    
                      $.ajax({
                          url: '/secciones/deleteProducto',
                          type: 'POST',
                          dataType: 'html', 
                          data:{ producto_relacionado_id: producto_relacionado_id },
                      })
                      .done(function(data) {
                          $('#RelacionadosLista').load('/secciones/listProducto/<?php echo $seccion->id; ?>');
                      });
          }}, '.eliminar_producto_relacionado');

      });

      $( "#RelacionadosBusqueda" ).load('/secciones/busquedaProducto/', function() {
          $(document).on({click: function(e){        
            
            var palabra = $( "#palabra-busqueda" ).val();
            var categoria = $( "#categoria-busqueda" ).val();

            if(palabra == ''){ palabra = null; }
            if(categoria == ''){ categoria = null; }

          
            $('#RelacionadosBusqueda').load('/secciones/busquedaProducto/'+palabra+'/'+categoria);
            
          }}, '.buscar_productos'); 

          $(document).on({click: function(e){ 

              var producto_relacionados = new Array();
              var i = 0;
              $("input[class=check_producto_relacionado]:checked").each(function(){
                
                  producto_relacionados.push($(this).val());  

              });


              $.ajax({
                          url: '/secciones/listProducto/<?php echo $seccion->id; ?>',
                          type: 'POST',
                          dataType: 'html', 
                          data: { producto_relacionados:producto_relacionados },
                      })
                      .done(function(data) {
                          $('#RelacionadosLista').load('/secciones/listProducto/<?php echo $seccion->id; ?>');
                          $('#RelacionadosBusqueda').load('/secciones/busquedaProducto/');

              });


          }}, '.agregar_producto_relacionado');

          $(document).on({change: function(e){ 

              var check =  this.checked;

              $('input[class=check_producto_relacionado]').prop('checked',check);

          }}, '.checkAll');

      });


    });
</script>