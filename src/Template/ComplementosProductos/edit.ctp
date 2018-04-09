<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $complementosProducto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $complementosProducto->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Complementos Productos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="complementosProductos form large-10 medium-9 columns">
    <?= $this->Form->create($complementosProducto) ?>
    <fieldset>
        <legend><?= __('Edit Complementos Producto') ?></legend>
        <?php
            echo $this->Form->input('complemento_id');
            echo $this->Form->input('producto_id', ['options' => $productos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
