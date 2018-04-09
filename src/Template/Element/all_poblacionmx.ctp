<?php
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
        <li><?=
            $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $poblacionmx->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $poblacionmx->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('Listar Poblacionmx'), ['action' => 'index']) ?></li>
    </ul>
<?php $this->end(); ?>
<div class="page-padding">
    <?= $this->Form->create($poblacionmx); ?>
    <fieldset>
        <legend><?= __('All Element {0}', ['Poblacionmx']) ?></legend>
        
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