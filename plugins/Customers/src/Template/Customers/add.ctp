<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title"><?= __('Agregar Cliente') ?></h4>
</div>
    <?= $this->Form->create($customer, [
      'url' => "/customers/customers/add/{$customer->id}",
      'class' => 'ca-form form-horizontal',
      'data-parsley-validate',
      'enctype' => 'multipart/form-data',
      'id' => 'save-customers',
    ]) ?>
  <?= $this->element('Customers.Customers/form'); ?>
<?= $this->Form->end() ?>
