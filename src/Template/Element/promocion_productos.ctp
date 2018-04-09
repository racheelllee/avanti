<div class="col-md-12">
    <?php if(!empty($promocion_productos)) { ?>
        <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight" width="100%">
            <thead>
                <tr>
                    <th><?php echo __('SKU'); ?></th>
                    <th><?php echo __('Precio Regular'); ?></th>
                    <th><?php echo __('Mostrar Precio Regular'); ?></th>
                    <th><?php echo __('Precio de Promoción'); ?></th>
                    <th><?php echo __('Mostrar Precio de Promoción'); ?></th>
                    <th><?php echo __('Precio MSI'); ?></th>
                    <th><?php echo __('Mostrar Precio MSI'); ?></th>
                    <th><?php echo __('Cantidad de MSI'); ?></th>
                    <th><?php echo __('Mostrar Cantidad de MSI'); ?></th>
                    <th><?php echo __('Porcentaje de Descuento'); ?></th>
                    <th><?php echo __('Mostra Porcentaje de Descuento'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $error = false;
                    foreach($promocion_productos as $producto) { if(isset($producto['result_upload'])){ $error = true; }

                        echo '<tr>';

                            echo '<td>'.$producto['sku'].'</td>';
                            echo '<td>$'.number_format($producto['precio'],2).'</td>';
                            echo '<td>'.( ($producto['ver_precio'])? 'Si' : 'No' ).'</td>';
                            echo '<td>$'.number_format($producto['precio_promocion'],2).'</td>';
                            echo '<td>'.( ($producto['ver_precio_promocion'])? 'Si' : 'No' ).'</td>';
                            echo '<td>$'.number_format($producto['precio_meses_sin_intereses'],2).'</td>';
                            echo '<td>'.( ($producto['ver_precio_meses_sin_intereses'])? 'Si' : 'No' ).'</td>';
                            echo '<td>'.$producto['meses_sin_intereses'].'</td>';
                            echo '<td>'.( ($producto['ver_meses_sin_intereses'])? 'Si' : 'No' ).'</td>';
                            echo '<td>'.$producto['porcentaje_descuento_promocion'].'</td>';
                            echo '<td>'.( ($producto['ver_porcentaje_descuento_promocion'])? 'Si' : 'No' ).'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>

        <?php } else {
            $error = true;
            echo "<p align='center'><br/><br/>".__('No Records Available')."</p>";
        } ?>
</div>