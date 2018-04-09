  <div id="updatePromocionesIndex">
    <?php echo $this->Search->searchForm('Promociones', ['legend'=>false, 'updateDivId'=>'updatePromocionesIndex']); ?>
    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
        <thead>
            <tr>
                <th class="psorting"><?= $this->Paginator->sort('nombre') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('vigencia_inicio', 'Fecha Inicio') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('vigencia_fin', 'Fecha Fin') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('orden', 'Orden') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('status', 'Estatus')?></th>
                <th><?php echo __('Acciones');?></th>
            </tr>
        </thead>
        <tbody>
    <?php   if(!empty($promociones)) {
                $page = $this->request->params['paging']['Promociones']['page'];
                $limit = $this->request->params['paging']['Promociones']['perPage'];
                $i = ($page-1) * $limit;

         foreach ($promociones as $promocion): 
                    $i++;
            ?>
             <tr>
                <td><?= $promocion->nombre ?></td>
                <td><?= ( ($promocion->vigencia_inicio)? $promocion->vigencia_inicio->format('d/m/Y') : '' ) ?></td>
                <td><?= ( ($promocion->vigencia_fin)? $promocion->vigencia_fin->format('d/m/Y') : '' ) ?></td>

                <td>

                    <form method="post" accept-charset="utf-8" id="form_promocion" action="/promociones/edit/<?= $promocion->id?>/1">   
                    <div class="row">
            
                    <div class="col-lg-6">
                      <?= $this->Form->input('orden', array('label'=>'','value'=>$promocion->orden, 'style'=>'width: 100%;')); ?>
                    </div>

                    <div class="col-lg-6">

                      <?= $this->Form->button('<i class="fa fa-save"></i>'); ?>
                      <?= $this->Form->end(); ?>
                      
                    </div>

                    </div>
                </td>

                <td>
                <?php if($promocion->status){ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
                <?php }else{ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
                <?php } ?>
                </td>

                <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle dropdown-toggle btn-actions" data-toggle="dropdown"> Acciones <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">

                            <li><?= $this->Html->link(__('Descargar Productos'), '/promociones/productos/'.$promocion->id) ?></li>

                            <li><?= $this->Html->link(__('Editar Promoción'), ['action' => 'edit', $promocion->id]) ?></li>

                            <?php if($promocion->status) {
                                echo "<li>".$this->Form->postLink(__('Desactivar Promoción'), ['action'=>'setInactive', $promocion['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer desactivar este promoción?')])."</li>";
                            } else {
                                echo "<li>".$this->Form->postLink(__('Activar Promoción'), ['action'=>'setActive', $promocion['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer activar este promoción?')])."</li>";
                            }?>

                            <li><?= $this->Form->postLink(__('Borrar Promoción'), ['action' => 'delete', $promocion->id], ['confirm' => __('Esta seguro que desea borrar el promoción?')]) ?></li>
                            
                        </ul>
                    </div>
                </td>
        </tr>
    <?php endforeach; 

      } else {
            echo "<tr><td colspan=9><br/><br/>".__('No se encontraron resultados')."</td></tr>";
            } 
    ?>
    </tbody>
    </table>
    <?php if(!empty($promociones)) {
        echo $this->element('simple_pagination');
    } ?>
</div>
