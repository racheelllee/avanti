<div class="portlet light bordered " >   
  <div class="portlet-title">
    <div class="actions">

<?php 
$this->Html->addCrumb(__('Listado de Sucursales'), ['controller' => 'Sucursales', 'action' => 'index','plugin' => false]);
?>

<?php $this->assign('title', __('Listado de Sucursales')   );  ?>
<?php $this->assign('header_title', __('Listado de Sucursales')   );  ?>
        <?php if($this->UserAuth->HP('Sucursales', 'add', false)){ ?>
            <?= $this->Html->link(__('Add Page'), ['action' => 'add'],['class'=>'ca-add', 'escape'=>false] ); ?>
        <?php } ?>
    </div>
  </div>
  <div class="portlet-body">
    <?php echo $this->element('all_sucursales');?>
  </div>
</div>

