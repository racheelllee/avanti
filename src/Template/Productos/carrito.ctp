<div class="container"> 
  <div class="row">
    <div class="col-md-12">
    <button class="btn pull-right" style="border-radius:0px;" data-toggle="modal" data-target="#myModal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar Wishlist</button> 
    </div>
  </div>
<div id="posts-list">
  <div class="box-ofertas">
            <?php 

            foreach ($carrito as $k => $producto):
              

                    echo '<div class="row">';

                            echo '<div class="col-md-3"><div class="col-item">';
                                    echo '<div class="box-image">';
                                          $this->Html->image( ( (isset($producto['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ), ['width' => '100%', 'height' =>'200px' ]);

                                          echo '<a href="/p/'.$producto['url'].'">';
                                          echo '<div style="width: 100%; height:200px; background: url('.( (isset($producto['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                                            echo '</div>';
                                          echo '</a>';

                                         echo '<div class="box-whislist">';

                                            echo '<div class="fa_icons">';

                                                echo '<a href="#"> <i class="fa fa-heart"></i> </a>';
                                                echo '<a href="/p/'.$producto['url'].'"> <i class="fa fa-search"></i> </a>';
                                            echo '</div>';

                                         echo '</div>';

                                    echo '</div>';
                            echo '</div></div>';
                            echo '<div class="col-md-9"><div class="col-item">';
                                    
                                    echo '<div class="box-info">';
                                        echo '<a href="/p/'.$producto['url'].'">';
                                        echo '<div class="col-md-8 box-description item_info">';
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
                                        echo '</a>';

                                        echo '<div class="col-md-3">';
                                               echo '<br><button href="#" class="purchase_btn" style="width: 200px;" data-posicion="'.$k.'">'; 
                                              echo __('QUITAR DEL WISHLIST');
                                            echo '</button>';
                                        echo '</div>';
                                      

                                    echo '</div>';

                            echo '</div></div>';

                    echo '</div>';


                echo '<hr>';

            endforeach; ?>
  </div>
</div>
</div>

<div class="modal fade" id="myModal">
  <div class="modal-dialog" style="z-index: 10000;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enviar Wishlist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="/pages/enviarWishlist">
      <div class="modal-body">
        
        <div class="row">
          <div class="col-md-12">
            <input type="email" name="email" placeholder="Correo Electronico" style="width: 100%;">
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-enviar-wishlist">Enviar</button>
      </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
   
   $(document).on({click: function(e){
       //e.preventDefault();
       var _this = $(this);
       var accion = 'eliminar_articulo';
       var posicion = _this.data('posicion');
       
   
       $.ajax({
   
           type: 'POST',
           url: '<?php echo $this->Url->build(["action" => "editar_carrito"]); ?>',
           data: {
               accion:accion,
               posicion:posicion
           },
           dataType: 'json',
           success: function(data){
               location.reload(true);
           }
       })
   
   }}, '.purchase_btn');
   
</script>