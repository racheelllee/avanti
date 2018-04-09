  <div id="updateSeccionesIndex">
    <?php echo $this->Search->searchForm('Secciones', ['legend'=>false, 'updateDivId'=>'updateSeccionesIndex']); ?>
    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
        <thead>
            <tr>
                <th class="psorting"><?= $this->Paginator->sort('nombre') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('', 'Estilo') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('status', 'Estatus')?></th>
                <th><?php echo __('Acciones');?></th>
            </tr>
        </thead>
        <tbody>
    <?php   if(!empty($secciones)) {
                $page = $this->request->params['paging']['Secciones']['page'];
                $limit = $this->request->params['paging']['Secciones']['perPage'];
                $i = ($page-1) * $limit;

         foreach ($secciones as $seccion): 
                    $i++;
            ?>
             <tr>
                <td><?= h($seccion->nombre) ?></td>
                <td>
                <span class="label w-backgroud578EBE" style="border-radius: 0px; background-color:<?= ($seccion->nombre_background)? $seccion->nombre_background : 'white' ?> !important; color:<?= ($seccion->nombre_color)? $seccion->nombre_color : 'white' ?> !important;">Título Sección</span>
                </td>

                <td>
                <?php if($seccion->status){ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
                <?php }else{ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
                <?php } ?>
                </td>

                <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle dropdown-toggle btn-actions" data-toggle="dropdown"> Acciones <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">

                            <li><?= $this->Html->link(__('Editar Sección'), ['action' => 'edit', $seccion->id]) ?></li>

                            <?php if($seccion->status) {
                                echo "<li>".$this->Form->postLink(__('Desactivar Sección'), ['action'=>'setInactive', $seccion->id], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer desactivar este seccion?')])."</li>";
                            } else {
                                echo "<li>".$this->Form->postLink(__('Activar Sección'), ['action'=>'setActive', $seccion->id], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer activar este seccion?')])."</li>";
                            }?>
                            
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
    <?php if(!empty($secciones)) {
        echo $this->element('simple_pagination');
    } ?>
</div>