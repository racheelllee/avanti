<div class="portlet light bordered " >   
  <div class="portlet-title">
    <div class="actions">

<?php 
$this->Html->addCrumb(__('Listado de Secciones'), ['controller' => 'Secciones', 'action' => 'index','plugin' => false]);
?>

<?php $this->assign('title', __('Listado de Secciones')   );  ?>
<?php $this->assign('header_title', __('Listado de Secciones')   );  ?>
        <?php if($this->UserAuth->HP('Secciones', 'add', false)){ ?>
            <? $this->Html->link(__('Add Page'), ['action' => 'add'],['class'=>'ca-add', 'escape'=>false] ); ?>
        <?php } ?>
    </div>
  </div>
  <div class="portlet-body">
    <?php echo $this->element('all_secciones');?>
  </div>
</div>

<?= $this->element('modalURL'); ?>
