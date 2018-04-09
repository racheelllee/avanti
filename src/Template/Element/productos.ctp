<div id="products" class="col-md-12 list-group">
    <?php if(!empty($productos)): ?>
        <?php foreach ($productos as $key => $row): ?>
            <div class="item col-lg-4 col-md-4 col-sm-4 col-sx-12">
                <div class="thumbnail">
                    <?php echo $this->Html->image('../productos/'.$row["image"].'', ['width' => '400px', 'height' => '250px', 'class' => 'group list-group-image']); ?>
                    <div class="caption">
                       <div class="box-description">
                            <span><?= $row['nombre'] ?></span>
                            <p class="price-old">MXN $<?= number_format($row['precio'], 2) ?></p>
                            <p class="price-new">MXN $<?= number_format($row['precio_promocion'], 2) ?></p>
                        </div>
                        <div class="box-price">
                            <?php echo $this->Html->image('image-price.png', ['width' => '70px', 'height' =>'70px' ]); ?>
                            <span>$<?= number_format($row['monto_interes'], 2) ?></span>
                            <p>A 12 MESES SIN INTERESES</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <div class="col-md-12 empty-products">No se encontró ningún producto</div>
    <?php endif ?>
</div>