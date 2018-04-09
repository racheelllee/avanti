
<?php $this->Html->addCrumb($customer->title, ['controller' => 'Customers', 'action' => 'view/' . $customer->id, 'plugin' => 'Customers']); ?>

<?= $this->element('Customers.extra_css') ?>
<?= $this->element('Customers.extra_scripts') ?>
<div class="ibox" id="customers-view">
    <br>
    <div class="ibox-title clearfix">
        <div class="col-lg-12 clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <span>Nombre de la empresa: </span>
                <br>
                <span class="main-text-color big-font"><?= h($customer->title) ?></span>
                <br>
                <br>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span>Vendedor a cargo: </span>
                        <span class="main-text-color"><?= $customer->seller ? $customer->seller->full_name : ''?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span>Oficina: </span>
                        <span class="main-text-color"><?= $customer->office ? $customer->office->name : ''; ?></span>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span>Tipo de Cliente: </span>
                        <span class="main-text-color"><?= $customer->customer_category->name ?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span>Cliente desde: </span>
                        <span class="main-text-color"><?= $customer->customer_since ? $customer->customer_since->format(DATE_DISPLAY_FORMAT) : ''; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content no-padding">
        <div class="col-lg-12 clearfix">
            <div class="col-lg-4 top-bordered text-center">
                <br>
                <span class="indicator medium-font">MXN $<?= number_format(10650000, 0) ?></span>
                <br>
                <span class="main-text-color small-font">Total Cotizado en el Año</span>
                <br>
                &nbsp;
            </div>
            <div class="col-lg-4 top-bordered text-center left-bordered right-bordered">
                <br>
                <span class="indicator medium-font">MXN $<?= number_format(10650000, 0) ?></span>
                <br>
                <span class="main-text-color small-font">Total Cotizado en el Año</span>
                <br>
                &nbsp;
            </div>
            <div class="col-lg-4 top-bordered text-center">
                <br>
                <span class="indicator medium-font">MXN $<?= number_format(10650000, 0) ?></span>
                <br>
                <span class="main-text-color small-font">Total Total Cotizado en el Año</span>
                <br>
                &nbsp;
            </div>
        </div>
        <div class="col-lg-12 clearfix">
            <div class="col-lg-8 right-bordered top-bordered" style="min-height: 500px;">
                <div class="row">
                    <div class="col-lg-12 top-padded">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3">
                            <?php if($this->UserAuth->HP('Cotizaciones', 'add' )): ?>
                                <a
                                    class="btn btn-sm btn-primary"
                                    href="/cotizaciones/add/<?= $customer->id ?>"
                                    data-remote="false"
                                    style="position: absolute;z-index: 9;"
                                    data-toggle="modal"
                                    data-target="#genericModal">
                                    <?= __('Consulta por equipos') ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-12 no-padding">
                        <ul id="controlTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#info"  id="info-tab" role="tab" data-toggle="tab" aria-controls="info" aria-expanded="true">
                                    <?= __("Info") ?>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="info" aria-labelledBy="info-tab">
                                <?= $this->element('Customers/info'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 top-bordered">
                <div class="col-lg-12 padded">
                    <div class="col-lg-6 clearfix text-right">
                    </div>
                    <div class="col-lg-12 clearfix">
                        <p class="text-center">
                            <span>Directorio de la empresa</span>
                            <span>
                                <?php if($this->UserAuth->HP('Contacts', 'add', 'Customers')): ?>
                                    <a  href="/customers/contacts/add/<?= $customer->id ?>"
                                        class="medium-font ca-add"
                                        style="width: 30px;height: 30px;display: inline-block;position: relative;top: 10px;margin-left: 15px;"
                                        data-remote="false"
                                        data-toggle="modal"
                                        data-target="#genericModal">
                                    </a>
                                <?php endif ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-12 clearfix">
                    <?php foreach ($customer->contacts as $contact) : ?>
                        <div style="background-color: #ebebeb;padding: 10px; border-radius: 4px;">
                            <span style="font-size: 16px; color: #787878;">
                                <?= $contact->first_name ?>
                                <?= $contact->middle_name ?>
                                <?= $contact->last_name ?>
                            </span>
                            <span style="float: right; margin: 5px;">
                                <?php if($this->UserAuth->HP('Contacts', 'edit', 'Customers')): ?>
                                    <a  href="/customers/contacts/edit/<?= $contact->id ?>/<?= $customer->id ?>"
                                        data-remote="false" 
                                        data-toggle="modal" 
                                        data-target="#genericModal">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                <?php endif ?>
                            </span>
                            <span style="float: right; margin: 5px;">
                                <?php if($this->UserAuth->HP('Contacts', 'delete', 'Customers')): ?>
                                    <?=

                                        $this->Form->postLink(
                                            $this->Html->tag('i', '', array('class' => 'fa fa-trash-o')),
                                            [
                                                'controller' => 'contacts',
                                                'plugin' => 'Customers',
                                                'action' => 'delete',
                                                $contact->id
                                            ],
                                            [
                                                'escape' => false,
                                                'confirm' => __('¿Estas seguro de querer borrar este contacto?')
                                            ]
                                        )
                                    ?>
                                <?php endif ?>
                            </span>
                            <br>
                            <span style="font-size: 12px; color: #787878;">
                                <?= $contact->department ?>
                            </span>
                            <br>
                            <span style="font-size: 12px; color: #787878;">
                                <?= $contact->email ?>
                            </span>
                            <br>
                            <br>
                            <span style="font-size: 12px; color: #787878;">
                                <?= $contact->phone ?>
                                <?= $contact->phone_ext ? 'ext.' : ''; ?>
                                <?= $contact->phone_ext ?>
                            </span>
                            <br>
                            <span style="font-size: 12px; color: #787878;">
                                <?= $contact->mobile_phone ?>
                            </span>
                        </div>
                        <br>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?= $this->element('Customers.generic_modal') ?>
