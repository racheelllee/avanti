  <div id="updateSucursalesIndex">
    <?php echo $this->Search->searchForm('Sucursales', ['legend'=>false, 'updateDivId'=>'updateSucursalesIndex']); ?>
    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
        <thead>
            <tr>
                <th class="psorting"><?= $this->Paginator->sort('name', 'Nombre') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('direccion', 'Dirección') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('telefono', 'Teléfonos') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('horario', 'Horario') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('activo', 'Estatus') ?></th>
                <th><?php echo __('Acciones');?></th>
            </tr>
        </thead>
        <tbody>
    <?php   if(!empty($sucursales)) {
                $page = $this->request->params['paging']['Sucursales']['page'];
                $limit = $this->request->params['paging']['Sucursales']['perPage'];
                $i = ($page-1) * $limit;

         foreach ($sucursales as $sucursal): 
                    $i++;
            ?>
             <tr>
                <td><?= h($sucursal->name) ?></td>
                <td><?= h($sucursal->direccion) ?></td>
                <td><?= h($sucursal->telefono) ?></td>
                <td><?= h($sucursal->horario) ?></td>
               
                <td>
                <?php if($sucursal->activo){ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
                <?php }else{ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
                <?php } ?>
                </td>

                <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle dropdown-toggle btn-actions" data-toggle="dropdown"> Acciones <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">

                            <li><?= $this->Html->link(__('Editar Sucursal'), ['action' => 'edit', $sucursal->id]) ?></li>

                            <?php if($sucursal->activo) {
                                echo "<li>".$this->Form->postLink(__('Desactivar Sucursal'), ['action'=>'setInactive', $sucursal->id], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer desactivar esta sucursal?')])."</li>";
                            } else {
                                echo "<li>".$this->Form->postLink(__('Activar Sucursal'), ['action'=>'setActive', $sucursal->id], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer activar esta sucursal?')])."</li>";
                            }?>
                            
                            <li><?= $this->Form->postLink(__('Borrar Sucursal'), ['action' => 'delete', $sucursal->id], ['confirm' => __('Esta seguro que desea borrar la sucursal?')]) ?></li>
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
    <?php if(!empty($sucursales)) {
        echo $this->element('simple_pagination');
    } ?>
</div>