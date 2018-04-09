<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
//$this->start('tb_sidebar');
?>

<div class="page-padding">
  <div class="row" id="producto_ralacionado">
    <div class="col-md-12 col-xs-12 col-lg-12">

      <br><br>

    
        <div class="row">
            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>SKU</b>
            </div>
            
            <div class="col-md-3 col-xs-3 col-lg-3">
                <b>Producto</b>
            </div>
    
            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>Vigencia Inicio</b>
            </div>

            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>Vigencia Fin</b>
            </div>

            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>Promoción</b>
            </div>

            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>Promoción Fondo</b>
            </div>

            <div class="col-md-1 col-xs-1 col-lg-1">
                <b>Promoción Color</b>
            </div>

        </div>

        <legend></legend> 

        <?= $this->Form->create(null, ['type' => 'file']); ?>

        <?php foreach ($productos_relacionados as $producto_ralacionado) { ?>
            
            <div class="row">
                <div class="col-md-1 col-xs-1 col-lg-1">
                    <?php echo $producto_ralacionado->producto->sku; ?>
                </div>
            
                <div class="col-md-3 col-xs-3 col-lg-3">
                    <b><?php echo $producto_ralacionado->producto->nombre; ?></b>
                </div>

                <div class="col-md-1 col-xs-1 col-lg-1" style="padding:0px; padding-left:2px;">
                    <?php echo $this->Form->input('productos.'.$producto_ralacionado->id.'.vigencia_inicio', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker2', 'value'=> ($producto_ralacionado->vigencia_inicio)? $producto_ralacionado->vigencia_inicio->format('d/m/Y') : '', 'style'=>'    margin-top: -10px;']); ?>
                </div>

                <div class="col-md-1 col-xs-1 col-lg-1" style="padding:0px; padding-left:2px;">
                    <?php echo $this->Form->input('productos.'.$producto_ralacionado->id.'.vigencia_fin', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control datepicker2', 'value'=> ($producto_ralacionado->vigencia_fin)? $producto_ralacionado->vigencia_fin->format('d/m/Y') : '', 'style'=>'    margin-top: -10px;']); ?>
                </div>

                <div class="col-md-1 col-xs-1 col-lg-1" style="padding:0px; padding-left:2px;">
                    <?php echo $this->Form->input('productos.'.$producto_ralacionado->id.'.nombre_promocion', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control', 'value'=> $producto_ralacionado->nombre_promocion, 'style'=>'    margin-top: -10px;']); ?>
                </div>

                <div class="col-md-1 col-xs-1 col-lg-1" style="padding:0px; padding-left:2px;">
                    <?php echo $this->Form->input('productos.'.$producto_ralacionado->id.'.nombre_promocion_background', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control minicolors2', 'value'=> $producto_ralacionado->nombre_promocion_background, 'style'=>'    margin-top: -10px;']); ?>
                </div>

                <div class="col-md-1 col-xs-1 col-lg-1" style="padding:0px; padding-left:2px;">
                    <?php echo $this->Form->input('productos.'.$producto_ralacionado->id.'.nombre_promocion_color', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control minicolors2', 'value'=> $producto_ralacionado->nombre_promocion_color, 'style'=>'    margin-top: -10px;']); ?>
                </div>
                 

                <div class="col-md-1 col-xs-1 col-lg-1">
                    <?= $this->Html->link('<i class="fa fa-trash"></i>','#producto_ralacionado',['data-id'=>$producto_ralacionado->id,'title' => __('Eliminar Producto Relacionado'), 'escape' => false, 'class'=>'btn btn-submit eliminar_producto_relacionado', 'style'=>'    margin-top: -10px;']) ?>
                </div>
            </div>

        <br>
        <?php } ?>
    
        <div class="col-md-12 split-btn">

                <?php echo $this->Form->Submit(__('Guardar'), ['div'=>false, 'class'=>'btn btn-submit']); ?>
          
        </div>
        <?php echo $this->Form->end(); ?>
    
    </div>

  </div>
  <br><br>
</div>

<script type="text/javascript">
  $('.minicolors2').minicolors();
  $(document).ready(function() {
      $('.datepicker2').datepicker({
        format: 'dd/mm/yyyy'
      });
  });
</script>