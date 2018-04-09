<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <?php if($this->fetch('title') == 'Productos' ){ if(count($producto) > 0){ ?>

    <title>Avanti | <?= $producto->nombre; ?></title>
    <meta name="keywords" content="<?= $producto->meta_keywords; ?>">
    <meta name="description" content="<?= $producto->meta_descripcion; ?>">

  <?php }}else{ ?>

  <title><?= $this->fetch('title') ?> | Avanti</title>
  <meta name="keywords" content="tienda en linea de muebles">
  <meta name="description" content="Tienda en linea de muebles.">

  <?php } ?>

  <link rel="shortcut icon" href="/favicon.png" /> </head>

  <meta name="rights" content="www.avanti.com">
  <meta name="author" content="www.avanti.com">
  <meta name="DC.Creator" content="Avanti">
  <meta name="subject" content="Retail">
  <meta name="Language" content="Spanish">
  <meta http-equiv="Expires" content="never">
  <meta http-equiv="CACHE-CONTROL" content="Public">
  <meta name="copyright" content="Avanti © 2017">
  <meta name="Designer" content="Avanti">
  <meta name="Publisher" content="Tienda Online, Avanti">
  <meta name="Revisit-After" content="1 day">
  <meta name="distribution" content="Global">
  <meta name="city" content="Monterrey">
  <meta name="country" content="Mexico">
  <meta http-equiv="content-language" content="es-mx">
  <meta name="abstract" content="Tienda de muebles">
  <meta name="rating" content="General">
  <meta name="classification" content="Online Store">
  <meta property="twitter:account_id" content="">
  <meta name="twitter:card" content="app">
  <meta name="twitter:app:id:iphone" content="">
  <meta name="twitter:app:id:ipad" content="">
  <meta name="twitter:app:country" content="mx">
  <meta property="fb:app_id" content="">
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://www.avanti.com/">
  <meta property="og:title" content="Avanti">
  <meta property="og:description" content="Avanti">
  <meta property="og:site_name" content="Avanti">

  

        <?php
            $this->Html->meta('icon');
            /* Bootstrap CSS */
            echo $this->fetch('meta');
            //echo $this->fetch('css');
            echo $this->fetch('script');

        ?>

<link rel="stylesheet" href="/fonts/fonts.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/bootstrap.css">
<link rel="stylesheet" href="/css/bootstrap-theme.css">
<link rel="stylesheet" href="/css/owl.carousel.css">
<link rel="stylesheet" href="/css/owl.theme.css">
<link rel="stylesheet" href="/css/owl.transitions.css">
<link rel="stylesheet" href="/css/style-front.css">
<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="/css/responsive.css">
<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/owl.carousel.js"></script>

<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/inspinia.js"></script>
<script src="/js/plugins/pace/pace.min.js"></script>

<script src="/js/jquery-scrolltofixed-min.js" type="text/javascript"></script>

<script src="//cdn.jsdelivr.net/jquery.marquee/1.3.1/jquery.marquee.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">

<script src="/plugins/elevatezoom-master/jquery.elevatezoom.js"></script>

<script type="text/javascript">


    $(document).ready(function(){

      $('.hover').bind('touchstart touchend', function(e) {
          e.preventDefault();
          $(this).toggleClass('hover_effect');
      });
      
         
    $("#nav_2 a.menu_res").click(function (e) {
      e.preventDefault();
      $("#nav_2 ul").slideToggle(300);
      $("#nav_2 ul").addClass("done");
    });

});
    
    function numberFormat(n,moneda){
            if (typeof(moneda)==='undefined') moneda = '';
            var f =Math.floor(n);
            if((f - n) > .5){
                n=f+1;
            }else{
                n=f;
            }

            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")+moneda;
        }


</script>

    </head>
    <body>
        <!-- Contenido -->
        <?php echo $this->element('header'); ?>
       
        <?= $this->element('Usermgmt.message'); ?>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('promociones') ?>
        <!-- Contenido -->
        <?php echo $this->element('footer'); ?>

<script>

  $(document).scroll(function() {
    var y = $(this).scrollTop();
    if (y > 100) {
      $('#floating').fadeIn();
    } else {
      $('#floating').fadeOut();
    }
  });

  $('.add_wishlist').click(function(){
      
      var this_ = $(this);

      var id_producto = this_.data('id');
      var cantidad = 1;

      var changehtml = this_.data('changehtml');

      $.ajax({

         type: 'POST',
         url: '<?php echo $this->Url->build(["controller" => "Productos", "action" => "agregar_carrito"]); ?>',
         data: {

             id_producto:id_producto,
             cantidad:cantidad

         },
         dataType: 'json',
         success: function(response){

              $.notify({
                icon: false,
                title: '',
                message: response.text
              },{
                type: 'success',
                animate: {
                  enter: 'animated fadeInUp',
                  exit: 'animated fadeOutRight'
                },
                placement: {
                  from: "top",
                  align: "right"
                },
                offset: 20,
                spacing: 10
              });

              if(changehtml != false){
                this_.html('<i class="fa fa-heart" aria-hidden="true"></i>');
              }

              $('#cant-carrito').text(response.cant);
     
         }

      });

       
   });
    
</script>

   
    </body>
</html>
