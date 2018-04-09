<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Imagen'), ['action' => 'edit', $imagen->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Imagen'), ['action' => 'delete', $imagen->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imagen->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Imagenes'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Imagen'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($imagen->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Producto') ?></h6>
                    <p><?= $imagen->has('producto') ? $this->Html->link($imagen->producto->nombre, ['controller' => 'Productos', 'action' => 'view', $imagen->producto->id]) : '' ?></p>
                                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($imagen->nombre) ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($imagen->id) ?></p>
                </div>
            </div>
<ul id="myTab" class="nav nav-tabs" role="tablist">
   
</ul>

<div id="myTabContent" class="tab-content">
</div>

