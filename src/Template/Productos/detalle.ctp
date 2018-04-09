<?php 
	$ids_carrito = [];
    if($this->request->session()->check('carrito')) { 
        $carrito = $this->request->session()->read('carrito');
        foreach ($carrito as $key => $product) {
          $ids_carrito[] = $product['id'];
        }
    }
?>

<div id="">
	 <div class="container">

	        <ol class="breadcrumb" style="margin-bottom: 0px;">
	          <li><a href="/">Inicio</a></li>
	          <li><a href="#"><?= h($producto->nombre) ?></a></li>
	        </ol>

			<?php if(count($producto) > 0){ ?>
			<div>
				 <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							 <br>
						</div>
				 </div>
				 <div class="row">
						
						<?php if($producto->estatus_id && !$producto->deleted){ ?>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="product-view">

							    <!-- main slider carousel -->
							    <div class="row">
							        <div class="col-md-11" id="slider">
							            
							                <div class="col-md-12" id="carousel-bounding-box">
							                    <div id="myCarousel" class="carousel slide">
							                        <!-- main slider carousel items -->
							                        <div class="carousel-inner">

							                        	<?php foreach($producto->imagenes as $k => $img){ ?>

								                            <div class="item <?= ($k == 0)? 'active' : '' ?>" data-slide-number="<?= $k ?>">
								                                <img src="<?php echo $this->Image->resize('/upload/productos/', $img->nombre, 900, 900, true);?>" class="img-responsive img-zoom" style="width:100%;" data-zoom-image="<?php echo $this->Image->resize('/upload/productos/', $img->nombre, 1600, 1600, true);?>">
								                            </div>

								                        <?php } ?>

							                        </div>
							                        <!-- main slider carousel nav controls --> 
							                        <a data-slide="prev" href="#myCarousel" class="left carousel-control">
									                    <span class="icon-prev"></span>
									                </a>
									                <a data-slide="next" href="#myCarousel" class="right carousel-control">
									                    <span class="icon-next"></span>
									                </a>

									                <div class="box-whislist">

									                	<div class="fa_icons">
															
															<?php if(!in_array($producto->id, $ids_carrito)){ ?>

										                		<a href="#" class="add_wishlist" data-id="<?= $producto->id ?>"> <i class="fa fa-heart-o"></i> </a>

										                	<?php }else{ ?>

										                		<a href="#"> <i class="fa fa-heart"></i> </a>

										                	<?php } ?>

										                	<a href="#"> <i class="fa fa-search"></i> </a>

									                	</div>
									                </div>

							                    </div>
							                </div>

							        </div>
							    </div>
							    <!--/main slider carousel-->
							    <br>
							    <!-- thumb navigation carousel -->
							    <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">
							        
							        <!-- thumb navigation carousel items -->
							        <ul class="list-inline">
								         	
								        <?php foreach($producto->imagenes as $k => $img){ ?>

								         	<li> <a id="carousel-selector-<?= $k ?>" class="<?= ($k == 0)? 'selected' : '' ?>">
								            	<img src="<?php echo $this->Image->resize('/upload/productos/', $img->nombre, 100, 100, true);?>" class="img-responsive">
								          	</a></li>

								        <?php } ?>
						
							        </ul>
							        
							    </div>

							</div>

							<div class="row" style="margin-top:15px;" id="prod_details">
								<div class="col-xs-12">
									<?= $producto->descripcion_larga ?>
								</div>
							</div> 


							 
						</div>

						
						
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-md-offset-1">    
								<div class="jersey">
									<h3> <?= $producto->nombre ?> </h3>


									<?php 
		                                    
                                    	if($producto['ver_precio'] && $producto['ver_precio_promocion']){

						                    echo '<h4> <del>Regular $'.number_format($producto['precio'],2).' </del> </h4>';
											echo '<h2>Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

						                }elseif ($producto['ver_precio']){

						                    echo '<h2>Contado $'.number_format($producto['precio'],2).' </h2>';

						                }elseif ($producto['ver_precio_promocion']){

						                    echo '<h2>Contado $'.number_format($producto['precio_promocion'],2).' </h2>';

						                }else{
						                    
						                    echo '<h2> Precio No Disponible </h2>';
						                }

                                    ?>


                                    <?php
	                                	if ($producto['ver_meses_sin_intereses']){
							                echo '<div class="orange_bg_strip orange_bg_strip">';
												echo '<p> A '.$producto['meses_sin_intereses'].' meses de $'.number_format($producto['precio_meses_sin_intereses'],2).' meses  sin intereses </p>';
											echo '</div>';
							            }
	                                ?>

									<a> SKU: <?= $producto->sku ?> </a>

									<div class="conty_info">
										<p> Contacta nuestra tienda Avanti más cercana para revisar disponibilidad en tienda <a href="/sucursales" style="text-decoration:none;">Contáctanos ›</a> </p>

										<button class="btn btn-default btn_red add_wishlist" data-id="<?= $producto->id ?>"  data-changehtml="false"> AGREGAR A WISHLIST <i class="fa fa-angle-right"></i> </button>
									</div>
								</div>

								<div class="compatir">
									<h3> COMPARTIR </h3>

									<ul>
										<li> <a href="mailto:?subject=Liga de Avanti&amp;body=Avanti: <?= $ruta ?>"> <img src="/img/msg1.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($ruta) ?>"> <img src="/img/fb.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode($ruta) ?>&media=&description="> <img src="/img/pinterest.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a href="https://twitter.com/home?status=<?= urlencode($ruta) ?>"> <img src="/img/twit.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a href="https://plus.google.com/share?url=<?= urlencode($ruta) ?>"> <img src="/img/google_plus.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a onclick="copyToClipboard('<?= $ruta ?>')"> <img src="/img/link.png" alt="..." class="img-responsive"> </a> </li>
										<li> <a onclick="copyToClipboard('<?= $ruta ?>')"> Copiar URL de producto </a> </li>
									</ul>
								</div>

								<div class="medidas">
									<h3> PREGUNTAS FRECUENTES </h3>

									<p><a href="/info/entrega-a-domicilio">Entrega a domicilio › </a></p>
	                                <p><a href="/info/asesorias-en-decoracion">Asesorías en decoración › </a></p>
	                                <p><a href="/formas-de-pago">Formas de pago › </a></p>
	                                <p><a href="/info/garantías">Garantías › </a></p>
	                                <p><a href="/info/politicas">Políticas › </a></p>
	                                <p><a href="/info/preguntas-frecuentes">Preguntas frecuentes › </a></p>
								</div>

								
								
							</div>
					
				 		<?php }else{ ?>
							 <div class="col-xs-12" style="color: red; font-size:14px; font-family:'HelveticaNeueLTStd75Bold';" align="center">
									<b><?= __('PRODUCTO TEMPORALMENTE NO DISPONIBLE') ?></b><br><br>
							 </div>
				 <?php }?>
			</div>

			</div>
			

			<!--  COMPLETA TU LOOK -->
			<?php if($producto->complementos){ ?>
				<div class="box-ofertas">
				    <div class="col-md-12" style="text-align:center;">
				       <h3 style="text-transform: uppercase;"> <strong>Completa el look</strong> </h3>
				    </div>
				    <div class="col-md-12">

				    	<?php echo $this->element('slider_producto', ['all_productos'=>$producto->complementos, 'column'=>4, 'column_class'=>'col-md-12', 'is_whislist'=>true, 'heightImg' => '185px', 'carousel_id'=>'slider-complementos']); ?>

				    </div>
				</div>
			<?php } ?>


			<!--  PRODUCTOS RELACIONADOS -->
			<?php if($similares){ ?>
				<div class="box-ofertas">
				    <div class="col-md-12" style="text-align:center; margin-top: 40px;">
				       <h3 style="text-transform: uppercase;"> <strong>Productos Relacionados</strong> </h3>
				    </div>
				    <div class="col-md-12">
				        <?php echo $this->element('slider_producto', ['all_productos'=>$similares, 'column'=>4, 'column_class'=>'col-md-12', 'is_whislist'=>true, 'heightImg' => '185px', 'carousel_id'=>'slider-relacionados']); ?>
				    </div>
				</div>
			<?php } ?>


			
			
	 </div>
	 <?php }else{ ?>
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="listado_1" align="center">
				 <br><br>
				 <h2><?= __('Este producto no existe') ?></h2>
			</div>
	 </div>
	 <?php } ?>
</div>
</div>


<script type="text/javascript">

	// SLIDER CAROUSEL
	$('#myCarousel').carousel({
	    interval: 4000
	});

	// handles the carousel thumbnails
	$('[id^=carousel-selector-]').click( function(){
	  var id_selector = $(this).attr("id");
	  var id = id_selector.substr(id_selector.length -1);
	  id = parseInt(id);
	  $('#myCarousel').carousel(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	});

	// when the carousel slides, auto update
	$('#myCarousel').on('slid', function (e) {
	  var id = $('.item.active').data('slide-number');
	  id = parseInt(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $('[id=carousel-selector-'+id+']').addClass('selected');
	});
	 

	// COPIAR 
	function copyToClipboard(text) {
	  var $temp = $("<input>")
	  $("body").append($temp);
	  $temp.val(text).select();
	  document.execCommand("copy");
	  $temp.remove();
	}

	$(".img-zoom").elevateZoom({
		tint:false, tintColour:'#782133', tintOpacity:0.5
	});
</script>
