<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Opcionesfiltro'), ['action' => 'edit', $opcionesfiltro->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Opcionesfiltro'), ['action' => 'delete', $opcionesfiltro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcionesfiltro->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Opcionesfiltros'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Opcionesfiltro'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Filtros'), ['controller' => 'Filtros', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Filtro'), ['controller' => 'Filtros', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opcionefiltros Productos'), ['controller' => 'OpcionefiltrosProductos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcionefiltros Producto'), ['controller' => 'OpcionefiltrosProductos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($opcionesfiltro->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Filtro') ?></h6>
                    <p><?= $opcionesfiltro->has('filtro') ? $this->Html->link($opcionesfiltro->filtro->nombre, ['controller' => 'Filtros', 'action' => 'view', $opcionesfiltro->filtro->id]) : '' ?></p>
                                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($opcionesfiltro->nombre) ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($opcionesfiltro->id) ?></p>
                </div>
            </div>
<ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#OpcionefiltrosProductos" id="OpcionefiltrosProductos-tab" role="tab" data-toggle="tab" aria-controls="OpcionefiltrosProductos" aria-expanded="true">OpcionefiltrosProductos</a>
      </li>
         
</ul>

<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="OpcionefiltrosProductos" aria-labelledBy="OpcionefiltrosProductos-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($opcionesfiltro->opcionefiltros_productos)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Opcionesfiltro Id') ?></th>
                                            <th><?= __('Producto Id') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opcionesfiltro->opcionefiltros_productos as $opcionefiltrosProductos): ?>
                    <tr>
                                            <td><?= h($opcionefiltrosProductos->opcionesfiltro_id) ?></td>
                                            <td><?= h($opcionefiltrosProductos->producto_id) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'OpcionefiltrosProductos', 'action' => 'view', $opcionefiltrosProductos->opcionesfiltro_id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'OpcionefiltrosProductos', 'action' => 'edit', $opcionefiltrosProductos->opcionesfiltro_id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'OpcionefiltrosProductos', 'action' => 'delete', $opcionefiltrosProductos->opcionesfiltro_id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcionefiltrosProductos->opcionesfiltro_id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen OpcionefiltrosProductos asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
</div>

