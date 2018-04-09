<?php 
  $cant_carrito = 0;
    if($this->request->session()->check('carrito')) { 
        $cant_carrito = count($this->request->session()->read('carrito'));
    }
?>

<div id="header">
    <div class="container">
        <div class="row">
          <div class="col-lg-3 hidden-md hidden-sm hidden-xs">
              <a href="/" title="Avanti Inspirate" >
                <?php echo $this->Html->image('logo.png', ['alt' => 'Avanti Inspirate', 'class' => 'img-responsive']); ?>
              </a>
          </div><!--col-lg-3-->
          <div class="col-lg-9 col-sm-9">
            <nav class="navbar navbar-white navbar-static yamm">
                <div class="navbar-header">
                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-user" class="navbar-toggle nomargin nopadding">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-jusptify" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="navbar-toggle nomargin nopadding">
                        <a rel="nofollow" href="tel:018006001100">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </a>
                    </button>
                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-shoppingcart" class="navbar-toggle nomargin nopadding">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                    <a class="navbar-brand visible-md visible-sm visible-xs" href="/" style="padding: 10px 0px 0px 0px;"><img class="img-responsive" width="150" src="/img/logo.png" alt="Avanti"></a>
                </div><!--navbar-header-->
                
                <div id="navbar-collapse-user" class="navbar-collapse collapse nopadding fright">
                
                <div class="col-md-12 pull-right menu-header">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                    <div class="pre_social">
                      <ul>
                        <li> <a href="https://www.facebook.com/mueblesavanti/" target="_blank"> <img src="/img/redes/facebook.png" alt="..." class="img-responsive"> </a> </li>
                        <li> <a href="https://www.instagram.com/avantimuebles/" target="_blank"> <img src="/img/redes/instagram.png" alt="..." class="img-responsive"> </a> </li>
                        <li> <a href="https://www.youtube.com/channel/UCZyYc9IXMUMqPd8HYHyd2zg?view_as=subscriber" target="_blank"> <img src="/img/redes/youtube.png" alt="..." class="img-responsive" style="width: 28px;"> </a> </li>
                      </ul>
                    </div>

                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><a href="/acerca-de" class="header-menu-principal">Acerca de</a></div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><a href="/formas-de-pago" class="header-menu-principal">Formas de Pago</a></div>
                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><a href="/contactanos" class="header-menu-principal">Contáctanos</a></div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><a href="/sucursales" class="header-menu-principal">Sucursales</a></div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                         <a href="/wishlist" class="header-menu-principal"> <button class="goWishlist">
                            <i class="fa fa-heart-o" aria-hidden="true">
                              <div id="cant-carrito"><?= $cant_carrito ?></div>
                            </i> 
                            Wishlist
                          </button></a>
                  </div>
                </div>
                <div class="col-md-12">
                  <form method="post" action="/productos/buscar">
                    <div id="custom-search-input">
                      <div class="input-group">
                        <input type="text" class="form-control input-lg" placeholder="Buscar" name="data[Producto][buscar]" value="<?php if(isset($this->request->data['data']['Producto']['buscar']) and $this->request->data['data']['Producto']['buscar'] !="-1"){ echo $this->request->data['data']['Producto']['buscar'];} ?>" />
                        <span class="input-group-btn">
                          <button class="btn btn-info btn-lg" type="submit">
                            <i class="fa fa-search"></i>
                          </button>
                        </span>
                      </div>
                    </div>
                </form>
                </div>
                </div><!--navbar-collapse-user-->
            </nav><!--navbar-->
          </div>
        </div>
    </div>
</div>

<div class="header">
  <div class="container">
      <div class="col-md-12">
        <nav id="nav" class="nav-desktop">
          <ul class="nav-toplevel">

                
              <?php
                $subC = 0;  
                foreach ($categorias as $categoriaP){

                    if($categoriaP['publicado']){

                      echo '<li style="text-align: center;"><a href="/sc/'.$categoriaP['url'].'"><span class="nav-toplevel-text">'.$categoriaP['nombre'].'</span></a>';

                        if($categoriaP->children){
                           echo '<div class="meganav">';
                                echo '<div class="meganav-content">';
                                    echo '<div class="meganav-content-links">';
                                        


                                          echo '<ul>';
                                          foreach ($categoriaP->children as $categoriaS){
                                            
                                            if($categoriaS['publicado']){
                                              echo '<li>';
                                                echo '<a href="/sc/'.$categoriaS['url'].'">'.$categoriaS['nombre'].'</a>';
                                              echo '</li>';
                                            }

                                          }
                                          echo '</ul>';

                                    echo '</div>';
                                    echo '<div class="meganav-content-product">';
                                          if (!is_null($categoriaP['producto_destacado_id']) && isset($product)) {
                                            echo '<div class="product-callout featured-product" style="display:block;text-align:right;background-image:url(/upload/productos/'.$product_imagen[$categoriaP['producto_destacado_id']].');">';
                                            //////
                                                echo '<a href="/p/'.$product[$categoriaP['producto_destacado_id']]['url'].'" display:block; width:100%; height:100%;>';
                                                  echo '<div style="text-align:center; width:380px; display:inline-block;">';
                                                    echo '<div class="item_info item_info_q" style="margin-top:150px;background-color:rgba(212, 212, 212, 0.8);">';
                                                        echo '<h3 style="margin-top: 10px;"> '.$product[$categoriaP['producto_destacado_id']]['nombre'].' </h3>';
                                                            
                                                        if($product[$categoriaP['producto_destacado_id']]['ver_precio'] && $product[$categoriaP['producto_destacado_id']]['ver_precio_promocion']){

                                                            echo '<h5> <del>Regular $'.number_format($product[$categoriaP['producto_destacado_id']]['precio'],2).' </del> </h5>';
                                                            echo '<h2>Contado $'.number_format($product[$categoriaP['producto_destacado_id']]['precio_promocion'],2).' </h2>';

                                                        }elseif ($product[$categoriaP['producto_destacado_id']]['ver_precio']){

                                                            echo '<h2>Contado $'.number_format($product[$categoriaP['producto_destacado_id']]['precio'],2).' </h2>';

                                                        }elseif ($product[$categoriaP['producto_destacado_id']]['ver_precio_promocion']){

                                                            echo '<h2>Contado $'.number_format($product[$categoriaP['producto_destacado_id']]['precio_promocion'],2).' </h2>';

                                                        }else{
                                                            echo '<p class="price-new"></p>';
                                                            echo '<h2> Precio No Disponible </h2>';
                                                        }

                                                        if ($product[$categoriaP['producto_destacado_id']]['ver_meses_sin_intereses']){
                                                            echo '<div class="orange_bg_strip">';
                                                                echo '<p> A '.$product[$categoriaP['producto_destacado_id']]['meses_sin_intereses'].' meses de $'.number_format($product[$categoriaP['producto_destacado_id']]['precio_meses_sin_intereses'],2).'</p>';
                                                            echo '</div>';
                                                        }
                                                    echo '</div>';
                                                  echo '</div>';
                                            //////
                                            echo '</a></div>';
                                          }else{
                                            echo '<div class="product-callout featured-product" style="background-image: url(\'/'.$categoriaP['imagen_fondo'].'\')"></div>';
                                          }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';

                        }

                      echo'</li>';
                    }
                }
              ?> 
              </ul>

          </ul>
        </nav>
      </div>
  </div>
</div>

<div class="container">
  <div class="marquesina">
   <?php foreach ($promociones as $key => $row) {
      echo '<div class="box-mq">';
        echo ' <span><a style="font-size: 14px;font-weight: 500;" target="_blank" href="'.$row['url'].'">'.$row['nombre'].'</a></span>';
      echo '</div>';
   }?>
  </div>
</div>

<script type="text/javascript">

$( function() {
    $('.marquesina').marquee({
      speed: 20000,
      gap: 50,
      delayBeforeStart: 0,
      direction: 'left',
      duplicated: false,
      pauseOnHover: true
    });
});

</script>

