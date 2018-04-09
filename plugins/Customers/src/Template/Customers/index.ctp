
<?php $this->Html->addCrumb(__('Listado de Clientes'), ['controller' => 'Customers', 'action' => 'index', 'plugin' => 'Customers']); ?>

<?= $this->element('Customers.extra_css') ?>

<?= $this->element('Customers.extra_scripts') ?>

<?= $this->element('Customers.Customers/index_header') ?>

<?= $this->Search->searchForm('Customers', ['legend'=>false, 'updateDivId' => 'updateCustomersIndex']); ?>

<div id="updateCustomersIndex"><?= $this->element('Customers.Customers/all_customers') ?></div>


<?= $this->element('Customers.Customers/modal') ?>
