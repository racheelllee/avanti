<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Complementos Producto'), ['action' => 'edit', $complementosProducto->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Complementos Producto'), ['action' => 'delete', $complementosProducto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complementosProducto->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Complementos Productos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Complementos Producto'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="complementosProductos view large-10 medium-9 columns">
    <h2><?= h($complementosProducto->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Producto') ?></h6>
            <p><?= $complementosProducto->has('producto') ? $this->Html->link($complementosProducto->producto->nombre, ['controller' => 'Productos', 'action' => 'view', $complementosProducto->producto->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($complementosProducto->id) ?></p>
            <h6 class="subheader"><?= __('Complemento Id') ?></h6>
            <p><?= $this->Number->format($complementosProducto->complemento_id) ?></p>
        </div>
    </div>
</div>
