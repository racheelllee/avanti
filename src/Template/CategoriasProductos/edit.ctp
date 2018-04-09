<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');

?>


<div class="page-padding">
  <div class="row">
    <div class="col-lg-8">



    <?= $this->Form->create($categoria, ['type' => 'file']); ?>
      <legend><?= __('Editar {0}', ['Categoria']) ?></legend>
            
                
      <div class="row">
        <div class="col-lg-6">
          <?= $this->Form->input('id', array('type'=>'hidden')) ?>
         
          <?= $this->Form->input('nombre') ?>
        </div>
        
        <div class="col-lg-6">
          <div class="col-lg-8">
            <?= $this->Form->input('url') ?>
          </div>
          <div class="col-lg-4">
            <br>
            <?= $this->Form->input('publicado') ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <?= $this->Form->input('categoria_id', array('options'=>$categorias, 'label'=>'Categoria')) ?>
        </div>

          <div class="col-lg-6">
            <div class="col-lg-10">  
              <?= $this->Form->input('nueva_imagen',array('type'=>'file', 'label'=>'Nueva Imagen')) ?>
            </div>
            <div class="col-lg-2">  
              <br>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="fa fa-eye"></i> </button>
            </div>
          </div>

      </div>
       <?php echo $this->Form->input('descripcion'); ?>

    <?= $this->Form->button(__('Guardar Cambios')); ?> 
    <?= $this->Form->end(); ?>


      <br><br>
        <ul id="myTab" class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active">
            <a href="#SEO" id="SEO-tab" role="tab" data-toggle="tab" aria-controls="SEO" aria-expanded="true">SEO</a>
          </li>
          <li role="presentation" class="">
            <a href="#Filtros" id="Filtros-tab" role="tab" data-toggle="tab" aria-controls="Filtros" aria-expanded="true">Filtros</a>
          </li>
          </li>
          <li role="presentation" class="">
            <a href="#Banners" id="Banners-tab" role="tab" data-toggle="tab" aria-controls="Banners" aria-expanded="true">Banners</a>
          </li>
        </ul>
    
      <div id="myTabContent" class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="SEO" aria-labelledBy="SEO-tab">
          <br><br>
          <?php
            echo $this->Form->create($categoria);
              echo $this->Form->input('id', array('type'=>'hidden'));
              echo $this->Form->input('meta_descripcion');
              echo $this->Form->input('meta_keywords');
              echo $this->Form->input('meta_titulo');
            echo $this->Form->button(__('Guardar Cambios de SEO'));
            echo $this->Form->end();
          ?>

        </div>
       
        <div role="tabpanel" class="tab-pane fade in" id="Filtros" aria-labelledBy="Filtros-tab">

          <?php
            echo $this->Form->create(null, ['url' => ['controller' => 'Filtros', 'action' => 'add']]);

              echo $this->Form->input('categoria_id', array('type'=>'hidden', 'value'=>$categoria->id));

          ?>
              <br><br>
              <div class="row">
                <div class="col-lg-4">
          <?php
                  echo $this->Form->input('nombre', array('label'=>'Filtro'));
          ?> 
                </div>
              
                <div class="col-lg-2"> <br>
          <?php  
              echo $this->Form->button(__('Agregar'));
          ?>
                </div>
              </div>
          <?php
            echo $this->Form->end();
          ?>
        
          <hr>

          <?php foreach ($filtros as $filtro) { ?>
            <div class="row">
                <div class="col-lg-4">
                  <b><?php echo $filtro->nombre; ?></b>
                </div>
                <div class="col-lg-4">
                  <b>Accion</b>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                  <hr>
                </div>
            </div>



            <?php foreach ($filtro->opcionesfiltros as $opcion) { ?>

              <div class="row">
                <div class="col-lg-4">
                  <b><?php echo $opcion->nombre; ?></b>
                </div>
                <div class="col-lg-4">
                
                  <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'Opcionesfiltros', 'action' => 'delete', $opcion->id], ['confirm' => __('Seguro que quiere borrar la opcion de filtro'), 'title' => __('Eliminar Opcion de Filtro'), "escape" => false]) ?>

                </div>
            </div>

            <?php } ?>

            <div class="row">
                <div class="col-lg-8">
                  <hr>
                </div>
            </div>

            <?php
              echo $this->Form->create(null, ['url' => ['controller' => 'Opcionesfiltros', 'action' => 'add']]);

                echo $this->Form->input('filtro_id', array('type'=>'hidden', 'value'=>$filtro->id));
                echo $this->Form->input('categoria_id', array('type'=>'hidden', 'value'=>$categoria->id)); // Redirect
            ?>
              <div class="row">
                  <div class="col-lg-4">
                    <?php
                        echo $this->Form->input('nombre', array('label'=>'Opcion '.$filtro->nombre));
                    ?>
                  </div>
                  <div class="col-lg-4">
                    <br>
                    <?php  
                        echo $this->Form->button(__('Agregar'));
                    ?>
                  </div>
              </div>
              <div class="row">
                <div class="col-lg-8">
                  <hr>
                </div>
              </div>
            <?php
              echo $this->Form->end();
            ?>
            
          <?php } ?>



        </div>
        <div role="tabpanel" class="tab-pane fade in " id="Banners" aria-labelledBy="Banners-tab">
        
        </div>


      </div>




    </div>
  </div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content animated bounceInRight">
         <div class="modal-body">
          <?php if($categoria->banner != ''){ ?>
            <img src="/img/<?php echo $categoria->banner; ?>" width="100%"/>
          <?php }else{ ?>
            <img src="/img/<?php echo $categoria->imagen_fondo; ?>" width="100%"/>
          <?php } ?>
          </div>
      </div>
   </div>
 </div>
                      

<script>/*
$('#img').click(function (e) {
    $('#myModal img').attr('src', $(this).attr('data-img-url'));
});*/
</script>
