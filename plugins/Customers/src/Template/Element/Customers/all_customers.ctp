<div class="table-reponsive customers" style="margin-top:10px;">
    <table id="customersTable" class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight collapsed">
        <thead>
            <tr>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('title', __('Title')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('business_name', __('Business Name')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('rfc', __('RFC')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('street', __('Street')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('number', __('Number')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('municipality', __('Municipality')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('state', __('State')) ?></th>
              <th style="min-width: 100px" scope="col" class="sorting-link"><?= $this->Paginator->sort('country', __('Country')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('postal_code', __('Postal Code')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('customer_status_id', __('Customer Status')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('customer_category_id', __('Customer Category')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('office_id', __('Office')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('customer_type_id', __('Customer Type')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('franquicia_id', __('Franquicia')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('customer_headcount_id', __('Customer Headcount')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('website', __('Website')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('customer_since', __('Cliente Desde')) ?></th>
              <th scope="col" class="sorting-link"><?= $this->Paginator->sort('seller', __('Seller')) ?></th>
              <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
              <td><?= h($customer->title) ?></td>
              <td><?= h($customer->business_name) ?></td>
              <td><?= h($customer->rfc) ?></td>
              <td><?= h($customer->street) ?></td>
              <td><?= h($customer->number) ?></td>
              <td><?= h($customer->municipality) ?></td>
              <td><?= h($customer->state) ?></td>
              <td><?= h($customer->country) ?></td>
              <td><?= h($customer->postal_code) ?></td>
              <td>
                <?php if ($customer->has('status')): ?>
                  <span class="label w-backgroud578EBE">
                    <?= $customer->status->name ?>
                  </span>
                <?php endif ?>
              </td>
              <td><?= $customer->customer_category ? $customer->customer_category->name : '' ?></td>
              <td><?= $customer->office ? $customer->office->name : '' ?></td>
              <td><?= $customer->customer_type ? $customer->customer_type->name : '' ?></td>
              <td><?= $customer->franquicia ? $customer->franquicia->name : '' ?></td>
              <td><?= $customer->customer_headcount ? $customer->customer_headcount->name : '' ?></td>
              <td><?= h($customer->website) ?></td>
              <td><?= $customer->customer_since ? $customer->customer_since->format(DATE_DISPLAY_FORMAT) : ''; ?></td>
              <td><?= $customer->seller ? $customer->seller->full_name : '' ?></td>
                  <td class="actions">
                    <div class='btn-group'>
                        <button class='btn dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' aria-expanded='false'>
                            <?= __('Acciones') ?>
                            <span class='caret'></span>
                        </button>
                        <ul class='dropdown-menu pull-right'>
                            <li>
                                <a 
                                    href="/customers/customers/edit/<?= $customer->id ?>" 
                                    data-remote="false" 
                                    data-toggle="modal" 
                                    data-target="#customersModal">
                                    <?= __('Editar Cliente') ?>
                                </a>
                            </li>
                            <li>
                                <a href="/customers/customers/view/<?= $customer->id ?>">
                                    <?= __('Ver Cliente') ?>
                                </a>
                            </li>
                            <li>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customer->id], ['confirm' => __('¿Realmente deseas borrar este cliente?', $customer->id)]) ?>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if(!empty($customers)) { ?>
      <?php echo $this->element('simple_pagination');?>
    <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#customersTable').DataTable({
            responsive: true,
            searching: false,
            bSort: false,
            bPaginate: false,
            oLanguage: window.oLanguage,
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
            ]
        });
    });
</script>
