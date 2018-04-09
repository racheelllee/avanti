<div id="<?= $carousel_id ?>" class="owl-carousel owl-theme" style="margin-top:20px;">

<?php 

foreach ($all_productos as $key => $product) {
    
    if(isset($is_relacional)){
        $product = $product['producto'];
    }

    echo  '<div class="item">';

    if(isset($is_light) && $is_light){
      echo $this->element('producto_light', ['detalle_producto'=>$product, 'column_class'=>$column_class, 'is_whislist'=>( (isset($is_whislist))? $is_whislist : false), 'heightImg' => ( (isset($heightImg))? $heightImg : '250px' ) ]);
    }else{
      echo $this->element('producto', ['detalle_producto'=>$product, 'column_class'=>$column_class, 'is_whislist'=>( (isset($is_whislist))? $is_whislist : false), 'heightImg' => ( (isset($heightImg))? $heightImg : '250px' ) ]);
    }

    echo  '</div>';

} 
?>

</div>

<script type="text/javascript">
    $("#<?= $carousel_id ?>").owlCarousel({
         autoPlay: 3000, //Set AutoPlay to 3 seconds
         items : <?= $column ?>,   
         itemsCustom : [
       [0, 1],
       [320, 1],
       [480, 1],
       [768, <?= $column ?>],
       [1200, <?= $column ?>],
       [1400, <?= $column ?>],
       [1600, <?= $column ?>],
       [1920, <?= $column ?>]
      ],
       navigation : true, // Show next and prev buttons
       slideSpeed : 300,
       paginationSpeed : 400,

         navigationText: [
         "<img src='/img/left.png'>",
         "<img src='/img/right.png'>"
         ],
         pagination:false,
       });
</script>