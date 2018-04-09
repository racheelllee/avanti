<div id="content">
<div class="container">
<div class="row">
<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
<ol class="breadcrumb">
  <li><a href="/">Inicio</a></li>
  <?php 
    foreach ($crumbs as $crumb){
    ?>
  <li><a href="/c/<?= h($crumb->url) ?>"><?= h($crumb->nombre) ?></a></li>
  <?
    }
    
    ?>
</ol>
<div id="category_1">
  <div class="banner_1">
    <?php if($categoria->banner){ ?>
    <img src="/img/categorias/<?= h($categoria->banner) ?>" alt="<?= h($categoria->nombre) ?>">
    <?php }else{ ?>
    <h3><?= h($categoria->nombre) ?></h3>
    <?php }?>
  </div>
  <div class="threebox">
    <?php $i = 0; ?>
    <div class="row">

<?php foreach($categoria_sub as $sub): ?>
    
    <?php if($categoria->categoria_id){?>
        
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-top:15px;">
    
    <?php }else{ ?>
    

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="margin-top:15px;">
    
    <?php }?>
    

   
              
        <a href="/sc/<?php echo($subcurls[$i])?>" style="color:#fff;">
        
        <?php if($categoria->categoria_id ){?>
            

            <div class="block_2" style="background: url(<?php echo $this->Image->resize('/img/categorias', $subcBanners[$i], 220, null, true);?>) no-repeat; height: 125px">




        <?php }else{ ?>
              
        <?php 

         

        ?>
              <?php if(  $subcBanners[$i]  ){  ?>
            <div class="block_3" style="  background: url(<?php echo $this->Image->resize('/img/categorias', $subcBanners[$i], 220, 220, true);?>) no-repeat;">

              <?php }else{  ?>





                   <div class="block_3" style="background: url(<?php echo $this->Image->resize('/img', "logoPadmont-cuadro.png", 220, 220, true);?>) no-repeat;">

              <?php } ?>

        <?php }?>
                  
             </div>


              </a>


              <?php echo $subcNames[$i] ?>
  
              </div>
              <?php $i++; endforeach; ?>
            </div>
          </div>
          <div class="brands">
            <div id="owl-demo" class="owl-carousel owl-theme">
              <?php foreach($marcas as $marca){  ?>
              <div class="item" style="display:table-cell; height: 100px; vertical-align: middle;"><a href="/productos/buscar/-1/<?= $marca['id'] ?>"><img src="/img/marcas/<?= $marca['logo'] ?>" width="80" alt="<?= $marca['nombre'] ?>" border="0"></a></div>
              <?php  }?>
            </div>
            <div class="customNavigation">
              <a class="prev"></a>
              <a class="next"></a>
            </div>
          </div>
          <div class="fourblk">
            <?= $categoria->banner_secundario ?>
          </div>
          <div class="detailbox" style="text-size: 10px">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="font-size: 11px; color: #487190;">
                <?= strip_tags($categoria->descripcion) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
      </div>
    </div>
  </div>
</div>
<!-- Begin MailChimp Signup Form -->
<p>
  <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
</p>
<!-- Modal -->
<div class="mdl">
  <div class="boletin">
    <img src="/img/mail-icon_1x.png">
    <button type="button" class="close mdl-cls"><span aria-hidden="true">&times;</span></button>
    <div id="mc_embed_signup">
      
    </div>
  </div>
  <!--End mc_embed_signup-->
</div>
<script type="text/javascript">
  $( ".oreja-boletin" ).click(function() {
      $(".mdl").fadeIn('slow', function(){
        $(".boletin").slideDown();
      });
      
      
  });
  
  $( "#mc-embedded-subscribe, .mdl-cls" ).click(function() {
    setTimeout( function(){ 
      $(".boletin").slideUp('slow', function(){
        $(".mdl").fadeOut();
      });    
    }  , 300 );
  });
  
</script>