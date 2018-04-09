<?php if($banners){ ?>
<div class="container" style="margin-bottom: 50px;"> 

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
        <div class="carousel-inner">
        <?php 
        $cont = 0;
        foreach ($banners as $banner) {
            if($cont == 0){
                echo '<div class="item active">
                    <a target="'.((!empty($banner["url"]))? '_blank':'').'" href="'.((!empty($banner["url"]))? $banner["url"]:'#').'" ><img class="img-responsive" style="width: 100%;" src="/' . $banner['imagen'] . '"/></a>
                </div>';
                $cont = 1;
            }else{
                echo '<div class="item">
                <a target="'.((!empty($banner["url"]))? '_blank':'').'" href="'.((!empty($banner["url"]))? $banner["url"]:'#').'"><img class="img-responsive" style="width: 100%;" src="/' . $banner['imagen'] . '"/></a>
                </div>';
            }
        }
        $cont = 0;
        ?>
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="icon-next"></span>
        </a>
    
    </div>
</div>
<?php } ?>

<div class="container box-seccion5">
    <div class="col-md-12">
        <div class="box-title"><span>¡OFERTAS PARA TU HOGAR!</span></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4">
           <?php echo $this->element('carousel_banner', ['carousel_id'=>'banners1', 'banners'=>$banners1]); ?>
        </div>
        <div class="col-md-8">
           <?php echo $this->element('carousel_banner', ['carousel_id'=>'banners2', 'banners'=>$banners2]); ?>
        </div>
        <div class="col-md-8" style="margin-top: 35px;">
           <?php echo $this->element('carousel_banner', ['carousel_id'=>'banners3', 'banners'=>$banners3]); ?>
        </div>
    </div>
</div>

<!--  OFERTAS DE REMATE -->
<?php $seccion = $secciones[0]; if($seccion->status){ ?>
<div class="container box-ofertas">
    <div class="col-md-12">
        <div class="box-title" style="background:<?= $seccion->nombre_background ?>; color:<?= $seccion->nombre_color ?>;"><span><?= $seccion->nombre ?></span></div>
    </div>
    <div class="col-md-12">
       
        <?php echo $this->element('slider_producto', ['all_productos'=>$seccion->seccion_productos, 'column'=>4, 'column_class'=>'col-md-12', 'is_relacional'=>true, 'heightImg' => '185px', 'carousel_id'=>'seccion-0', 'is_light'=>true]); ?>

    </div>
</div>
<?php } ?>


<!-- CATEGORIA 5 Y 6 -->

<div class="container box-seccion5">

    <div class="col-md-12">
        <div class="box-title"><span>HOT SUMMER DEALS</span></div>
    </div>

    <div class="col-md-12">

        <?php $seccion = $secciones[1]; if($seccion->status){?>
        <div class="col-md-6" style="padding-left: 0px;">
            <div class="carousel slide" id="carousel-<?= $seccion->id ?>" style="padding-left: 5px;">
                <div class="carousel-inner">

                    <?php 
                    $seccion_productos = $seccion->seccion_productos; 
                    foreach ($seccion_productos as $key => $producto) {
                        
                        if($key == 0){
                            echo  '<div class="item active">';
                        }else{
                            echo  '<div class="item">';
                        } 

                            echo '<a href="/p/'.$producto['producto']['url'].'">';

                            echo '<div class="box-image">';
                                $this->Html->image( ( (isset($producto['producto']['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['producto']['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ), ['width' => '100%', 'height' =>'450px' ]);

                                echo '<div style="width: 100%; height:100%; background: url('.( (isset($producto['producto']['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['producto']['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                                echo '</div>';

                            echo '</div>';
                            echo '<div class="box-info-left" style="background-color: '.$producto['nombre_promocion_background'].'; color: '.$producto['nombre_promocion_color'].';">';
                                echo '<div class="description">';
                                    echo '<span>'.$producto['producto']['nombre'].'</span>';
                                    echo '<p>'.$producto['nombre_promocion'].'</p>';
                                echo '</div>';
                                echo '<div class="price">';

                                    
                                    if ($producto['producto']['ver_precio'] && !$producto['producto']['ver_precio_promocion']){

                                        echo '<span>$'.number_format($producto['producto']['precio'],2).'</span>';

                                    }elseif ($producto['producto']['ver_precio_promocion']){

                                        echo '<span>$'.number_format($producto['producto']['precio_promocion'],2).'</span>';

                                    }else{
                                        echo '<span style="font-size: 20px;">Precio No Disponible</span>';
                                    }



                                echo '</div>';
                            echo '</div>';

                            echo '</a>';

                        echo '</div>';
                        

                    } 
                    ?>
                    
                </div>
                <a data-slide="prev" href="#carousel-<?= $seccion->id ?>" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#carousel-<?= $seccion->id ?>" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php $seccion = $secciones[2]; if($seccion->status){?>
        <div class="col-md-6" style="padding-left: 0px;">
            <div class="carousel slide" id="carousel-<?= $seccion->id ?>" style="padding-right: 5px;">
                <div class="carousel-inner">

                    <?php 
                    $seccion_productos = $seccion->seccion_productos; 
                    foreach ($seccion_productos as $key => $producto) {
                        
                        
                        if($key == 0){
                            echo  '<div class="item active">';
                        }else{
                            echo  '<div class="item">';
                        } 

                            echo '<a href="/p/'.$producto['producto']['url'].'">';

                            echo '<div class="box-image">';
                                 $this->Html->image( ( (isset($producto['producto']['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['producto']['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ), ['width' => '100%', 'height' =>'450px' ]);

                                echo '<div style="width: 100%; height:100%; background: url('.( (isset($producto['producto']['imagenes'][0]['nombre']))? '/upload/productos/'.$producto['producto']['imagenes'][0]['nombre'] : '/img/nodisponible.jpg' ).'); background-position: center center; background-size: cover;" >';
                                echo '</div>';

                            echo '</div>';
                            echo '<div class="box-info-left" style="background-color: '.$producto['nombre_promocion_background'].'; color: '.$producto['nombre_promocion_color'].';">';
                                echo '<div class="description">';
                                    echo '<span>'.$producto['producto']['nombre'].'</span>';
                                    echo '<p>'.$producto['nombre_promocion'].'</p>';
                                echo '</div>';
                                echo '<div class="price">';

                                    if ($producto['producto']['ver_precio'] && !$producto['producto']['ver_precio_promocion']){

                                        echo '<span>$'.number_format($producto['producto']['precio'],2).'</span>';

                                    }elseif ($producto['producto']['ver_precio_promocion']){

                                        echo '<span>$'.number_format($producto['producto']['precio_promocion'],2).'</span>';

                                    }else{
                                        echo '<span style="font-size: 20px;">Precio No Disponible</span>';
                                    }


                                echo '</div>';
                            echo '</div>';

                            echo '</a>';

                        echo '</div>';

                    } 
                    ?>
                    
                </div>
                <a data-slide="prev" href="#carousel-<?= $seccion->id ?>" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#carousel-<?= $seccion->id ?>" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
        </div>
        <?php } ?>


    </div>
</div>

<?php if($banners4){ ?>
<div class="container" style="margin-bottom: 50px;"> 
    <div class="col-md-12"><div style="padding-left:5px; padding-right: 20px;">
        <?php echo $this->element('carousel_banner', ['carousel_id'=>'banners4', 'banners'=>$banners4]); ?>
    </div></div>
</div>
<?php } ?>

<?php if($banners5){ ?>
<div class="container" style="margin-bottom: 50px;"> 
    <div class="col-md-12"><div style="padding-left:5px; padding-right: 20px;">
        <?php echo $this->element('carousel_banner', ['carousel_id'=>'banners5', 'banners'=>$banners5]); ?>
    </div></div>
</div>
<?php } ?>

<!-- SUCURSALES -->
<div class="container box-sucursales">
    <div class="col-md-12"><div style="padding-left:5px; padding-right: 20px;">
        <div class="cerca">
            <div class="row">
                <div class="col-md-12">
                    <h1> UN AVANTI CERCA DE TI </h1>

                    <ul> 
                        <?php foreach ($sucursales as $key => $row): ?>
                            <li> <a target="_blank" href="<?= $row['url'] ?>"><?= $row['name'] ?> </a> </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div></div>
</div>   

