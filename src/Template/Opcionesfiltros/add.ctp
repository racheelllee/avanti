<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?= $this->Html->link(__('Listar Opcionesfiltros'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Listar Filtros'), ['controller' => 'Filtros', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Filtro'), ['controller' => 'Filtros', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opcionefiltros Productos'), ['controller' => 'OpcionefiltrosProductos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcionefiltros Producto'), ['controller' => 'OpcionefiltrosProductos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($opcionesfiltro); ?>
    <fieldset>
        <legend><?= __('Add {0}', ['Opcionesfiltro']) ?></legend>
        
        <?php
                echo $this->Form->input('filtro_id', ['options' => $filtros]);
                        echo $this->Form->input('nombre');
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>