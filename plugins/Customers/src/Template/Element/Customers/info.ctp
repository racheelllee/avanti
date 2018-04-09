<br>
<style type="text/css">
    .info-table td,
    .info-table,
    .info-title
    {
        font-family: 'Helvetica';
    }
    .info-title{
        width: 100%;
    }
    .info-table{}
    .info-table .bold{
        text-align: left;
        padding-top: 10px;
        font-weight: bold;
    }
    .info-table .data{
        padding-top: 10px;
        padding-left: 20px;
    }
    .info-table{
        /*margin-left: auto;*/
        /*margin-right: auto;*/
    }
    .info-table .bold{
        font-weight: bold;
    }
    .info-table .data{
        font-style: italic;
    }
</style>
<table class="info-table">
    <tr>
        <td class="bold"><?=__('Title') ?>:</td>
        <td class="data"><?= h($customer->title) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Business Name') ?>:</td>
        <td class="data"><?= h($customer->business_name) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Street') ?>:</td>
        <td class="data"><?= h($customer->street) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Number') ?>:</td>
        <td class="data"><?= h($customer->number) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Municipality') ?>:</td>
        <td class="data"><?= h($customer->municipality) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('State') ?>:</td>
        <td class="data"><?= h($customer->state) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Country') ?>:</td>
        <td class="data"><?= h($customer->country) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Postal Code') ?>:</td>
        <td class="data"><?= h($customer->postal_code) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Customer Category') ?>:</td>
        <td class="data"><?= $customer->customer_category ? $customer->customer_category->name : '' ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Office') ?>:</td>
        <td class="data"><?= $customer->office ? $customer->office->name : '' ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Customer Type') ?>:</td>
        <td class="data"><?= $customer->customer_type ? $customer->customer_type->name : '' ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Franquicia') ?>:</td>
        <td class="data"><?= $customer->franquicia ? $customer->franquicia->name : '' ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Customer Headcount') ?>:</td>
        <td class="data"><?= $customer->customer_headcount ? $customer->customer_headcount->name : '' ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Website') ?>:</td>
        <td class="data"><?= h($customer->website) ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Customer Since') ?>:</td>
        <td class="data"><?= $customer->customer_since ? $customer->customer_since->format(DATE_DISPLAY_FORMAT) : ''; ?></td>
    </tr>
    <tr>
        <td class="bold"><?=__('Seller') ?>:</td>
        <td class="data"><?= $customer->seller ? $customer->seller->full_name : '' ?></td>
    </tr>
</table>