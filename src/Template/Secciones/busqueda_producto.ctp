<div class="page-padding">
  <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12">

      <br><br>
        <form method="post" accept-charset="utf-8" id="form_buscar_productos" action="">  
        <div class="row">
            <div class="col-lg-4 col-xs-4 col-md-4">
                <?php echo $this->Form->input('palabra_busqueda', ['label'=>'Palabra Clave', 'class'=>'form-control']); ?>
            </div>
            <div class="col-lg-2 col-xs-2 col-md-2">
                <?= $this->Form->input('categoria_busqueda', ['options'=>$categorias, 'empty'=>'Seleccina', 'label'=>'Categoria', 'class'=>'select-simple form-control']) ?>
            </div>
            
            <div class="col-lg-2 col-xs-2 col-md-2">
                <input type="button" class="btn btn-submit buscar_productos" value="Buscar" style="margin-top: 22px;" />  
            </div>
        </div>
        </form>

        <br>

        <div class="row">
            <div class="col-lg-1 col-xs-1 col-md-1">
                <?php echo $this->Form->checkbox('checkAll', ['hiddenField' => false, 'class'=>'checkAll']); ?>
            </div>
            <div class="col-lg-1 col-xs-1 col-md-1">
                <b>SKU</b>
            </div>
            <div class="col-lg-4 col-xs-4 col-md-4">
                <b>Producto</b>
            </div>
        </div>

        <legend></legend>

        <?php foreach ($busqueda_productos as $producto) { ?>
            <div class="row">
                <div class="col-lg-1 col-xs-1 col-md-1">
                    <?php echo $this->Form->checkbox('check'.$producto->id, ['hiddenField' => false, 'value'=>$producto->id, 'class'=>'check_producto_relacionado']); ?>
                </div>
                <div class="col-lg-1 col-xs-1 col-md-1">
                    <?php echo $producto->sku; ?>
                </div>
                <div class="col-lg-4 col-xs-4 col-md-4">
                    <?php echo $producto->nombre; ?>
                </div>
            </div>
            <br>
        <?php } ?>
       
            <?php if(!$masiva):?>
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-md-12" style="text-align:right;">
                    <br>
                    <input type="button" class="btn btn-submit agregar_producto_relacionado" value="Agregar Seleccion"/>  
                </div>
            </div>
        <?php endif; ?>
       

    </div>
  </div>
</div>


