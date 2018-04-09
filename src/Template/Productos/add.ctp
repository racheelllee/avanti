<?php 
$this->Html->addCrumb(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Agregar Producto'); ?>
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

</script>
