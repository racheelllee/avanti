  <div id="updateBannersIndex">
    <?php echo $this->Search->searchForm('Banners', ['legend'=>false, 'updateDivId'=>'updateBannersIndex']); ?>
    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
        <thead>
            <tr>
                <th class="psorting"><?= $this->Paginator->sort('nombre') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('principal', 'Posición') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('url', 'URL') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('vigencia_inicio', 'Vigencia Inicio') ?></th>
                <th class="psorting"><?= $this->Paginator->sort('vigencia_fin', 'Vigencia Fin')?></th>
                <th class="psorting"><?= $this->Paginator->sort('orden', 'Orden')?></th>
                <th class="psorting"><?= $this->Paginator->sort('status', 'Estatus')?></th>
                <th class="psorting"><?= $this->Paginator->sort('imagen', 'Imagen')?></th>
                <th><?php echo __('Acciones');?></th>
            </tr>
        </thead>
        <tbody>
    <?php   if(!empty($banners)) {
                $page = $this->request->params['paging']['Banners']['page'];
                $limit = $this->request->params['paging']['Banners']['perPage'];
                $i = ($page-1) * $limit;

         foreach ($banners as $banner): 
                    $i++;
            ?>
             <tr>
                <td><?= h($banner->nombre) ?></td>
                <td><?= $banner->banners_tipo->name ?> </td>

                <td><?= h($banner->url) ?></td>
                <td><?= ($banner->vigencia_inicio)? $banner->vigencia_inicio->format('d/m/Y') : '' ?></td>
                <td><?= ($banner->vigencia_fin)? $banner->vigencia_fin->format('d/m/Y') : '' ?></td>
                <td>
                    <form method="post" accept-charset="utf-8" id="form_Categoria" action="/banners/edit/<?= $banner->id?>/1">   
                        <div class="row">
                            <div class="col-lg-6">
                              <?= $this->Form->input('orden', array('label'=>'','value'=>$banner->orden, 'style'=>'width: 100%;')); ?>
                            </div>

                            <div class="col-lg-6">
                              <?= $this->Form->button('<i class="fa fa-save"></i>'); ?>
                            </div>
                        </div>
                    </form>
                </td>
                
                <td>
                <?php if($banner->vigencia_inicio && $banner->vigencia_fin && (date('Y-m-d') >= $banner->vigencia_inicio->format('Y-m-d') && date('Y-m-d') <= $banner->vigencia_fin->format('Y-m-d'))){ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#009688 !important;">Activo</span>
                <?php }else{ ?>
                    <span class="label w-backgroud578EBE" style="background-color:#C49F47 !important;">Inactivo</span>
                <?php } ?>
                </td>

                <td>
                     <a class="btn dropdown-toggle dropdown-toggle btn-actions" href="/<?php echo $banner->imagen; ?>" target="_blank"> <i class="fa fa-eye"></i> </a>
                </td>

                <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle dropdown-toggle btn-actions" data-toggle="dropdown"> Acciones <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">

                            <li><?= $this->Html->link(__('Editar Banner'), ['action' => 'edit', $banner->id]) ?></li>
                            <li><?= $this->Form->postLink(__('Borrar Banner'), ['action' => 'delete', $banner->id], ['confirm' => __('Esta seguro que desea borrar el banner?')]) ?></li>
                            
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
    <?php if(!empty($banners)) {
        echo $this->element('simple_pagination');
    } ?>
</div>

<?= $this->element('modalURL'); ?>
