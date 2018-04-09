<div id="<?= $carousel_id ?>" class="carousel slide" data-ride="carousel">
    
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

    <a class="left carousel-control" href="#<?= $carousel_id ?>" data-slide="prev">
      <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#<?= $carousel_id ?>" data-slide="next">
      <span class="icon-next"></span>
    </a>

</div>