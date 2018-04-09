<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Banner'), ['action' => 'edit', $banner->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Banner'), ['action' => 'delete', $banner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $banner->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Banners'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Banner'), ['action' => 'add']) ?> </li>
    </ul>
<?php $this->end(); ?>

<h2><?= h($banner->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($banner->nombre) ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($banner->id) ?></p>
                </div>
            </div>
    <div class="row texts">
            <div class="col-lg-9">
                <h6><?= __('Contenido') ?></h6>
                <?= $this->Text->autoParagraph(h($banner->contenido)); ?>
            </div>
        </div>
    <ul id="myTab" class="nav nav-tabs" role="tablist">
   
</ul>

<div id="myTabContent" class="tab-content">
</div>

