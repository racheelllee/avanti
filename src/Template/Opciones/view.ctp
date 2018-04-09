<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Opcion'), ['action' => 'edit', $opcion->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Opcion'), ['action' => 'delete', $opcion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcion->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Opciones'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Opcion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Atributos'), ['controller' => 'Atributos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Atributo'), ['controller' => 'Atributos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($opcion->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Atributo') ?></h6>
                    <p><?= $opcion->has('atributo') ? $this->Html->link($opcion->atributo->nombre, ['controller' => 'Atributos', 'action' => 'view', $opcion->atributo->id]) : '' ?></p>
                                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($opcion->nombre) ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($opcion->id) ?></p>
                </div>
            </div>
<ul id="myTab" class="nav nav-tabs" role="tablist">
   
</ul>

<div id="myTabContent" class="tab-content">
</div>

