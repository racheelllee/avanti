<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
?>
<?= $this->Form->create($imagen, ['type' => 'file']); ?>
<div class="page-padding">
    <fieldset>
        <legend><?= __('Agregar {0}', ['Imagen']) ?></legend>
        
        <?php
                echo $this->Form->input('producto_id', ['type'=>'hidden','value' => $producto_id]);

                echo $this->Form->input('nombre',array('name' => 'imagenes[]', 'type'=>'file', 'label'=>'Imagen', 'multiple' => true));
                        ?>
    </fieldset></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
      
            <div class="col-md-8">
            <?= $this->Form->button(__('Guardar'),['class'=>'btn btn-primary']) ?>
            </div>
            <div class="ibox-tools col-md-4 pull-right">
                <a href="/imagenes/index/<?= $producto_id?>" class="btn btn-warning pull-right"><i class="fa fa-return"></i> Cancelar</a>
            </div>
        </div>
    </div>
</div>

    <?= $this->Form->end() ?>