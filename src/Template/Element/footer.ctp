<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <ul class="ccv">
                    <li>
                        <div class="block_1">
                            <h3>NOSOTROS</h3>
                            <ul>
                                <li><a href="/info/historia">Historia</a></li>
                                <li><a href="/info/filosofia">Filosofía</li>
                                <li><a href="/info/politicas-de-calidad">Politicas de calidad</a></li>
                                <li><a href="/info/bolsa-de-trabajo">Bolsa de trabajo</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <ul class="ccv">
                    <li>
                        <div class="block_1">
                            <h3>SERVICIOS</h3>
                            <ul>
                                <li><a href="#"></a></li>
                                <li><a href="/info/entrega-a-domicilio">Entrega a domicilio</a></li>
                                <li><a href="/info/asesorias-en-decoracion">Asesorías en decoración</a></li>
                                <li><a href="/formas-de-pago">Formas de pago</a></li>
                                <li><a href="/info/garantías">Garantías</a></li>
                                <li><a href="/info/politicas">Políticas</a></li>
                                <li><a href="/info/preguntas-frecuentes">Preguntas frecuentes</a></li>

                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <ul class="ccv">
                    <li>
                        <div class="block_1">
                            <h3>PRODUCTOS</h3>
                            <ul>
                                <?php foreach ($categorias as $key => $row) {
                                    if($row['publicado']){
                                        echo '<li><a href="/sc/'.$row['url'].'">'.$row['nombre'].'</a></li>';
                                    }
                                } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                <ul class="ccv">
                    <li>
                        <div class="block_1">
                            <h3>CONTACTO</h3>
                            <div class="col-md-12" style="padding-left: 0px; margin-top: 10px;">
                                <?php echo $this->Html->image('/img/msg.png', ['alt' => 'Wishlist', 'width'=> 30, 'class' => 'img-responsive', 'style' => 'margin-top: 5px;']); ?>
                                <span style="position: relative;margin-left: 50px;top: -20px;">info@avanti.com</span>
                            </div>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <?php echo $this->Html->image('/img/phone.png', ['alt' => 'Wishlist', 'width'=> 30, 'class' => 'img-responsive', 'style' => 'margin-top: 5px;']); ?>
                                <span style="position: relative;margin-left: 50px;top: -20px;">1 888 428 3789</span>
                            </div>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <?php echo $this->Html->image('/img/cs.png', ['alt' => 'Wishlist', 'width'=> 30, 'class' => 'img-responsive', 'style' => 'margin-top: 5px;']); ?>
                                <span style="position: relative;margin-left: 50px;top: -20px;">Lunes a Sábado 8am- 7pm</span>
                            </div>
                            
                            <div class="col-md-12" style="padding-left: 0px;">
                                <ul class="social_foot">
                                    <li> <a href="https://www.facebook.com/mueblesavanti/" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i> </a> </li>
                                    <li> <a href="https://www.instagram.com/avantimuebles/" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i> </a> </li>
                                    <li> <a href="https://www.youtube.com/channel/UCZyYc9IXMUMqPd8HYHyd2zg?view_as=subscriber" target="_blank"> <i class="fa fa-youtube" aria-hidden="true"></i> </a> </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>  


    