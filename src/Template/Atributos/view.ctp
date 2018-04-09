<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Atributo'), ['action' => 'edit', $atributo->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Atributo'), ['action' => 'delete', $atributo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $atributo->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Atributos'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Atributo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opciones'), ['controller' => 'Opciones', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcion'), ['controller' => 'Opciones', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($atributo->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($atributo->nombre) ?></p>
                                                    <h6><?= __('Producto') ?></h6>
                    <p><?= $atributo->has('producto') ? $this->Html->link($atributo->producto->nombre, ['controller' => 'Productos', 'action' => 'view', $atributo->producto->id]) : '' ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($atributo->id) ?></p>
                </div>
            </div>
<ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#Opciones" id="Opciones-tab" role="tab" data-toggle="tab" aria-controls="Opciones" aria-expanded="true">Opciones</a>
      </li>
         
</ul>

<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="Opciones" aria-labelledBy="Opciones-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($atributo->opciones)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Id') ?></th>
                                            <th><?= __('Atributo Id') ?></th>
                                            <th><?= __('Nombre') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($atributo->opciones as $opciones): ?>
                    <tr>
                                            <td><?= h($opciones->id) ?></td>
                                            <td><?= h($opciones->atributo_id) ?></td>
                                            <td><?= h($opciones->nombre) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Opciones', 'action' => 'view', $opciones->id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'Opciones', 'action' => 'edit', $opciones->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'Opciones', 'action' => 'delete', $opciones->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opciones->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen Opciones asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
</div>

