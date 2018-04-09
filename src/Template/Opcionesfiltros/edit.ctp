<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>
<div class="page-padding">
    <?= $this->Form->create($opcionesfiltro); ?>
    <fieldset>
        <legend><?= __('Editar {0}', ['Opcionesfiltro']) ?></legend>
        
        <?php
                echo $this->Form->input('filtro_id', ['options' => $filtros]);
                        echo $this->Form->input('nombre');
                          echo $this->Form->input('orden');
                        ?>
    </fieldset>
    <?= $this->Form->button(__('Editar')) ?>
    <?= $this->Form->end() ?>
</div>