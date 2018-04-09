<?php 
$this->Html->addCrumb(__('Agregar Promoción'), ['controller' => 'Promociones', 'action' => 'add','plugin' => false]);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Agregar Promoción'); ?>
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
		              <?php echo $this->Form->input('vigencia_inicio', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker']); ?>
		            </div>
		          </div>
		        </div>


		        <div class="col-md-6">
		          <div class="um-form-row form-group">
		            <label class="col-sm-2 control-label"><?php echo __('Fecha Fin'); ?></label>
		            <div class="col-sm-10">
		              <?php echo $this->Form->input('vigencia_fin', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker']); ?>
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
	</div>
</div>
