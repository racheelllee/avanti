<?php
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Filtro'), ['action' => 'edit', $filtro->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Filtro'), ['action' => 'delete', $filtro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filtro->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Filtros'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Filtro'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opcionesfiltros'), ['controller' => 'Opcionesfiltros', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcionesfiltro'), ['controller' => 'Opcionesfiltros', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($filtro->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($filtro->nombre) ?></p>
                                                    <h6><?= __('Categoria') ?></h6>
                    <p><?= $filtro->has('categoria') ? $this->Html->link($filtro->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $filtro->categoria->id]) : '' ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($filtro->id) ?></p>
                </div>
            </div>
<ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#Opcionesfiltros" id="Opcionesfiltros-tab" role="tab" data-toggle="tab" aria-controls="Opcionesfiltros" aria-expanded="true">Opcionesfiltros</a>
      </li>
         
</ul>

<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="Opcionesfiltros" aria-labelledBy="Opcionesfiltros-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($filtro->opcionesfiltros)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Id') ?></th>
                                            <th><?= __('Filtro Id') ?></th>
                                            <th><?= __('Nombre') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtro->opcionesfiltros as $opcionesfiltros): ?>
                    <tr>
                                            <td><?= h($opcionesfiltros->id) ?></td>
                                            <td><?= h($opcionesfiltros->filtro_id) ?></td>
                                            <td><?= h($opcionesfiltros->nombre) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Opcionesfiltros', 'action' => 'view', $opcionesfiltros->id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'Opcionesfiltros', 'action' => 'edit', $opcionesfiltros->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'Opcionesfiltros', 'action' => 'delete', $opcionesfiltros->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcionesfiltros->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen Opcionesfiltros asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
</div>

