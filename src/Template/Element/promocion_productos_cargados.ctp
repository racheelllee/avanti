<div class="col-md-12">
    <?php if(!empty($productos)) { ?>
        <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight" width="100%">
            <thead>
                <tr>
                    <th class="promociones-productos-table"><?php echo __('SKU'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Precio Regular'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Mostrar Precio Regular'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Precio de Promoción'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Mostrar Precio de Promoción'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Precio MSI'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Mostrar Precio MSI'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Cantidad de MSI'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Mostrar Cantidad de MSI'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Porcentaje de Descuento'); ?></th>
                    <th class="promociones-productos-table"><?php echo __('Mostra Porcentaje de Descuento'); ?></th>
                    <th style="width:20px;" class="promociones-productos-table"><?php echo __('Action'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $error = false;
                    foreach($productos as $producto) { if(isset($producto['result_upload'])){ $error = true; }

                        echo '<tr>';

                            echo '<td align="center">'.$producto['sku'].'</td>';
                            echo '<td align="center">$'.number_format($producto['precio'],2).'</td>';
                            echo '<td align="center">'.( ($producto['ver_precio'])? 'Si' : 'No' ).'</td>';
                            echo '<td align="center">$'.number_format($producto['precio_promocion'],2).'</td>';
                            echo '<td align="center">'.( ($producto['ver_precio_promocion'])? 'Si' : 'No' ).'</td>';
                            echo '<td align="center">$'.number_format($producto['precio_meses_sin_intereses'],2).'</td>';
                            echo '<td align="center">'.( ($producto['ver_precio_meses_sin_intereses'])? 'Si' : 'No' ).'</td>';
                            echo '<td align="center">'.$producto['meses_sin_intereses'].'</td>';
                            echo '<td align="center">'.( ($producto['ver_meses_sin_intereses'])? 'Si' : 'No' ).'</td>';
                            echo '<td align="center">'.$producto['porcentaje_descuento_promocion'].'</td>';
                            echo '<td align="center">'.( ($producto['ver_porcentaje_descuento_promocion'])? 'Si' : 'No' ).'</td>';

                            echo '<td align="center">';
                                    
                                if(empty($producto['result_upload'])){
                                    echo '<i class="fa fa-check btn btn-primary btn-xs"></i>';
                                }else{

                                    echo '<i data-container="body" data-html="true" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="'.$this->element('errors_popover', ['errors' => $producto['result_upload']] ).'" class="fa fa-times btn btn-danger btn-xs"></i>';
                                }

                            echo '</td>';
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
<div class="col-md-12" align="center">
    <?php 
       
        if(!$error){
            echo $this->Form->create(null, ['url'=>'/promociones/addProducts/'.$promocion->id]);

                echo $this->Form->input('promosFile', ['type'=>'hidden', 'value'=>$promosFile]);

                echo $this->Form->Submit(__('Finalizar'), ['div'=>false, 'class'=>'btn btn-span btn-md btn-submit']);

            echo $this->Form->end();
        } 

    ?>
    <br>
</div>