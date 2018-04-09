<?php $myUrl=$this->Url->build('/', true); ?>

<?php 
echo '<table>';
foreach ($carrito as $k => $producto):
  

        echo '<tr>';

                echo '<td>'; 
                        echo '<div class="box-image" style="width: 250px;">';
                              echo '<a style="text-decoration: none !important; color: #333 !important;" href="'.$myUrl.'/p/'.$producto['url'].'">';
                              echo '<div style="width: 100%; height:200px; background: url('.( (isset($producto['imagenes'][0]['nombre']))? $myUrl.'/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                                echo '</div>';
                              echo '</a>';
                             echo '<div class="box-whislist"></div>';

                        echo '</div>';
                echo '</td>';
                echo '<td style="min-width: 290px;">';
                        

                    echo '<div class="box-info" style="padding:20px;">';
                        echo '<a href="'.$myUrl.'/p/'.$producto['url'].'" style="text-decoration: none !important;">';
                        echo '<div class="box-description item_info">';
                            echo '<h3 style="margin-top: 10px; color: #000; font-weight: 400; margin-bottom: 0;"> '.$producto['nombre'].' </h3>';
    
                            if($producto['ver_precio'] && $producto['ver_precio_promocion']){

                                echo '<h5 style="color: #000; font-weight: 400; margin-bottom: 0; margin-top: 20px;"> <del>Regular $'.number_format($producto['precio'],2).' </del> </h5>';
                                echo '<h2>Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

                            }elseif ($producto['ver_precio']){

                                echo '<h2 style="color: #f61c45; font-weight: 400; font-size: 26px; margin-bottom: 0; margin-top: 5px;">Contado $'.number_format($producto['precio'],2).' </h2>';

                            }elseif ($producto['ver_precio_promocion']){

                                echo '<h2 style="color: #f61c45; font-weight: 400; font-size: 26px; margin-bottom: 0; margin-top: 5px;">Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

                            }else{
                                echo '<p class="price-new"></p>';
                                echo '<h2 style="color: #f61c45; font-weight: 400; font-size: 26px; margin-bottom: 0; margin-top: 5px;"> Precio No Disponible </h2>';
                            }


                            if ($producto['ver_meses_sin_intereses']){
                                echo '<div class="orange_bg_strip" style="background: url('.$myUrl.'/img/orange_bg_design.png)no-repeat; background-size: 100% 100%; color: #fff; margin-top: 10px;">';
                                    echo '<p stye="margin-bottom: 0; font-size: 14px; padding: 5px;"> A '.$producto['meses_sin_intereses'].' meses de $'.number_format($producto['precio_meses_sin_intereses'],2).'</p>';
                                echo '</div>';
                            }

                            

                        echo '</div>';
                        echo '</a>';
                      

                    echo '</div>';

                echo '</td>';

        echo '</tr>';

endforeach; 

echo '</table>';
?>
