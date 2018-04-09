 <div id="updateCategoriasIndex">
    <?php echo $this->Search->searchForm('Categorias', ['legend'=>false, 'updateDivId'=>'updateCategoriasIndex']); ?>
    <?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateCategoriasIndex']); ?>
    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
        <thead>
            <tr>
              <th class="psorting"><?= $this->Paginator->sort('nombre') ?></th>
              <th class="psorting"><?= $this->Paginator->sort('url') ?></th>
              <th class="psorting"><?= $this->Paginator->sort('categoria_id','Padre') ?></th>
              <th class="psorting"><?= $this->Paginator->sort('orden') ?></th>
              <th class="psorting"><?= $this->Paginator->sort('publicado', 'Estatus') ?></th>
              <th><?php echo __('Acciones'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php   if(!empty($categorias)) {

            foreach ($categorias as $categoria): 
                    
        ?>
             <tr>
            
            <td><?= h($categoria->nombre) ?></td>
            <td><?= h($categoria->url) ?></td>
            <td><?= $categoria->padre->nombre ?></td>
            
            <td>

            <form method="post" accept-charset="utf-8" id="form_Categoria" action="/categorias/edit/<?= $categoria->id?>/1">   
                <div class="row">
        
                <div class="col-lg-6">
                  <?= $this->Form->input('orden', array('label'=>'','value'=>$categoria->orden)); ?>
                </div>

                <div class="col-lg-6">

                  <?= $this->Form->button('<i class="fa fa-save"></i>'); ?>
                  <?= $this->Form->end(); ?>
                  
                </div>

                </div>
            </td>
            
            <td align="center">
                <?php if($categoria->publicado){ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
                <?php }else{ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
                <?php } ?>
            </td>
            
            <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle dropdown-toggle btn-actions" data-toggle="dropdown"> Acciones <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">

                            <?php if($categoria->publicado) {
                                echo "<li>".$this->Form->postLink(__('Desactivar Categoría'), ['action'=>'setInactive', $categoria['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer desactivar este categoría?')])."</li>";
                            } else {
                                echo "<li>".$this->Form->postLink(__('Activar Categoría'), ['action'=>'setActive', $categoria['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer activar este categoría?')])."</li>";
                            }?>

                            <li> <?= $this->Html->link(__('Editar Categoría'), ['action' => 'edit', $categoria->id]) ?></li>
        
                            <li><?= $this->Form->postLink(__('Borrar Categoría'), ['action' => 'delete', $categoria->id], ['confirm' => __('Esta seguro que desea borrar la categoría?')]) ?></li>
                            
                        </ul>
                    </div>
            </td>
        </tr>

    <?php endforeach; 

      } else {
            echo "<tr><td colspan=7><br/><br/>".__('No se encontraron resultados')."</td></tr>";
            } 
    ?>
    </tbody>
    </table>
    <?php if(!empty($categorias)) {
        echo $this->element('simple_pagination');
    } ?>
</div>
