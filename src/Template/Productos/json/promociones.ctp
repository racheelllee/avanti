<?php 
//debug($producto);

//Declaro mi arreglo de salida.
$salida=array();
//Coloco el precio original, para tenerlo por si es necesario
$salida['producto']=array('precio_original'=>$producto->precio);
$salida['promociones']=array();
$hoy = new DateTime();
$validez='';
//Tomo el precio para usarlo en los cálculos.
$precio_final=$producto->precio;

foreach($producto->promociones as $promocion){
    //Dependiendo de la promo, calculo el ahorro

    $precio_sin_promo=$precio_final;
    
    
    $finicio = new DateTime($promocion->fecha_inicio->i18nFormat('YYYY-MM-dd HH:mm:ss'));
    $ffin = new DateTime($promocion->fecha_fin->i18nFormat('YYYY-MM-dd HH:mm:ss'));

    if($finicio <= $hoy && $ffin >= $hoy) {
        if($validez =='' || $validez >$ffin){$validez=$ffin;}
        //la promo está activa.
        if($promocion->monto >0){
            //la promo es de monto
            $precio_final -= $promocion->monto;
            $descuento = '- $'.number_format($promocion->monto,2);

        }elseif ($promocion->descuento >0) {
            //la promo es de % descuento
            $precio_final = $precio_final-($precio_final*($promocion->descuento/100));
            $descuento = $promocion->descuento.'%';
            
        }
        $salida['promociones'][]=array('precio'=>$precio_sin_promo,'descuento'=>$descuento);
    }
}

$f=floor($precio_final);
$c=$precio_final-$f;
if($c >= 0.5){
    $precio_final=$f+1;
}else{
    $precio_final=$f;
}

$salida['producto']['precio']=$precio_final;
$salida['producto']['ahorro']=round($producto->precio) - $precio_final;
if($validez != ''){
    $salida['validez']=$validez->format('d/m/Y');
}else{
    $salida['validez']=$validez;
}
die(json_encode($salida));
 ?>