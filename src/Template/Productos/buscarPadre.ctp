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



        

<?php $this->end(); ?>



<div id="content">
  <div class="container">
    <div class="row">

      <div class="col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Inicio</a></li>
          <li><a href="#">Búsqueda</a></li>
        </ol>
      </div>

      <div class="col-xs-12">
        
        <div id="listado_1">
         
          <div style="width: 100%;">
            
            <div class="row options-section">
                <div class="col-md-12" style="padding: 0px;">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="btn-group">
                            <a id="grid" class="btn" href="/productos/buscar/<?= $this->request->data['data']['Producto']['buscar'] ?>">
                                <i class="fa fa-th-large" aria-hidden="true"></i>
                            </a>
                            <label class="form-label">Cuadricula</label>
                        </div>
                        <div class="btn-group">
                            <a id="list" class="btn" href="/productos/buscarlista/<?= $this->request->data['data']['Producto']['buscar'] ?>">
                                <i class="fa fa-list" aria-hidden="true"></i>
                            </a>
                            <label class="form-label">Lista</label>
                        </div>
                    </div>
                    
                </div>
            </div>


          </div>

            <div class="row">
                <div class="col-xs-12">
                <?= $this->fetch('lista') ?>
                </div>
            </div>

        </div>



      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"></div>
    </div>
  </div>
</div>






<script type="text/javascript">
    

    /*$(document).ready(function() {
     
        
        // Initialize navgoco with default options
            
        $("#demo1").navgoco({
            caretHtml: '',
            accordion: false,
            openClass: 'open',
            save: true,
            cookie: {
                name: 'navgoco',
                expires: false,
                path: '/'
            },
            slide: {
                duration: 400,
                easing: 'swing'
            },
            // Add Active class to clicked menu item
            onClickAfter: active_menu_cb,
        });

        $("#nav_2 a.menu_res").click(function (e) {
            e.preventDefault();
            $("#nav_2 ul").slideToggle(300);
            $("#nav_2 ul").addClass("done");
        });


        var $container = $('#posts-list');
     
        $container.infinitescroll({
          navSelector  : '.next',    // selector for the paged navigation 
          nextSelector : '.next a',  // selector for the NEXT link (to page 2)
          itemSelector : '.post-item',     // selector for all items you'll retrieve
          debug         : true,
          dataType      : 'html',
          loading: {
              finishedMsg: '',
              img: '/img/350.GIF'
            }
          }
        );

    });*/

    
</script>