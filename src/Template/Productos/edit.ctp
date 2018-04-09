<?php 
$this->Html->addCrumb(__('Editar Producto'), ['controller' => 'Productos', 'action' => 'edit','plugin' => false]);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Editar Producto'); ?>
		</span>
		<span class="panel-title-right">
			
		</span>
	</div>
	<div class="panel-body">
		<?= $this->Form->create($producto); ?>
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
						<label class="col-sm-2 control-label"><?php echo __('Descripción Corta'); ?></label>
						<div class="col-sm-10">
							<?php echo $this->Form->input('descripcion_corta', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label"><?php echo __('SKU'); ?></label>
						<div class="col-sm-10">
							<?php echo $this->Form->input('sku', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
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

				<div class="col-md-12">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label">Descripcion Larga</label>
						<div class="col-sm-11">
						<?php echo $this->Tinymce->textarea('descripcion_larga',['type'=>'textarea', 'label'=>false, 'div'=>false, 'style'=>'height:500px', 'class'=>'form-control tinymce'], ['language'=>'en'], 'umcode'); ?>
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
              <li role="presentation" class="active">
                <a href="#Precios" id="Precios-tab" role="tab" data-toggle="tab" aria-controls="Precios" aria-expanded="true">Precios</a>
              </li>
              <!-- <li role="presentation" class="">
                <a href="#Atributos" id="Atributos-tab" role="tab" data-toggle="tab" aria-controls="Atributos" aria-expanded="false">Atributos</a>
              </li> -->
              <li role="presentation" class="">
                <a href="#Imagenes" id="Imagenes-tab" role="tab" data-toggle="tab" aria-controls="Imagenes" aria-expanded="false">        Imagenes</a>
              </li>
              <li role="presentation" class="">
                <a href="#Categorias" id="Categorias-tab" role="tab" data-toggle="tab" aria-controls="Categorias" aria-expanded="   false    ">Categorias</a>
              </li>
              <li role="presentation" class="">
                <a href="#SEO" id="SEO-tab" role="tab" data-toggle="tab" aria-controls="SEO" aria-expanded="false">SEO</a>
              </li>
              <li role="presentation" class="">
                <a href="#Relacionados" id="Relacionados-tab" role="tab" data-toggle="tab" aria-controls="Relacionados" aria-   expanded="false">Complementos</a>
              </li>
              <li role="presentation" class="">
                <a href="#Promociones" id="Promociones-tab" role="tab" data-toggle="tab" aria-controls="Promociones" aria-   expanded="false">Historial de Promociones</a>
              </li>
            </ul>
        </div>
       

        <div id="myTabContent" class="tab-content" style="min-height: 700px">

			<div role="tabpanel" class="tab-pane fade in active" id="Precios" aria-labelledBy="Precios-tab">
				<div class="row ca-form">
					<div class="col-lg-8">
						<?= $this->Form->create($producto); ?>

							<div class="row">
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Precio Lista'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('precio', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Mostrar Precio Lista'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('ver_precio', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
							</div>
							
							<div class="row">
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Precio Promoción'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('precio_promocion', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
						
						
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Mostrar Precio Promoción'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('ver_precio_promocion', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
							</div>
							
							<div class="row">
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Precio MSI'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('precio_meses_sin_intereses', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
						
						
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Mostrar  MSI'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('ver_meses_sin_intereses', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
							</div>

							<div class="row">
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Cantidad MSI'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('meses_sin_intereses', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
						
						
							<div class="col-md-6">
								<div class="um-form-row form-group">
									
								</div>
							</div>
							</div>

							<div class="row">
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Porcentaje Descuento'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('porcentaje_descuento_promocion', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
						
						
							<div class="col-md-6">
								<div class="um-form-row form-group">
									<label class="col-sm-2 control-label"><?php echo __('Mostrar Porcentaje Descuento'); ?></label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('ver_porcentaje_descuento_promocion', ['label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
									</div>
								</div>
							</div>
							</div>

							<div class="col-md-12 split-btn">

					            <?php echo $this->Form->Submit(__('Guardar Precios'), ['div'=>false, 'class'=>'btn btn-submit', 'name'=>'edit_precio']); ?>
								
							</div>
						<?= $this->Form->end() ?>
					</div>
				</div>
			</div>

			<!-- <div role="tabpanel" class="tab-pane fade in " id="Atributos" aria-labelledBy="Atributos-tab"></div> -->

			<div role="tabpanel" class="tab-pane fade in " id="Imagenes" aria-labelledBy="Imagenes-tab">
				<iframe src="/imagenes/index/<?= $producto->id?>" width="100%" height="700" frameborder="0"></iframe>
			</div>

			<div role="tabpanel" class="tab-pane fade in " id="Categorias" aria-labelledBy="Categorias-tab"></div>

			<div role="tabpanel" class="tab-pane fade in " id="SEO" aria-labelledBy="SEO-tab">
				<div class="row ca-form">
					<div class="col-lg-8">
						<?= $this->Form->create($producto); ?>

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

			<div role="tabpanel" class="tab-pane fade in " id="Relacionados" aria-labelledBy="Relacionados-tab">

				<div class="row">
					<div class="col-lg-12" id="RelacionadosLista"></div>
				</div>

				<div class="row">
					<div class="col-lg-12" id="RelacionadosBusqueda"></div>
				</div>

			</div>

			<div role="tabpanel" class="tab-pane fade in " id="Promociones" aria-labelledBy="Promociones-tab">

				<div class="row">
					<div class="col-lg-12">
						<table class="table table-striped table-hover dataTables-example" >
		                        <thead>
		                            <tr>                       
		                                <th>Nombre</th>
		                                <th>Fecha Inicio</th>
		                                <th>Fecha Fin</th>
		                                <th>Estatus</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        	<?php foreach ($producto->promocion_productos as $promocion) { ?>
			                        	<tr>                       
			                                <td><?= $promocion->promocione->nombre ?></td>
							                <td><?= ( ($promocion->promocione->vigencia_inicio)? $promocion->promocione->vigencia_inicio->format('d/m/Y') : '' ) ?></td>
							                <td><?= ( ($promocion->promocione->vigencia_fin)? $promocion->promocione->vigencia_fin->format('d/m/Y') : '' ) ?></td>
			                                <td>
							                <?php if($promocion->promocione->status){ ?>
							                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
							                <?php }else{ ?>
							                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
							                <?php } ?>
							                </td>
			                            </tr>
			                        <?php } ?>
		                        </tbody>
		                </table>
		            </div>
		        </div>

			</div>

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

	    $('#descripcion-corta').keyup(function () {
	    
	      if(!$('#meta-descripcion').val()){

	        $('#meta-descripcion').val( $('#descripcion-corta').val());
	      } 
	    
	    });


	    $( "#RelacionadosLista" ).load('/complementos_productos/add/<?php echo $producto->id; ?>', function() {

	        $(document).on({click: function(e){  

	              var producto_relacionado_id = $(this).data('id');

	                  
	                    $.ajax({
	                        url: '/complementos_productos/delete',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:{ producto_relacionado_id: producto_relacionado_id },
	                    })
	                    .done(function(data) {
	                        $('#RelacionadosLista').load('/complementos_productos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.eliminar_producto_relacionado');

	    });

	    $( "#RelacionadosBusqueda" ).load('/complementos_productos/busqueda/', function() {
	        $(document).on({click: function(e){        
	          
	          var palabra = $( "#palabra-busqueda" ).val();
	          var categoria = $( "#categoria-busqueda" ).val();

	          if(palabra == ''){ palabra = null; }
	          if(categoria == ''){ categoria = null; }

	        
	          $('#RelacionadosBusqueda').load('/complementos_productos/busqueda/'+palabra+'/'+categoria);
	          
	        }}, '.buscar_productos'); 

	        $(document).on({click: function(e){ 

	            var producto_relacionados = new Array();
	            var i = 0;
	            $("input[class=check_producto_relacionado]:checked").each(function(){
	              
	                producto_relacionados.push($(this).val());  

	            });


	            $.ajax({
	                        url: '/complementos_productos/add/<?php echo $producto->id; ?>',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data: { producto_relacionados:producto_relacionados },
	                    })
	                    .done(function(data) {
	                        $('#RelacionadosLista').load('/complementos_productos/add/<?php echo $producto->id; ?>');
	                        $('#RelacionadosBusqueda').load('/complementos_productos/busqueda/');

	            });


	        }}, '.agregar_producto_relacionado');

	        $(document).on({change: function(e){ 

	            var check =  this.checked;

	            $('input[class=check_producto_relacionado]').prop('checked',check);

	        }}, '.checkAll');

	    });

  
	    $( "#Categorias" ).load('/categorias_productos/add/<?php echo $producto->id; ?>', function() {

	      $(document).on({click: function(e){        
	                    $.ajax({
	                        url: '/CategoriasProductos/add',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:$("#form_categoria").serialize(),
	                    })
	                    .done(function(data) {
	                        $('#Categorias').load('/categorias_productos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.agregar_categoria');

	      

	      $(document).on({click: function(e){  

	              var categoria_id = $(this).data('id');

	                  
	                    $.ajax({
	                        url: '/CategoriasProductos/delete',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:{ categoria_id: categoria_id },
	                    })
	                    .done(function(data) {
	                        $('#Categorias').load('/categorias_productos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.eliminar_categoria');

	    });


	    /*$( "#Atributos" ).load('/atributos/add/<?php echo $producto->id; ?>', function() {

	        $(document).on({click: function(e){        
	                    $.ajax({
	                        url: '/atributos/add',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:$("#form_atributo").serialize(),
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.agregar_atributo');


	        $(document).on({click: function(e){  

	              var atributo_id = $(this).data('id');

	                  
	                    $.ajax({
	                        url: '/atributos/delete',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:{ atributo_id: atributo_id },
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.eliminar_atributo');


	        $(document).on({click: function(e){      

	          var id = $(this).data('id');

	                    $.ajax({
	                        url: '/opciones/add',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:$("#form_opciones"+id).serialize(),
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.agregar_opcion');


	        $(document).on({click: function(e){  

	              var opcion_id = $(this).data('id');

	                  
	                    $.ajax({
	                        url: '/opciones/delete',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:{ opcion_id: opcion_id },
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });
	        }}, '.eliminar_opcion');


	        $(document).on({click: function(e){   

	            var id = $(this).data('id');

	                    $.ajax({
	                        url: '/atributos/edit',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:$("#form_atributo"+id).serialize(),
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });

	        }}, '.editar_atributo');

	        $(document).on({click: function(e){   

	            var id = $(this).data('id');

	                    $.ajax({
	                        url: '/opciones/edit',
	                        type: 'POST',
	                        dataType: 'html', 
	                        data:$("#form_opcionAtributo"+id).serialize(),
	                    })
	                    .done(function(data) {
	                        $('#Atributos').load('/atributos/add/<?php echo $producto->id; ?>');
	                    });

	        }}, '.editar_opcion');


	    });*/


    });

</script>
