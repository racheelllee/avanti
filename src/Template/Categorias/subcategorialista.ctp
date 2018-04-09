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
                <a id="grid" class="btn" href="/sc<?php $uri = substr($uri, 8); echo ($uri);?>">
                    <i class="fa fa-th-large" aria-hidden="true"></i>
                </a>
                <label class="form-label">Cuadricula</label>
            </div>
            <div class="btn-group">
                <a id="list" class="btn">
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
            <?php 

            $ids_carrito = [];
            if($this->request->session()->check('carrito')) { 
                $carrito = $this->request->session()->read('carrito');
                foreach ($carrito as $key => $producto) {
                  $ids_carrito[] = $producto['id'];
                }
            }

            foreach ($productos as $producto):
                    if($producto->promocion_productos){
                        unset($producto->promocion_productos[0]['id']);
                        unset($producto->promocion_productos[0]['promocion_id']);
                        unset($producto->promocion_productos[0]['producto_id']);
                       
                        foreach ($producto->promocion_productos[0]->toArray() as $key => $value) {
                            $producto[$key] = $value;
                        }
                    }

                    echo '<div class="row">';

                            echo '<div class="col-md-4"><div class="col-item">';
                                    echo '<div class="box-image">';
                                          $this->Html->image( ( (isset($producto['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ), ['width' => '100%', 'height' =>'185px' ]);

                                           echo '<a href="/p/'.$producto['url'].'">';
                                           echo '<div style="width: 100%; height:185px; background: url('.( (isset($producto['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                                            echo '</div>';
                                            echo '</a>';

                                         echo '<div class="box-whislist">';

                                            echo '<div class="fa_icons">';

                                                if(!in_array($producto['id'], $ids_carrito)){
                                                    echo '<a href="#" class="add_wishlist" data-id="'.$producto['id'].'"> <i class="fa fa-heart-o"></i> </a>';
                                                }else{
                                                    echo '<a href="#"> <i class="fa fa-heart"></i> </a>';
                                                }


                                                
                                                echo '<a href="/p/'.$producto['url'].'"> <i class="fa fa-search"></i> </a>';
                                            echo '</div>';
                                         echo '</div>';

                                    echo '</div>';
                            echo '</div></div>';
                            echo '<div class="col-md-8"><div class="col-item">';
                                    
                                    echo '<a href="/p/'.$producto['url'].'">';
                                    echo '<div class="box-info">';
                                        echo '<div class="box-description item_info">';
                                            echo '<h3 style="margin-top: 10px;"> '.$producto['nombre'].' </h3>';
                    
                                            if($producto['ver_precio'] && $producto['ver_precio_promocion']){

                                                echo '<h5> <del>Regular $'.number_format($producto['precio'],2).' </del> </h5>';
                                                echo '<h2>Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

                                            }elseif ($producto['ver_precio']){

                                                echo '<h2>Contado $'.number_format($producto['precio'],2).' </h2>';

                                            }elseif ($producto['ver_precio_promocion']){

                                                echo '<h2>Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

                                            }else{
                                                echo '<p class="price-new"></p>';
                                                echo '<h2> Precio No Disponible </h2>';
                                            }


                                            if ($producto['ver_meses_sin_intereses']){
                                                echo '<div class="orange_bg_strip">';
                                                    echo '<p> A '.$producto['meses_sin_intereses'].' meses de $'.number_format($producto['precio_meses_sin_intereses'],2).'</p>';
                                                echo '</div>';
                                            }
                                        echo '</div>';

                                    echo '</div>';
                                    echo '</a>';

                            echo '</div></div>';

                    echo '</div>';


                echo '<hr>';

            endforeach; ?>
            <?= $this->Paginator->next(''); ?>
  </div>
</div>
                        
<script type="text/javascript">

  <?php echo $scriptsproductos  ?>
</script>
<?php $this->end(); ?>