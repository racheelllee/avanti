<div id="updateOrdenesIndex" class="table-responsive">
	<?php echo $this->Search->searchForm('Customers', ['legend'=>false, 'updateDivId'=>'updateOrdenesIndex']); ?>
	<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
			<tr>
					<th><?php echo $this->Paginator->sort('Customers.id', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.title', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.first_name', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.last_name', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.RFC', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.user_id', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.customer_type_id', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.modified', __('$column')); ?> </th>
					<th><?php echo $this->Paginator->sort('Customers.created', __('$column')); ?> </th>
				<?php if( $this->UserAuth->HP('Customers', 'delete')) { ?>
					<th class="actions">Acciones</th>    
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($customers as $customer): ?>
				<tr>
						<td><?= $customer->id ?> </td>
						<td><?= $customer->title ?> </td>
						<td><?= $customer->first_name ?> </td>
						<td><?= $customer->last_name ?> </td>
						<td><?= $customer->RFC ?> </td>
						<td><?= $customer->user_id ?> </td>
						<td><?= $customer->customer_type_id ?> </td>
						<td><?= $customer->modified ?> </td>
						<td><?= $customer->created ?> </td>
                     <?php if( $this->UserAuth->HP('Customers', 'delete')) : ?>          
                        <td class="actions col-sm-1">
                            <div class="dropdown pull-right">
                                <?= 
                                    $this->Form->postLink(
                                        '<div class="btn  btn-default "><i class="fa fa-trash"></i></div> ', 
                                        [
                                            'action' => 'delete', 
                                            $customer->id
                                        ], 
                                        [
                                            'confirm' => __('Seguro que quiere borrar # {0}?', $customer->id), 
                                            'title'   => __('Delete'), 
                                            "escape"  => false
                                        ]
                                    ) 
                                ?>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Next') . ' >') ?>
        </ul>
    </div>
</div>