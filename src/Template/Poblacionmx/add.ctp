<?php
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?= $this->Html->link(__('Listar Poblacionmx'), ['action' => 'index']) ?></li>
    </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($poblacionmx); ?>
    <fieldset>
        <legend><?= __('Add {0}', ['Poblacionmx']) ?></legend>
        
        <?php
                echo $this->Form->input('year');
                        echo $this->Form->input('estado');
                        echo $this->Form->input('poblacion');
                        echo $this->Form->input('hombres');
                        echo $this->Form->input('mujeres');
                        echo $this->Form->input('nacimientos');
                        echo $this->Form->input('defunciones');
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>