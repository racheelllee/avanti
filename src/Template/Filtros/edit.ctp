<?php
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?=
            $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $filtro->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $filtro->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('Listar Filtros'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Listar Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Opcionesfiltros'), ['controller' => 'Opcionesfiltros', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Opcionesfiltro'), ['controller' => 'Opcionesfiltros', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($filtro); ?>
    <fieldset>
        <legend><?= __('Edit {0}', ['Filtro']) ?></legend>
        
        <?php
                echo $this->Form->input('nombre');
                        echo $this->Form->input('categoria_id', ['options' => $categorias]);
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>