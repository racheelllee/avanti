<div class="container" style="margin-bottom:50px;">

    <div class="col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Inicio</a></li>
          <li><a href="#">Formas de Pago</a></li>
        </ol>
    </div>  

    <div class="col-md-12">
      <div class="pago">
        <h1> NUESTRAS FORMAS DE PAGO </h1>
        <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip my nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad meniam, quis nisi enim ad m </p>
      </div>
    </div>

    <div class="col-md-12" style="text-align:center; margin-bottom:20px; margin-top:20px;">
        <h2 class="title-static-pages">FORMAS DE PAGO</h2>
    </div>
    <div class="col-md-12" style="text-align:center;">
       <?php
        foreach ($formas_pagos as $key => $forma) {
            echo '<img src="/img/formasPago/'.$forma->imagen.'" style="height:50px; margin:20px;">';
        }
       ?>
    </div>
</div>