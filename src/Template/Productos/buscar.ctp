<?php
$this->extend('/Productos/buscarPadre');


$actual_link = "$_SERVER[REQUEST_URI]";
  //debug($actual_link);
$link_no_query = strtok($actual_link, "?"); 
  //$query = parse_url($actual_link, PHP_URL_QUERY);
  //$query_params = array('marca' => 'Alcatel');
$query_params = $_GET;
$scriptsproductos="";
$uri = $_SERVER['REQUEST_URI'];

?>



<?php
$this->start('lista');



?>





<div id="posts-list">
            <?php 
              $i=0;
              foreach ($productos as $producto):
              
                  echo $this->element('producto', ['detalle_producto'=>$producto, 'column_class'=>'col-md-4', 'is_whislist'=>true]);
              
              
              endforeach; 
              ?>
            <?= $this->Paginator->next(''); ?>
          </div>

          


<?php $this->end(); ?>