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





<div id="posts-list" >
  <?php

    $ids_carrito = [];
      if($this->request->session()->check('carrito')) { 
          $carrito = $this->request->session()->read('carrito');
          foreach ($carrito as $key => $producto) {
            $ids_carrito[] = $producto['id'];
          }
      }



    foreach ($productos as $producto):


            echo '<div class="row">';

                            echo '<div class="col-md-3"><div class="col-item">';
                                    echo '<div class="box-image">';
                                         echo $this->Html->image( ( (isset($producto['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ), ['width' => '100%', 'height' =>'200px' ]);

                                         echo '<div class="box-whislist">';


                                            if(!in_array($producto['id'], $ids_carrito)){
                                                echo '<button class="btn add_wishlist" data-id="'.$producto['id'].'"><i class="fa fa-heart-o" aria-hidden="true"></i></button>';
                                            }else{
                                                echo '<button class="btn"><i class="fa fa-heart" aria-hidden="true"></i></button>';
                                            }


                                            
                                            echo '<a href="/p/'.$producto['url'].'" class="btn"><i class="fa fa-search" aria-hidden="true"></i></a>';
                                         echo '</div>';

                                    echo '</div>';
                            echo '</div></div>';
                            echo '<div class="col-md-9"><div class="col-item">';
                                    echo '<div class="box-info">';
                                        echo '<div class="box-description">';
                                            echo '<span>'.$producto['nombre'].'</span>';

                                            if($producto['ver_precio'] && $producto['ver_precio_promocion']){

                                                echo '<p class="price-old">$'.number_format($producto['precio'],2).'</p>';
                                                echo '<p class="price-new">$'.number_format($producto['precio_promocion'],2).'</p>';

                                            }elseif ($producto['ver_precio']){

                                                echo '<p class="price-new">$'.number_format($producto['precio'],2).'</p>';

                                            }elseif ($producto['ver_precio_promocion']){

                                                echo '<p class="price-new">$'.number_format($producto['precio_promocion'],2).'</p>';

                                            }else{
                                                echo '<p class="price-new">Precio No Disponible</p>';
                                            }



                                        echo '</div>';

                                        if ($producto['ver_meses_sin_intereses']){
                                            echo '<div class="box-price">';
                                                echo '<span>$'.number_format($producto['precio_meses_sin_intereses'],2).'</span>';
                                                echo '<p>A '.$producto['meses_sin_intereses'].' MESES SIN INTERESES</p>';
                                            echo '</div>';
                                        }

                                    echo '</div>';
                            echo '</div></div>';

                    echo '</div>';


                echo '<hr>';


    endforeach; 
 ?>
                                 <?= $this->Paginator->next(''); ?>

                       </div>
                        

<?php $this->end(); ?>