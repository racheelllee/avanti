<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
//$this->start('tb_sidebar');
?>

<div class="page-padding">
  <div class="row">
    <div class="col-lg-8 col-xs-12 col-sm-12">

      <br><br>

    <form method="post" accept-charset="utf-8" id="form_atributo" action="">    
      <div class="row">
        <div class="col-lg-6 col-xs-6 col-sm-6">
          <?= $this->Form->input('producto_id', array('type'=>'hidden', 'value'=>$producto_id)); ?>
          <?= $this->Form->input('nombre', ['label'=>false]); ?>

        </div>
        
        <div class="col-lg-6 col-xs-6 col-sm-6">
            <input type="button" class="btn agregar_atributo" value="Agregar"/>   

        </div>
      </div>
    </form>
    

    <legend></legend>
    </div>

  </div>
  <br><br>
  <div class="row" id="atributos">
    <div class="col-lg-8 col-xs-12 col-sm-12">

        
                
        <?php foreach ($atributos as $atributo) { ?>



          <form method="post" accept-charset="utf-8" id="form_atributo<?php echo $atributo->id;?>" action="">
            <div class="row">
                <div class="col-lg-4 col-xs-4 col-sm-4">

                  <b><?php    

                    echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$atributo->id));
                    echo $this->Form->input('nombre', array('label'=>'','value'=>$atributo->nombre));

                  ?></b>

                </div>
                <br>
                <div class="col-lg-4 col-xs-4 col-sm-4">

                  <?= $this->Html->link('<i class="fa fa-edit"></i>','#atributos',['data-id'=>$atributo->id, 'title' => __('Editar Atributo'), 'escape' => false, 'class'=>'btn btn-primary editar_atributo']) ?>
                    

                  <?= $this->Html->link('<i class="fa fa-trash"></i>','#atributos',['data-id'=>$atributo->id,'title' => __('Eliminar Atributo'), 'escape' => false, 'class'=>'btn btn-primary eliminar_atributo']) ?>


                </div>
            </div>
          </form>



            <div class="row">
                <div class="col-lg-8 col-xs-12 col-sm-12">
                  <hr>
                </div>
            </div>


            <?php foreach ($atributo->opciones as $opcion) { ?>

              <form method="post" accept-charset="utf-8" id="form_opcionAtributo<?php echo $opcion->id;?>" action="">

                <div class="row">
                    
                    <div class="col-lg-4">

                      <b> <?php
                         echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$opcion->id));
                         echo $this->Form->input('nombre', array('label'=>'','value'=>$opcion->nombre));
                      ?></b>
                    </div>

                    <div class="col-lg-1">
                      <?php  echo $this->Form->input('orden', array('label'=>'','value'=>$opcion->orden)); ?>
                    </div>

                    <br>
                    <div class="col-lg-4 col-xs-4 col-sm-4">

                      <?= $this->Html->link('<i class="fa fa-edit"></i>','#atributos',['data-id'=>$opcion->id, 'title' => __('Editar Opcion'), 'escape' => false, 'class'=>'btn btn-primary editar_opcion']) ?>

                      <?= $this->Html->link('<i class="fa fa-trash"></i>','#atributos',['data-id'=>$opcion->id, 'title' => __('Eliminar Opcion'), 'escape' => false, 'class'=>'btn btn-primary eliminar_opcion']) ?>


                    </div>
                </div>

              </form>
                
            <?php } ?>


            <form method="post" accept-charset="utf-8" id="form_opciones<?php echo $atributo->id;?>" action="">    
           
                <div class="row">
                    <br><br>
                    <div class="col-lg-4 col-xs-4 col-sm-4">
                        <?= $this->Form->input('producto_id', array('type'=>'hidden', 'value'=>$producto_id)); ?>
                        <?= $this->Form->input('atributo_id', array('type'=>'hidden', 'value'=>$atributo->id)); ?>
                        <?= $this->Form->input('nombre', ['label'=>'Opcion '.$atributo->nombre]); ?>
                    </div>
                    <div class="col-lg-4 col-xs-4 col-sm-4">
                        </br>
                        
                        <input type="button" class="btn btn-primary agregar_opcion" data-id="<?php echo $atributo->id;?>" value="Agregar"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-xs-12 col-sm-12">
                      <hr>
                    </div>
                </div>
            
            </form>

        <?php } ?>

  </div>



</div>


<script>
    
</script>

