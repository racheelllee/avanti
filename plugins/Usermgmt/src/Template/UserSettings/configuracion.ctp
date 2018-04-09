<?php 
$this->Html->addCrumb(__('Configuración'), ['controller' => 'UserSettings', 'action' => 'configuracion','plugin' => 'Usermgmt']);
?>

<div class="panel">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Configuración'); ?>
		</span>
		<span class="panel-title-right">
			
		</span>
	</div>
	<div class="panel-body">
		<?= $this->Form->create(null); ?>
	    <div class="ca-form">
	    	<div class="row">

	    		<?php foreach ($settings as $k => $setting) { ?>
					<div class="col-md-6">
						<div class="um-form-row form-group">
							<label class="col-sm-2 control-label"><?php echo $setting->display_name; ?></label>
							<div class="col-sm-10">
								<?php echo $this->Form->input($setting->name, ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'value'=>$setting->value]); ?>
							</div>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
		
		<div class="col-md-12 split-btn">

            <?php echo $this->Form->Submit(__('Guardar'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
			
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
