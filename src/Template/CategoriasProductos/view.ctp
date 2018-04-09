<?php
//$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar Categoria'), ['action' => 'edit', $categoria->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar Categoria'), ['action' => 'delete', $categoria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoria->id)]) ?> </li>
    <li><?= $this->Html->link(__('Listar Categorias'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo Categoria'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Listar Cupones'), ['controller' => 'Cupones', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Cupon'), ['controller' => 'Cupones', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Filtros'), ['controller' => 'Filtros', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Filtro'), ['controller' => 'Filtros', 'action' => 'add']) ?> </li>
                    <li><?= $this->Html->link(__('Listar Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
                </ul>
<?php $this->end(); ?>

<h2><?= h($categoria->nombre) ?></h2>
<div class="row">
        <div class="col-lg-5">
                                    <h6><?= __('Nombre') ?></h6>
                    <p><?= h($categoria->nombre) ?></p>
                                                    <h6><?= __('Meta Titulo') ?></h6>
                    <p><?= h($categoria->meta_titulo) ?></p>
                                                    <h6><?= __('Url') ?></h6>
                    <p><?= h($categoria->url) ?></p>
                                                    <h6><?= __('Banner') ?></h6>
                    <p><?= h($categoria->banner) ?></p>
                                                    <h6><?= __('Imagen Fondo') ?></h6>
                    <p><?= h($categoria->imagen_fondo) ?></p>
                                </div>
            <div class="col-lg-2">
                    <h6><?= __('Id') ?></h6>
                <p><?= $this->Number->format($categoria->id) ?></p>
                    <h6><?= __('Categoria Id') ?></h6>
                <p><?= $this->Number->format($categoria->categoria_id) ?></p>
                    <h6><?= __('Orden') ?></h6>
                <p><?= $this->Number->format($categoria->orden) ?></p>
                </div>
            </div>
    <div class="row texts">
            <div class="col-lg-9">
                <h6><?= __('Descripcion') ?></h6>
                <?= $this->Text->autoParagraph(h($categoria->descripcion)); ?>
            </div>
        </div>
    <div class="row texts">
            <div class="col-lg-9">
                <h6><?= __('Meta Descripcion') ?></h6>
                <?= $this->Text->autoParagraph(h($categoria->meta_descripcion)); ?>
            </div>
        </div>
    <div class="row texts">
            <div class="col-lg-9">
                <h6><?= __('Meta Keywords') ?></h6>
                <?= $this->Text->autoParagraph(h($categoria->meta_keywords)); ?>
            </div>
        </div>
    <ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#Cupones" id="Cupones-tab" role="tab" data-toggle="tab" aria-controls="Cupones" aria-expanded="true">Cupones</a>
      </li>
          <li role="presentation" class="">
        <a href="#Filtros" id="Filtros-tab" role="tab" data-toggle="tab" aria-controls="Filtros" aria-expanded="true">Filtros</a>
      </li>
          <li role="presentation" class="">
        <a href="#Productos" id="Productos-tab" role="tab" data-toggle="tab" aria-controls="Productos" aria-expanded="true">Productos</a>
      </li>
         
</ul>

<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="Cupones" aria-labelledBy="Cupones-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($categoria->cupones)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Id') ?></th>
                                            <th><?= __('Nombre') ?></th>
                                            <th><?= __('Codigo') ?></th>
                                            <th><?= __('Cliente Id') ?></th>
                                            <th><?= __('Monto') ?></th>
                                            <th><?= __('Porcentaje') ?></th>
                                            <th><?= __('Fecha Inicio') ?></th>
                                            <th><?= __('Fecha Fin') ?></th>
                                            <th><?= __('Categoria Id') ?></th>
                                            <th><?= __('Marca Id') ?></th>
                                            <th><?= __('Producto Id') ?></th>
                                            <th><?= __('Cantidad') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoria->cupones as $cupones): ?>
                    <tr>
                                            <td><?= h($cupones->id) ?></td>
                                            <td><?= h($cupones->nombre) ?></td>
                                            <td><?= h($cupones->codigo) ?></td>
                                            <td><?= h($cupones->cliente_id) ?></td>
                                            <td><?= h($cupones->monto) ?></td>
                                            <td><?= h($cupones->porcentaje) ?></td>
                                            <td><?= h($cupones->fecha_inicio) ?></td>
                                            <td><?= h($cupones->fecha_fin) ?></td>
                                            <td><?= h($cupones->categoria_id) ?></td>
                                            <td><?= h($cupones->marca_id) ?></td>
                                            <td><?= h($cupones->producto_id) ?></td>
                                            <td><?= h($cupones->cantidad) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Cupones', 'action' => 'view', $cupones->id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'Cupones', 'action' => 'edit', $cupones->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'Cupones', 'action' => 'delete', $cupones->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cupones->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen Cupones asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane fade in " id="Filtros" aria-labelledBy="Filtros-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($categoria->filtros)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Id') ?></th>
                                            <th><?= __('Nombre') ?></th>
                                            <th><?= __('Categoria Id') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoria->filtros as $filtros): ?>
                    <tr>
                                            <td><?= h($filtros->id) ?></td>
                                            <td><?= h($filtros->nombre) ?></td>
                                            <td><?= h($filtros->categoria_id) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Filtros', 'action' => 'view', $filtros->id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'Filtros', 'action' => 'edit', $filtros->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'Filtros', 'action' => 'delete', $filtros->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filtros->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen Filtros asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane fade in " id="Productos" aria-labelledBy="Productos-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($categoria->productos)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?= __('Id') ?></th>
                                            <th><?= __('Usuario Id') ?></th>
                                            <th><?= __('Proveedor Id') ?></th>
                                            <th><?= __('Sku') ?></th>
                                            <th><?= __('Codigo Fabricante') ?></th>
                                            <th><?= __('Nombre') ?></th>
                                            <th><?= __('Arugemnto De Venta') ?></th>
                                            <th><?= __('Descripcion') ?></th>
                                            <th><?= __('Ficha Tecnica') ?></th>
                                            <th><?= __('Marca Id') ?></th>
                                            <th><?= __('Modelo') ?></th>
                                            <th><?= __('Activo') ?></th>
                                            <th><?= __('Fecha Publicacion') ?></th>
                                            <th><?= __('Url') ?></th>
                                            <th><?= __('Meta Titulo') ?></th>
                                            <th><?= __('Meta Descripcion') ?></th>
                                            <th><?= __('Meta Keywords') ?></th>
                                            <th><?= __('Largo') ?></th>
                                            <th><?= __('Ancho') ?></th>
                                            <th><?= __('Alto') ?></th>
                                            <th><?= __('Peso') ?></th>
                                            <th><?= __('Peso Volumetrico') ?></th>
                                            <th><?= __('Costo') ?></th>
                                            <th><?= __('Margen') ?></th>
                                            <th><?= __('Precio') ?></th>
                                            <th><?= __('Envio Gratis') ?></th>
                                            <th><?= __('Grantia') ?></th>
                                            <th><?= __('Tiempo De Entrega') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoria->productos as $productos): ?>
                    <tr>
                                            <td><?= h($productos->id) ?></td>
                                            <td><?= h($productos->usuario_id) ?></td>
                                            <td><?= h($productos->proveedor_id) ?></td>
                                            <td><?= h($productos->sku) ?></td>
                                            <td><?= h($productos->codigo_fabricante) ?></td>
                                            <td><?= h($productos->nombre) ?></td>
                                            <td><?= h($productos->arugemnto_de_venta) ?></td>
                                            <td><?= h($productos->descripcion) ?></td>
                                            <td><?= h($productos->ficha_tecnica) ?></td>
                                            <td><?= h($productos->marca_id) ?></td>
                                            <td><?= h($productos->modelo) ?></td>
                                            <td><?= h($productos->activo) ?></td>
                                            <td><?= h($productos->fecha_publicacion) ?></td>
                                            <td><?= h($productos->url) ?></td>
                                            <td><?= h($productos->meta_titulo) ?></td>
                                            <td><?= h($productos->meta_descripcion) ?></td>
                                            <td><?= h($productos->meta_keywords) ?></td>
                                            <td><?= h($productos->largo) ?></td>
                                            <td><?= h($productos->ancho) ?></td>
                                            <td><?= h($productos->alto) ?></td>
                                            <td><?= h($productos->peso) ?></td>
                                            <td><?= h($productos->peso_volumetrico) ?></td>
                                            <td><?= h($productos->costo) ?></td>
                                            <td><?= h($productos->margen) ?></td>
                                            <td><?= h($productos->precio) ?></td>
                                            <td><?= h($productos->envio_gratis) ?></td>
                                            <td><?= h($productos->grantia) ?></td>
                                            <td><?= h($productos->tiempo_de_entrega) ?></td>
                                                                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Productos', 'action' => 'view', $productos->id],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => 'Productos', 'action' => 'edit', $productos->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => 'Productos', 'action' => 'delete', $productos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productos->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen Productos asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
</div>

