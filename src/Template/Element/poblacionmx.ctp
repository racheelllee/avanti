
<div id="updatePoblacionmxIndex">

    <?php echo $this->Search->searchForm('Poblacionmx', ['legend'=>false, 'updateDivId'=>'updatePoblacionmxIndex']); ?>
    <?php echo $this->element('Usermgmt.paginator', ['updateDivId'=>'updatePoblacionmxIndex']); ?>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.id', __('Id')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.year', __('Año')); ?></th>
                
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.estado', __('Estado')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.poblacion', __('Población')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.hombres', __('Hombres')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.mujeres', __('Mujeres')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.nacimientos', __('Nacimientos')); ?></th>
                <th class="psorting"><?php echo $this->Paginator->sort('Poblacionmx.defunciones', __('Defunciones')); ?></th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?= $this->Number->format($registro->id) ?></td>
                <td><?= $this->Number->format($registro->year) ?></td>
                <td><?= h($registro->estado) ?></td>
                <td><?= $this->Number->format($registro->poblacion) ?></td>
                <td><?= $this->Number->format($registro->hombres) ?></td>
                <td><?= $this->Number->format($registro->mujeres) ?></td>
                <td><?= $this->Number->format($registro->nacimientos) ?></td>
                <td><?= $this->Number->format($registro->defunciones) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
