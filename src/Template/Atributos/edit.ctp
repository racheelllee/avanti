<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?=
            $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $atributo->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $atributo->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('Listar Atributos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Listar Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opciones'), ['controller' => 'Opciones', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcion'), ['controller' => 'Opciones', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($atributo); ?>
    <fieldset>
        <legend><?= __('Edit {0}', ['Atributo']) ?></legend>
        
        <?php
                echo $this->Form->input('nombre');
                        echo $this->Form->input('producto_id', ['options' => $productos]);
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>