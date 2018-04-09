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

echo '<div class="'.$column_class.' space30"  style="min-height: 255px;">';
        echo '<a href="/p/'.$detalle_producto['url'].'">';
        echo '<div class="item">';
            echo '<div style="width: 100%; height:'.$heightImg.'; background: url('.( (isset($detalle_producto['imagenes'][0]['nombre']))? '/upload/productos/'.$detalle_producto['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
            echo '</div>';

            echo '<p class="text-center space10">'.$detalle_producto['nombre'].'</p>';  

            if($detalle_producto['ver_precio'] && $detalle_producto['ver_precio_promocion']){

                echo '<h6>Regular $'.number_format($detalle_producto['precio'],2).' </h6>';
                echo '<h6> <span>Contado $'.number_format($detalle_producto['precio_promocion'],2).' </span> </h6>';

            }elseif ($detalle_producto['ver_precio']){

                echo '<h6> <span>Contado $'.number_format($detalle_producto['precio'],2).' </span> </h6>';

            }elseif ($detalle_producto['ver_precio_promocion']){

                echo '<h6> <span>Contado $'.number_format($detalle_producto['precio_promocion'],2).' </span> </h6>';

            }else{
                echo '<h6> <span> Precio No Disponible </span> </h6>';
            }

        echo '</div>';
        echo '</a>';
echo '</div>';
?>