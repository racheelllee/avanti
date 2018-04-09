<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Complementos Producto'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="complementosProductos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('complemento_id') ?></th>
            <th><?= $this->Paginator->sort('producto_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($complementosProductos as $complementosProducto): ?>
        <tr>
            <td><?= $this->Number->format($complementosProducto->id) ?></td>
            <td><?= $this->Number->format($complementosProducto->complemento_id) ?></td>
            <td>
                <?= $complementosProducto->has('producto') ? $this->Html->link($complementosProducto->producto->nombre, ['controller' => 'Productos', 'action' => 'view', $complementosProducto->producto->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $complementosProducto->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $complementosProducto->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $complementosProducto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complementosProducto->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
