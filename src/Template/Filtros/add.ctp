<div class="page-padding ca-form">
  <div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12">


        <form accept-charset="utf-8" id="form_filtro" onsubmit="return false;">    

              <?= $this->Form->input('categoria_id', array('type'=>'hidden', 'value'=>$categoria_id));?>
              <div class="row" id="filtro">
                <div class="col-lg-4">
                   <?= $this->Form->input('nombre', array('label'=>false, 'class'=>'form-control', 'placeholder'=>'Nuevo Filtro')); ?> 
                </div>
                <div class="col-lg-2">
                    <input type="button" class="btn btn-submit agregar_filtro" value="Agregar"/>  
                </div>
              </div>

        </form>
    </div>
  </div>
</div>
          

          <?php foreach ($filtros as $filtro) { ?>
            <form accept-charset="utf-8" id="form_Filtro<?php echo $filtro->id;?>" onsubmit="return false;">   
            <div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-8">
                <hr>
                <div class="col-lg-4">
                  <?php    
                  echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$filtro->id));
                  echo $this->Form->input('categoria_id', array('type'=>'hidden', 'value'=>$categoria_id));
                  echo $this->Form->input('nombre', array('label'=>false, 'class'=>'form-control','value'=>$filtro->nombre, 'placeholder'=>'Nombre Filtro'));

                  ?>
                </div>
                <div class="col-lg-4">
                  <b> <?= $this->Html->link('<i class="fa fa-save"></i>','#filtro',['data-id'=>$filtro->id, 'title' => __('Editar Filtro'), 'escape' => false, 'class'=>'btn btn-submit editar_Filtro']) ?>
                  <?= $this->Html->link('<i class="fa fa-trash"></i>',['controller'=>'filtros','action'=>'delete',$filtro->id,$categoria_id],['data-id'=>$filtro->id, 'title' => __('Eliminar Filtro'), 'escape' => false, 'class'=>'btn btn-submit']) ?></b>
                </div>
              </div>
            </div>
            </form>





            <?php foreach ($filtro->opcionesfiltros as $opcion) { ?>
            <form  id="form_opcionFiltro<?php echo $opcion->id;?>" onsubmit="return false;">   
            <div class="row">
              <div class="col-lg-2"></div>
              <div class="col-lg-8">
                <hr>
                <div class="col-lg-4">
                  <?php
                  echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$opcion->id));

                  echo $this->Form->input('nombre', array('label'=>false, 'class'=>'form-control','value'=>$opcion->nombre, 'placeholder'=>'Nombre Opcion'));
                  ?>
                </div>
                <div class="col-lg-2">
                  <?php  echo $this->Form->input('orden', array('label'=>false, 'class'=>'form-control','value'=>$opcion->orden, 'placeholder'=>'Orden')); ?>
                </div>
                <div class="col-lg-4">
                  <?= $this->Html->link('<i class="fa fa-save"></i>','#filtro',['data-id'=>$opcion->id, 'title' => __('Editar Opcion Filtro'), 'escape' => false, 'class'=>'btn btn-submit editar_opcionFiltro']) ?>
                  <?= $this->Html->link('<i class="fa fa-trash"></i>','#filtro',['data-id'=>$opcion->id, 'title' => __('Eliminar Opcion Filtro'), 'escape' => false, 'class'=>'btn btn-submit eliminar_opcionFiltro']) ?>
                </div>
              </div>
            </div>
            </form>
            <?php } ?>

            <form accept-charset="utf-8" id="form_opcionFiltro<?php echo $filtro->id;?>" onsubmit="return false;">   
            <?php
            echo $this->Form->input('filtro_id', array('type'=>'hidden', 'value'=>$filtro->id));
            echo $this->Form->input('orden', array('type'=>'hidden', 'value'=>"0"));
            echo $this->Form->input('categoria_id', array('type'=>'hidden', 'value'=>$categoria_id)); // Redirect
            ?>
            <div class="row">
              <div class="col-lg-2"></div>
              <div class="col-lg-8">
                <hr>
                <div class="col-lg-4">
                  <?php
                  echo $this->Form->input('opcion', array('label'=>false, 'class'=>'form-control', 'placeholder'=>'Nueva Opcion "'.$filtro->nombre.'"'));
                  ?>
                </div>
                <div class="col-lg-4">
                  <?php 
                  echo $this->Html->link('<i class="fa fa-floppy-o"></i>','#filtro',['data-id'=>$filtro->id, 'title' => __('Guarda Opcion Filtro'), 'escape' => false, 'class'=>'btn btn-submit guarda_opcionFiltro']);
                  ?>
                </div>
              </div>
            </div>

            </form>
            
          <?php } ?>