<?php 
$this->Html->addCrumb(__('Editar Promoción'), ['controller' => 'Promociones', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Editar Promoción'); ?>
		</span>
		<span class="panel-title-right">
			
		</span>
	</div>
	<div class="panel-body">
		<?= $this->Form->create($promocion); ?>
	    <div class="ca-form">
	    	<div class="row">
				<div class="col-md-12">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label"><?php echo __('Nombre'); ?></label>
						<div class="col-sm-10">
							<?php echo $this->Form->input('nombre', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
		          <div class="um-form-row form-group">
		            <label class="col-sm-2 control-label"><?php echo __('Fecha Inicio'); ?></label>
		            <div class="col-sm-10">
		              <?php echo $this->Form->input('vigencia_inicio', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker', 'value'=>($promocion->vigencia_inicio)? $promocion->vigencia_inicio->format('d/m/Y') : '']); ?>
		            </div>
		          </div>
		        </div>


		        <div class="col-md-6">
		          <div class="um-form-row form-group">
		            <label class="col-sm-2 control-label"><?php echo __('Fecha Fin'); ?></label>
		            <div class="col-sm-10">
		              <?php echo $this->Form->input('vigencia_fin', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker', 'value'=>($promocion->vigencia_fin)? $promocion->vigencia_fin->format('d/m/Y') : '']); ?>
		            </div>
		          </div>
		        </div>
				<div class="col-md-12">
					<div class="um-form-row form-group">
						<label class="col-sm-2 control-label"><?php echo __('URL'); ?></label>
						<div class="col-sm-10">
							<?php echo $this->Form->input('url', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
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
                <a href="#Productos" id="Productos-tab" role="tab" data-toggle="tab" aria-controls="Productos" aria-expanded="true">Productos</a>
              </li>
            </ul>
        </div>
       

        <div id="myTabContent" class="tab-content" style="min-height: 700px">

			<div role="tabpanel" class="tab-pane fade in active" id="Productos" aria-labelledBy="Productos-tab">
				<div class="row ca-form">
					<div class="row" style="margin:20px;">
						<div class="col-xs-6 w-title w-color666" style="margin-top:35px;">
	        
				          <span"><?php echo __('Listado de Productos');?></span>
				        
				        </div>
				      
				        <div class="col-xs-6">

				        	<a href="/promociones/productos/<?= $promocion->id ?>" class="btn btn-submit pull-right" style="height: 37px; margin-left:10px;">
					          Descargar Productos
					        </a>
					        
				            <?= $this->Form->create(null, ['id'=>'upload-excel', 'type' => 'file', 'url'=>'/promociones/edit/'.$promocion->id]); ?>

				                <span id="upload-file-spinner" style="display:none;" class="pull-right"><i class='fa fa-spinner fa-spin fa-5x fa-fw' style='font-size:15px;'></i></span>
				                <div class="fileinput fileinput-new pull-right" data-provides="fileinput">
				                    <span class="btn btn-submit btn-file pull-right">
				                        <span class="fileinput-new" style="font-size: 12px;"> <?= __('Cargar Productos') ?> </span>
				                        <span class="fileinput-exists" style="font-size: 12px;"> <?= __('Cargar Productos') ?> </span>
				                        <input name="upload-file" type="file" id="upload-file"> </span>
				                </div>

				            <?= $this->Form->end() ?>

				            <a href="/files/Layout_de_Productos_de_Promociones.xlsx" class="btn btn-default pull-right" style="height: 37px; margin-right:10px;" download="Layout_de_Productos_de_Promociones.xlsx">
					          Descargar Layout
					        </a>

				        </div>

				        <div class="col-lg-12" style="margin-top:20px;">
							<?php echo $this->element('promocion_productos', ['promocion_productos'=>$promocion->promocion_productos]);?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="vista-previa">
  <div class="modal-dialog modal-lg">
    <div class="modal-content row">
    	<div class="col-xs-12 w-title w-color666" style="margin-top:35px;">
	        
          	<span"><?php echo __('Vista Previa de Carga');?></span>
	        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>

        </div>
     	<?php echo $this->element('promocion_productos_cargados', ['productos'=>$promosArray]);?>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('[data-toggle="popover"]').popover();

        var promosArray = <?= json_encode($promosArray) ?>;

        if(promosArray.length > 0){
        	$('#vista-previa').modal('show');
        }
    });

	$('#upload-file').change(function(){
        var file = this.files[0];
        var name = file.name;
        var ext = name.split('.').pop().toLowerCase();
        
        if(ext == 'xlsx' || ext == 'xls'){
            $('#upload-file-spinner').css({'display': 'block'}); 
            $('#upload-excel').submit();
        }else{
            alert('Tipo de archivo no valido.');
        }
    });
</script>
