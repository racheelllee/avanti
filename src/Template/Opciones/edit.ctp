<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?=
            $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $opcion->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $opcion->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('Listar Opciones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Listar Atributos'), ['controller' => 'Atributos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Atributo'), ['controller' => 'Atributos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($opcion); ?>
    <fieldset>
        <legend><?= __('Edit {0}', ['Opcion']) ?></legend>
        
        <?php
                echo $this->Form->input('atributo_id', ['options' => $atributos]);
                        echo $this->Form->input('nombre');
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>