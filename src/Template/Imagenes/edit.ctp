<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?=
            $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $imagen->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $imagen->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('Listar Imagenes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Listar Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($imagen); ?>
    <fieldset>
        <legend><?= __('Edit {0}', ['Imagen']) ?></legend>
        
        <?php
                echo $this->Form->input('producto_id', ['options' => $productos]);
                        echo $this->Form->input('nombre');
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>