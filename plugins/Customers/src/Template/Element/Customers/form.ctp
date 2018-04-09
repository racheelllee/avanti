<div class="row">
    <div class="col-md-12" style="padding: 20px;">
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'RFC') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('rfc', [
                        'type' => 'text',
                        'required' => 'required',
                        'data-parsley-remote' => '/customers/customers/verify-rfc/' . $customer->id,
                        'data-parsley-remote-validator' => 'reverse',
                        'data-parsley-error-message' => 'Este valor ya está en uso',
                        'data-parsley-debounce' => '500',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Status') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('customer_status_id', [
                        'options' => $statusList,
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Title') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('title', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Business Name') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('business_name', [
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Street') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('street', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Number') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('number', [
                        'type' => 'number',
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Municipality') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('municipality', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'State') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('state', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Country') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('country', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Postal Code') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('postal_code', [
                        'type' => 'text',
                        'required' => 'required',
                        'class' => 'form-control postal-code',
                        'label' => false,
                        'value' => $customer->postal_code ? $customer->postal_code : '',
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Customer Category') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('customer_category_id', [
                        'options' => $customerCategories,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Office') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('office_id', [
                        'options' => $offices,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Customer Type') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('customer_type_id', [
                        'options' => $customerTypes,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Franquicia') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('franquicia_id', [
                        'options' => $franquicias,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
            <label class="col-md-12 control-label"><?= __d('customers', 'Seller') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('seller_id', [
                        'options' => $sellers,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                    </div>
            </div>
            <div class="col-md-6">
            <label class="col-md-12 control-label"><?= __d('customers', 'Customer Headcount') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('customer_headcount_id', [
                        'options' => $customerHeadcounts,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Website') ?></label>
                <div class="input-group col-lg-12">
                    <!--span class="input-group-addon"><i class="fa fa-envelope"></i></span-->
                    <?= $this->Form->input('website', [
                        'type' => 'url',
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-md-12 control-label"><?= __d('customers', 'Cliente desde') ?></label>
                <div class="input-group col-lg-12">
                <!--span class="input-group-addon"><i class="fa fa-calendar"></i></span-->
                    <?= $this->Form->input('customer_since', [
                        'type' => 'text',
                        'value' => $customer->customer_since ? $customer->customer_since->format(DATE_DISPLAY_FORMAT) : '',
                        'class' => 'form-control custom-datepicker',
                        'empty' => true,
                        'label' => false,
                        'div' => false,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-12 split-btn">
        <div class="submit">
            <?= $this->Form->button(__d('customers', 'Save'), ['class' => 'btn btn-span btn-md btn-submit', 'id' => 'save-customers-button']) ?>
        </div>
        <a href="#" id="cancel-save-customers" class="btn btn-back" data-dismiss="modal"><?= __d('customers', 'Cancel') ?></a>
    </div>
</div>
<script type="text/javascript">
function disableForm(){
    $("#save-customers :input").attr("readonly", true);
    $('#save-customers-button').prop('readonly', 'readonly');
  }
  function enableForm(){
    $("#save-customers :input").removeAttr('readonly');
    $('#save-customers-button').removeAttr('readonly');
  }
  $(function(){
    $('#save-customers').parsley().on('form:success', function() {
      disableForm();
    });
    $('#save-customers').parsley();
    $('.custom-datepicker').pickadate({
      'format': 'dd/mm/yyyy',
      'formatSubmit': 'yyyy-mm-dd',
      hiddenName: true,
      selectYears: true,
      selectMonths: true,
    });
    $(".phone").inputmask("+52 (99) 9999 9999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });
    $(".postal-code").inputmask("99999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });
  });
</script>
