<?php
  $actual_link = "$_SERVER[REQUEST_URI]";
  $link_no_query = strtok($actual_link, "?"); 
  $query_params = $_GET;
  $scriptsproductos="";
  $uri = $_SERVER['REQUEST_URI'];
?>

<script type="text/javascript">
  var params = <?php
    if (sizeof($query_params) > 0){
        echo json_encode($query_params);
    }
    else{
        echo "{}";
    } ?>;
  
  var base_url = "<?php echo $link_no_query; ?>";
</script>




<?php if($categoria->banner){ ?>
<div class="container"> 

     <img class="img-responsive" style="width: 100%;" src="/<?= $categoria->banner ?>"/>

</div>
<?php } ?>


<div id="content">
  <div class="container" id="listado">
    <div class="row">

      <div class="col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Inicio</a></li>
          <?php 
          $contador = 1;
            foreach ($crumbs as $crumb){
              if($categoria->id == $crumb->id){
          ?>
            <li><a href="#"><?= h($crumb->nombre) ?></a></li>
          <?php
              }else{
                if($contador == 1){
                  $contador++;
          ?>
                  <li><a href="/sc/<?= h($crumb->url) ?>"><?= h($crumb->nombre) ?></a></li>

          <?php        
                }else{
          ?>
                  <li><a href="/sc/<?= h($crumb->url) ?>"><?= h($crumb->nombre) ?></a></li>
          <?php
                }
              } //end else
            
            }//end foreach
          ?>
        </ol>
      </div>

      <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs">
        <div id="sidebar">


          <h3 class="h3-title"> FILTRAR POR: </h3>
          
          <?= $this->element('lista_subcategorias', [  'categoria'=>$categoria, 
                                                  'categoria_sub'=>$categoria_sub, 
                                                  'hermanos'=>$hermanos, 
                                                  'padres'=> $padres] ); ?> 






                                        

          <h3 data-toggle="collapse" data-target="#collapse-precio">Precio</h3>
          <div id="collapse-precio" class="collapse in <?php if(isset($opciones['precio'])){ echo 'in'; } ?>">
            <ul class="fts">
              <?php $url = $query_params; unset($url['precio']); unset($url['precio']); ?>
                <li style="border-bottom: 1px solid #b1afaf;"><a href="#" class="<?php if (!isset($opciones['precio'])) {echo "active";} ?> todas" data-url='<?php echo json_encode($url); ?>'>Todas</a></li>
                <?php foreach ($all_precios as $opcion) {?>
                <li><a class="precio <?php if(isset($opciones['precio']) && $opciones['precio']==($opcion->min.'-'.$opcion->max)){echo "active";}?>" data-min="<?= $opcion->min ?>" data-max="<?= $opcion->max ?>" ><?php echo $opcion->nombre; ?></a></li>
                <?php }?>
            </ul>
          </div>

          <?php $i=1; foreach ($filtros as $filtro) { ?>
          <?php if(count($filtro->opcionesfiltros)>0){?>
            <h3 data-toggle="collapse" data-target="#collapse-<?= $filtro->id ?>"><?= h($filtro->nombre) ?></h3>
            <div id="collapse-<?= $filtro->id ?>" class="collapse in <?php if(isset($opciones['art'.$filtro->id])){ echo 'in'; } ?>">
              <ul class="fts">
                <?php $url = $query_params; unset($url[$filtro->nombre]); unset($url['art'.$filtro->id]); ?>
                <li style="border-bottom: 1px solid #b1afaf;"><a href="#" class="<?php if (!isset($opciones['art'.$filtro->id])) {echo "active";} ?> todas" data-url='<?php echo json_encode($url); ?>'>Todas</a></li>
                <?php foreach ($filtro->opcionesfiltros as $opcion) {?>
                <li><a class="filtro <?php if(isset($opciones['art'.$filtro->id]) && $opciones['art'.$filtro->id]==$opcion->id){echo "active";}?>" data-nombre="<?php echo $filtro->nombre; ?>" data-idnombre="<?php echo $filtro->id;?>" data-id="<?php echo $opcion->id; ?>" data-valor="<?php echo $opcion->nombre; ?>"><?php echo $opcion->nombre; ?></a></li>
                <?php } $i++;?>
              </ul>
            </div>
          <?php }} ?>


        </div>
      </div>
      <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
        
        <div id="listado_1">
         
          <div style="width: 100%;">
            <?= $this->fetch('selector_vista') ?>
          </div>



          <!-- <div class="orderby">
            <a class="odn" data-nombre="sort" data-valor="ASC" href="#"><span class="glyphicon glyphicon-chevron-up" style="color: #6b6b6b;"></span></a>
            <a class="odn" data-nombre="sort" data-valor="DESC" href="#"><span class="glyphicon glyphicon-chevron-down" style="color: #6b6b6b;"></span></a>
          </div>
          <hr>  -->
          
           <?= $this->fetch('lista') ?>




          <!-- <div id="loading"><img src="/img/350.GIF" alt=""></div> -->
        



        </div>




        <div class="detailbox">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?= strip_tags($categoria->descripcion) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"></div>
    </div>
  </div>
</div>
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

      $(document).on({click: function(e){
          
          var price_min = $(this).data('min');
          var price_max = $(this).data('max');

          params['precio'] = price_min+"-"+price_max;    
          window.location.href = base_url +'?'+$.param(params) + '#listado';

      }}, '.precio');
  
      $(document).on({click: function(e){
              
          var _this = $(this);
          var nombre = _this.data('nombre');
          var valor = _this.data('valor');
          var id = _this.data('id');
          var idNombre = _this.data('idnombre');

          if(nombre == 'marca'){  
              params[nombre] = valor; 
               window.location.href = base_url +'?'+$.param(params) + '#listado';
          }
          else{ 
              params['art'+idNombre] = id; 
              window.location.href = base_url +'?'+$.param(params) + '#listado';
          }

      }}, '.filtro');
  
      $(document).on({click: function(e){
              
          var _this = $(this);
          var url = _this.data('url');
          
          window.location.href = base_url +'?'+$.param(url) + '#listado';

      }}, '.todas');
  
      $(document).on({click: function(e){
             
          var _this = $(this);
          var nombre = _this.data('nombre');
          var valor = _this.data('valor');

              params[nombre] = valor; 
               window.location.href = base_url +'?'+$.param(params) + '#listado';

      }}, '.odn');

      if(params.sort != undefined){
        $('#sort').val(params.sort);
      }

      $(document).on({change: function(e){
             
          var _this = $(this);
          var nombre = 'sort';
          var valor = $(this).val();

              params[nombre] = valor; 
              window.location.href = base_url +'?'+$.param(params) + '#listado';

      }}, '#sort');
    
</script>