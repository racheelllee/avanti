<?php

$ids_carrito = [];
if($this->request->session()->check('carrito')) { 
    $carrito = $this->request->session()->read('carrito');
    foreach ($carrito as $key => $producto) {
      $ids_carrito[] = $producto['id'];
    }
}

if($detalle_producto->promocion_productos){
    unset($detalle_producto->promocion_productos[0]['id']);
    unset($detalle_producto->promocion_productos[0]['promocion_id']);
    unset($detalle_producto->promocion_productos[0]['producto_id']);
   
    foreach ($detalle_producto->promocion_productos[0]->toArray() as $key => $value) {
        $detalle_producto[$key] = $value;
    }
}

$heightImg = (isset($heightImg))? $heightImg : '250px';

echo '<div class="'.$column_class.' space30"  style="min-height: 335px;">';

        echo '<div class="item_box">';
            echo '<a href="/p/'.$detalle_producto['url'].'">';
                echo '<div style="width: 100%; height:'.$heightImg.'; background: url('.( (isset($detalle_producto['imagenes'][0]['nombre']))? '/upload/productos/'.$detalle_producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                echo '</div>';
            echo '</a>';

            echo '<div class="fa_icons">';
                if(isset($is_whislist) && $is_whislist){

                    if(!in_array($detalle_producto['id'], $ids_carrito)){
                        echo '<a href="#" class="add_wishlist" data-id="'.$detalle_producto['id'].'"> <i class="fa fa-heart-o"></i> </a>';
                    }else{
                        echo '<a href="#"> <i class="fa fa-heart"></i> </a>';
                    }
                }

                echo '<a href="/p/'.$detalle_producto['url'].'"> <i class="fa fa-search"></i> </a>';
            echo '</div>';
        echo '</div>';

        echo '<div>';
            echo '<a href="/p/'.$detalle_producto['url'].'">';
                echo '<div class="item_info item_info_q">';
                    echo '<h3 style="margin-top: 10px;"> '.$detalle_producto['nombre'].' </h3>';
                        
                    if($detalle_producto['ver_precio'] && $detalle_producto['ver_precio_promocion']){

                        echo '<h5> <del>Regular $'.number_format($detalle_producto['precio'],2).' </del> </h5>';
                        echo '<h2>Contado $'.number_format($detalle_producto['precio_promocion'],2).' </h2>';

                    }elseif ($detalle_producto['ver_precio']){

                        echo '<h2>Contado $'.number_format($detalle_producto['precio'],2).' </h2>';

                    }elseif ($detalle_producto['ver_precio_promocion']){

                        echo '<h2>Contado $'.number_format($detalle_producto['precio_promocion'],2).' </h2>';

                    }else{
                        echo '<p class="price-new"></p>';
                        echo '<h2> Precio No Disponible </h2>';
                    }

                    if ($detalle_producto['ver_meses_sin_intereses']){
                        echo '<div class="orange_bg_strip">';
                            echo '<p> A '.$detalle_producto['meses_sin_intereses'].' meses de $'.number_format($detalle_producto['precio_meses_sin_intereses'],2).'</p>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</a>';
        echo '</div>';


echo '</div>';
?>