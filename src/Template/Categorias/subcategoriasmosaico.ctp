<?php
$this->extend('/Categorias/subcategoria');

$this->start('selector_vista');
$actual_link = "$_SERVER[REQUEST_URI]";
  //debug($actual_link);
$link_no_query = strtok($actual_link, "?"); 
  //$query = parse_url($actual_link, PHP_URL_QUERY);
  //$query_params = array('marca' => 'Alcatel');
$query_params = $_GET;
$scriptsproductos="";
$uri = $_SERVER['REQUEST_URI'];

?>

<div class="row options-section">
    <div class="col-md-12" style="padding: 0px; margin-top: -6px; border-bottom: 2px solid #000;">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="btn-group">
                <a id="grid" class="btn">
                    <i class="fa fa-th-large" aria-hidden="true"></i>
                </a>
                <label class="form-label">Cuadricula</label>
            </div>
            <div class="btn-group">
                <a id="list" class="btn" href="/sclista<?php $uri = substr($uri, 3); echo ($uri);?>">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </a>
                <label class="form-label">Lista</label>
            </div>
        </div>


        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <form class="form-inline pull-right order-by">
                <div class="form-group">
                    <label for="ordenar">Ordenar por:</label>
                    <select id="sort">
                        <option value="precio_real ASC">Menor Precio</option>
                        <option value="precio_real DESC">Mayor Precio</option>
                        <option value="nombre ASC">Nombre</option>
                    </select>           
                </div>
                <!-- <div class="form-group">
                    <label for="ordenar">Página de <span class="numP-left">1</span> de <span class="numP-right">2</span></label>          
                </div> -->
            </form>
        </div>
        
    </div>
</div>

<?php $this->end(); ?>



<?php
$this->start('lista');



?>





<div id="posts-list">
  <div class="box-ofertas">
            <?php foreach ($productos as $producto):
                

                echo $this->element('producto', ['detalle_producto'=>$producto, 'column_class'=>'col-md-4', 'is_whislist'=>true, 'heightImg' => '185px']);

                

            endforeach; ?>
            <?= $this->Paginator->next(''); ?>
  </div>
</div>
          

<script type="text/javascript">

  <?php echo $scriptsproductos  ?>
</script>

<?php $this->end(); ?>