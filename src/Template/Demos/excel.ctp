<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Población MX');?>
		</span>

		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Descargar Pdf', true), ['action'=>'excel','_ext'=>'pdf'], ['class'=>'btn btn-default']);?>
		</span>

		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Descargar Excel', true), ['action'=>'excel','_ext'=>'xlsx'], ['class'=>'btn btn-default']);?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->element('poblacionmx');?>
	</div>
</div>