<div class="row">
    <div class="col-xs-6 w-title w-color666">
      <h3 style="margin-top:30px;"><?php echo __('List of Contacts');?></h3>
    </div>
    <div class="col-xs-6">
        <a 
            class="btn btn-default w-AvenirLight w-btnNewUsers"
            href="/contacts/add" 
            data-remote="false" 
            data-toggle="modal" 
            data-target="#contactsModal">
            <?= __('New contact') ?>
        </a>
    </div>
</div>
<div class="table-reponsive contacts" style="margin-top:10px;">
    <table id="contactsTable" class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight collapsed">
        <thead>
            <tr>
                        <th scope="col"><?= $this->Paginator->sort('provider_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('middle_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('department') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('phone_ext') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('mobile_phone') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('street') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('number') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('colony') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('municipality') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('country') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('postal_code') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
            <td><?= $this->Number->format($contact->provider_id) ?></td>
            <td><?= h($contact->first_name) ?></td>
            <td><?= h($contact->middle_name) ?></td>
            <td><?= h($contact->last_name) ?></td>
            <td><?= h($contact->department) ?></td>
            <td><?= h($contact->email) ?></td>
            <td><?= h($contact->phone) ?></td>
            <td><?= h($contact->phone_ext) ?></td>
            <td><?= h($contact->mobile_phone) ?></td>
            <td><?= h($contact->street) ?></td>
            <td><?= $this->Number->format($contact->number) ?></td>
            <td><?= h($contact->colony) ?></td>
            <td><?= h($contact->municipality) ?></td>
            <td><?= h($contact->country) ?></td>
            <td><?= h($contact->postal_code) ?></td>
                <td class="actions">
                    <div class='btn-group'>
                        <button 
                                class='btn w-btnBorder578EBE btn-xs btn-outline dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' 
                                aria-expanded='false'>
                            <?= __('Actions') ?>
                            <span class='caret'></span>
                        </button>
                        <ul class='dropdown-menu pull-right'>
                            <li>
                                <!--a href="#" data-toggle="modal" data-target="#contactsModal<?=$contact->id?>">
                                    <?= __('Edit') ?>
                                </a-->
                                <a 
                                    href="/contacts/edit/<?= $contact->id ?>" 
                                    data-remote="false" 
                                    data-toggle="modal" 
                                    data-target="#contactsModal">
                                    <?= __('Edit contact') ?>
                                </a>
                            </li>
                            <li>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id)]) ?>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#contactsTable').DataTable({
            responsive: true,
            searching: false,
            bSort: false,
            bPaginate: false,
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
            ]
        });
    });
</script>
<div class="modal fade" id="contactsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<div id="loader-content" style="display: none;">
    <p style="text-align: center;">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </p>
</div>
<script type="text/javascript">
  $("#contactsModal").on("show.bs.modal", function(e) {
        $(this).find(".modal-body").html($('#loader-content').html());
        var link = $(e.relatedTarget);
        $(this).find(".modal-body").load(link.attr("href"));
  });
</script>
