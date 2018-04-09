<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<div class="" style="margin-bottom: 50px;"> 

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
        <!-- Indicators -->
        <!-- <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol> -->

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

<div class="container box-ofertas">
    <div class="col-md-12">
        <div class="box-title"><span>Ofertas de remate</span></div>
    </div>
    <div class="col-md-12 box-product">
        <?php if( sizeof($ofertas_remate) > 4 ): ?>
            <div class="carousel slide" id="prod-oferta">
                <div class="carousel-inner">

                    <?php foreach ($ofertas_remate as $key => $row) {

                        if($key < 4){
                            echo '<div class="item active">';
                                echo '<div class="col-md-3" style="padding-left: 0px;">';
                                        echo '<div class="box-image">';
                                             echo $this->Html->image('../productos/'.$row['producto']['image'].'', ['width' => '100%', 'height' =>'250px' ]);
                                        echo '</div>';
                                        echo '<div class="box-info">';
                                            echo '<div class="box-description">';
                                                echo '<span>'.$row['producto']['nombre'].'</span>';
                                                echo '<p class="price-old">MXN $'.number_format($row['producto']['precio_promocion'],2).'</p>';
                                                echo '<p class="price-new">MXN $'.number_format($row['producto']['precio'],2).'</p>';
                                            echo '</div>';
                                            echo '<div class="box-price">';
                                                 echo $this->Html->image('image-price.png', ['width' => '70px', 'height' =>'70px' ]);
                                                echo '<span>$'.number_format($row['producto']['monto_interes'],2).'</span>';
                                                echo '<p>A 12 MESES SIN INTERESES</p>';
                                            echo '</div>';
                                        echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }elseif($key >= 4){

                            echo '<div class="item">';
                                echo '<div class="col-md-3" style="padding-left: 0px;">';
                                        echo '<div class="box-image">';
                                             echo $this->Html->image('../productos/'.$row['producto']['image'].'', ['width' => '100%', 'height' =>'250px' ]);
                                        echo '</div>';
                                        echo '<div class="box-info">';
                                            echo '<div class="box-description">';
                                                echo '<span>'.$row['producto']['nombre'].'</span>';
                                                echo '<p class="price-old">MXN $'.number_format($row['producto']['precio_promocion'],2).'</p>';
                                                echo '<p class="price-new">MXN $'.number_format($row['producto']['precio'],2).'</p>';
                                            echo '</div>';
                                            echo '<div class="box-price">';
                                                 echo $this->Html->image('image-price.png', ['width' => '70px', 'height' =>'70px' ]);
                                                echo '<span>$'.number_format($row['producto']['monto_interes'],2).'</span>';
                                                echo '<p>A 12 MESES SIN INTERESES</p>';
                                            echo '</div>';
                                        echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                ?>
                </div>
                <a data-slide="prev" href="#prod-oferta" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#prod-oferta" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($ofertas_remate as $key => $row) {
                echo '<div class="col-md-3" style="padding-left: 0px;">';
                    echo '<div class="box-image">';
                          echo $this->Html->image('../productos/'.$row['producto']['image'].'', ['width' => '100%', 'height' =>'250px' ]); 
                    echo '</div>';
                    echo '<div class="box-info">';
                        echo '<div class="box-description">';
                            echo '<span>'.$row['producto']['nombre'].'</span>';
                            echo '<p class="price-old">MXN $'.number_format($row['producto']['precio_promocion'],2).'</p>';
                            echo '<p class="price-new">MXN $'.number_format($row['producto']['precio'],2).'</p>';
                        echo '</div>';
                        echo '<div class="box-price">';
                            echo $this->Html->image('image-price.png', ['width' => '70px', 'height' =>'70px' ]);
                            echo '<span>$'.number_format($row['producto']['monto_interes'],2).'</span>';
                            echo '<p>A 12 MESES SIN INTERESES</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }?>
        <?php endif ?>
       
    </div>
</div> 

<div class="container box-seccion5">
    <div class="col-md-12">
        <div class="col-md-6" style="padding-left: 0px;">
            <div class="carousel slide" id="prod-left">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="box-image">
                             <?php echo $this->Html->image('../productos/frandelli.png', ['width' => '100%', 'height' =>'450px' ]); ?>
                        </div>
                        <div class="box-info-left">
                            <div class="description">
                                <span>Sala Pretz</span>
                                <p>Promo especial</p>
                            </div>
                            <div class="price">
                                <span>$12,999</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="box-image">
                             <?php echo $this->Html->image('../productos/frandelli.png', ['width' => '100%', 'height' =>'450px' ]); ?>
                        </div>
                        <div class="box-info-left">
                            <div class="description">
                                <span>Sala Pretz</span>
                                <p>Promo especial</p>
                            </div>
                            <div class="price">
                                <span>$12,999</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a data-slide="prev" href="#prod-left" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#prod-left" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
        </div>


        <div class="col-md-6" style="padding-left: 0px;">
            <div class="carousel slide" id="prod-right">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="box-image">
                             <?php echo $this->Html->image('../productos/18527937_1298043236959217_6381051465463771164_n.jpg', ['width' => '100%', 'height' =>'450px' ]); ?>
                        </div>
                        <div class="box-info-right">
                            <div class="description">
                                <span>Comedor lue</span>
                                <p>Promo especial</p>
                            </div>
                            <div class="price">
                                <span>$16,999</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="box-image">
                             <?php echo $this->Html->image('../productos/18527937_1298043236959217_6381051465463771164_n.jpg', ['width' => '100%', 'height' =>'450px' ]); ?>
                        </div>
                        <div class="box-info-right">
                            <div class="description">
                                <span>Comedor lue</span>
                                <p>Promo especial</p>
                            </div>
                            <div class="price">
                                <span>$16,999</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a data-slide="prev" href="#prod-right" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#prod-right" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container box-seccion6">
    <div class="col-md-12">
        <div class="box-title"><span>Ofertas del Verano</span></div>
    </div>
    <div class="col-md-12 list-product">
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/1.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/3.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/2.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/6.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>

        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/7.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/8.png', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/542023835T840.jpg', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
        <div class="col-md-3">
            <?php echo $this->Html->image('../productos/7990421.jpg', ['style' => 'width:100%; height: 250px;']); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-link"><a>Ir a colección <i class="fa fa-chevron-right" aria-hidden="true"></i></a></div>
    </div>
</div> 

<div class="container box-ofertas">
    <div class="col-md-12">
        <div class="box-title"><span>Ofertas exclusiva en línea</span></div>
    </div>
    <div class="col-md-12 box-product">
       <div class="col-md-4" style="padding-left: 0px;">
            <div class="box-image">
                 <?php echo $this->Html->image('../productos/bufetero.png', ['width' => '100%', 'height' =>'400px' ]); ?>
            </div>
            <div class="box-info">
                <div class="box-description">
                    <span>Buffetero Shore</span>
                    <p class="price-old">MXN $23,999</p>
                    <p class="price-new">MXN $19,999</p>
                </div>
                <div class="box-price">
                    <?php echo $this->Html->image('image-price.png', ['width' => '85px', 'height' =>'85px' ]); ?>
                    <span style="margin-left: 45px !important">$2,500</span>
                    <p style="margin-left: 25px !important; margin-right: 15px !important;">A 12 MESES SIN INTERESES</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-left: 0px;">
            <div class="box-image">
                 <?php echo $this->Html->image('../productos/miramont.jpeg', ['width' => '100%', 'height' =>'400px' ]); ?>
            </div>
            <div class="box-info">
                <div class="box-description">
                    <span>Comedor Miramont</span>
                    <p class="price-old">MXN $18,999</p>
                    <p class="price-new">MXN $12,999</p>
                </div>
                <div class="box-price">
                    <?php echo $this->Html->image('image-price.png', ['width' => '85px', 'height' =>'85px' ]); ?>
                    <span style="margin-left: 45px !important">$1,100</span>
                    <p style="margin-left: 25px !important; margin-right: 15px !important;">A 12 MESES SIN INTERESES</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-left: 0px;">
            <div class="box-image">
                 <?php echo $this->Html->image('../productos/recamara.png', ['width' => '100%', 'height' =>'400px' ]); ?>
            </div>
            <div class="box-info">
                <div class="box-description">
                    <span>Recamara Cosmo</span>
                    <p class="price-old">MXN $15,999</p>
                    <p class="price-new">MXN $11,999</p>
                </div>
                <div class="box-price">
                    <?php echo $this->Html->image('image-price.png', ['width' => '85px', 'height' =>'85px' ]); ?>
                    <span style="margin-left: 45px !important">$1,000</span>
                    <p style="margin-left: 25px !important; margin-right: 15px !important;">A 12 MESES SIN INTERESES</p>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="container box-sucursales">
    <div class="col-md-12">
        <div class="box">
            <?php echo $this->Html->image('../productos/IMG_9319B.jpg', ['width' => '100%', 'height' =>'550px' ]); ?>
            <div class="sub-box">
                <div class="row title">
                    <span> Visita Nuestras Sucursales</span>
                </div>
                <div class="row name">
                    <?php $i = count($sucursales) - 1; ?>
                    
                    <?php foreach ($sucursales as $key => $row): ?>
                        
                        <?php $x = $i != $key ? 'border-right: 1px solid #333;' : ''; ?>

                        <div class="col-md-4" style="<?= $x ?> margin-top: 10px;"><a target="_blank" href="<?= $row['url'] ?>"><?= $row['name'] ?> </a></div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>                                              

<?php echo $this->element('promociones') ?>

<script src="/js/jquery.mb.YTPlayer.js"></script>


<script type="text/javascript">

$(document).ready(function(){
    
    $(".player").mb_YTPlayer();

    $(".video-controls .pause").click(function() {
        $(".player").pauseYTP();
        $(".video-controls .pause").addClass('hidden');
        $(".video-controls .play").removeClass('hidden');
    });

    $(".video-controls .play").click(function() {
        $(".player").playYTP();
        $(".video-controls .play").addClass('hidden');
        $(".video-controls .pause").removeClass('hidden');
    });
    $(".video-controls .fullscreen").click(function() {
        $(".player").fullscreen();
    });


});
</script>