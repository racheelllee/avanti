<div class="container" style="margin-bottom:50px;">
	<div class="col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Inicio</a></li>
          <li><a href="#">Sucursales</a></li>
        </ol>
    </div>

    <div class="col-md-12">

        <?php 
    		foreach ($sucursales as $key => $sucursal) {
   				echo $this->element('list_sucursal', ['sucursal'=>$sucursal]);
    		
        	}
        ?>
    </div>
</div>