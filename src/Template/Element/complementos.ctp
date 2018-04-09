
<?php $scriptsComplementos='';?>
<?php if(!is_null($complementos) && (is_array($complementos)) && (isset($complementos[0]))): ?>
<script>
    $(document).ready(function() {

        var owl<?php echo $id; ?> = $("#owl-demo-<?php echo $id; ?>");
     
      owl<?php echo $id; ?>.owlCarousel({
          items : 5, //10 items above 1000px browser width
          itemsDesktop : [1200,5], //5 items between 1000px and 901px
          itemsDesktopSmall : [1000,3], // betweem 900px and 601px
          itemsTablet: [600,3], //2 items between 600 and 0
          itemsMobile : [480,2], // itemsMobile disabled - inherit from itemsTablet option
          pagination: false,
      });
      
      // Custom Navigation Events
      $("#next_<?php echo $id; ?>").click(function(){
        owl<?php echo $id; ?>.trigger('owl.next');
      })
      $("#prev_<?php echo $id; ?>").click(function(){
        owl<?php echo $id; ?>.trigger('owl.prev');
      })


        
    });
                </script>
                            <div class="carousel_1">
                                <h3><?php echo $titulo; ?></h3>
                               

                                <div class="carousel_inn">
                                    <div id="owl-demo-<?php echo $id; ?>" class="owl-carousel owl-theme">
                                        <?php foreach($complementos as $complemento):?>
                                        <div class="item">
                                            <div onmouseover="$('#<?php echo $id; ?>precio_<?= $complemento->url; ?>').show(); $(this).addClass('shadow');" onmouseout="$('#<?php echo $id; ?>precio_<?= $complemento->url; ?>').hide(); $(this).removeClass('shadow');" style="min-height: 210px;">
                                                <a href="/p/<?= $complemento->url; ?>">

                          
    <?php  if( count( $complemento->imagenes[0]) > 0){  ?>
                                                    <div style="background-image: url('<?php echo $this->Image->resize('img/productos/original', $complemento->imagenes[0]->nombre, 130, null, true);?>'); background-size: 130px 115px; background-repeat: no-repeat; background-position: center; width: 100%; height: 115px;  align: center;">


                                                    <?php }else{?>

                                                    <div style="background-image: url(<?php echo $this->Image->resize('/img', "logoPadmont-cuadro.png", 130, 130, true);?>); background-size: 130px 115px; background-repeat: no-repeat; background-position: center; width: 100%; height: 115px;  align: center;">

                                                    <?php }?>
                                                    <img src="/img/spacer.gif" alt="" id="ofertaImg_<?= $complemento->url; ?>" >
                                                    </div>
                                                </a>
                                                <h4 style="font-size: 12px;"><a href="/p/<?= $complemento->url; ?>" style="color: #7e7e7e;text-align:center;font-size:12px;margin:auto;width:90%;display:block;"><?= strlen($complemento->nombre) > 30 ? substr($complemento->nombre,0,30)."..." : $complemento->nombre;?></a></h4>
                                                <p><?= $complemento->descripcion; ?></p>
                                           
                                                 
                                                <div class="pdsf" id="<?php echo $id; ?>precio_<?= $complemento->url; ?>" calss="hidden">

                                                   <?php if(  $complemento->IsProductGroup  ){  ?>
                        <div class="include">&nbsp;Desde:</div>
                        <?php } ?>
                                                    <span>
                                                                <div class="price">
        


    <?php if ($complemento->precio > 0 ) {  ?>
         <b id="precioDiv_<?= $complemento->url; ?>">$<?= number_format($complemento->precio,0); ?></b>
    <?php } ?>
                                                                    <div style="color: #9d0d04; font-size:11px; " align="center"><b><?php if($producto->envio_gratis){echo "Env&iacute;o Gratis";}  ?></b></div>
                                                                </div>
                                                                <?php if(count($complemento->atributos) > 0): ?>
                                                                <div class="btn btn-warning">
                                                                    <a href="/p/<?= $complemento->url ?>" class="btn" ><img src="/img/basket_icon.png" width="20" alt=""></a>
                                                                </div>
                                                                <?php else:?>
                                                                
<?php if ($complemento->precio > 0 ) {  ?>

                                                                <div class="btn btn-warning btn-carrito cvg" data-id="<?= $complemento->id ?>" data-url="<?= $complemento->url ?>">
                                                                    <a href="#" ><img src="/img/basket_icon.png" width="20" alt=""></a>
                                                                </div>
                                                               
<?php } ?>


                                                                <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php    $scriptsComplementos.="getpromoproducto('".$complemento->url."');\n";
                                                         $scriptsComplementos.="$('#precio_".$complemento->url."').hide();"; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="customNavigation">
                                        <a id="prev_<?php echo $id; ?>" class="prev"></a>
                                        <a id="next_<?php echo $id; ?>" class="next"></a>
                                    </div>
                                </div>
                            </div>
                        
                       
                        
                <script>
               
                    <?php echo $scriptsComplementos; ?>
                </script>
                <?php endif;?>