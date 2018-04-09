<div class="portlet light bordered " >   
  <div class="portlet-title">
    <div class="actions">

<?php 
$this->Html->addCrumb(__('Listado de Categorías'), ['controller' => 'Categorias', 'action' => 'index','plugin' => false]);
?>

<?php $this->assign('title', __('Listado de Categorías')   );  ?>
<?php $this->assign('header_title', __('Listado de Categorías')   );  ?>
        <?php if($this->UserAuth->HP('Categorias', 'add', false)){ ?>
            <?= $this->Html->link(__('Add Page'), ['action' => 'add'],['class'=>'ca-add', 'escape'=>false] ); ?>
        <?php } ?>
    </div>
  </div>
  <div class="portlet-body">
    <?php echo $this->element('all_categorias');?>
  </div>
</div>