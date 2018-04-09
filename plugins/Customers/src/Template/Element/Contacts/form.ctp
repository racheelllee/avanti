<div class="row">
    <div class="col-md-12" style="padding: 20px;">
    <?php if ($customer_id): ?>
        <?= $this->Form->input('customer_id', [
            'value' => $customer_id,
            'type'=>'hidden',
        ]); ?>
    <?php else: ?>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('customer_id', [
                    'options' => $customers,
                    'required' => 'required',
                    'class'=>'form-control', 
                    'label'=>__('Proveedor'),
                    'div'=>false,
                ]); ?>
            </div>
        </div>
    <?php endif ?>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('first_name', [
                    'required' => 'required',
                    'class'=>'form-control', 
                    'label'=>__('Nombre(s)'),
                    'div'=>false, 
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('middle_name', [
                    'required' => 'required',
                    'class'=>'form-control', 
                    'label'=>__('Apellido Materno'),
                    'div'=>false, 
                ]); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('last_name', [
                    'required' => 'required',
                    'class'=>'form-control', 
                    'label'=>__('Apellido Paterno'),
                    'div'=>false, 
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('department', [
                    'required' => 'required',
                    'class'=>'form-control', 
                    'label'=>__('Departmento'),
                    'div'=>false, 
                ]); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('phone', [
                    'required' => 'required',
                    'class'=>'form-control phone', 
                    'label'=>__('Teléfono'),
                    'div'=>false, 
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('phone_ext', [
                    'class'=>'form-control', 
                    'label'=>__('Extensión'),
                    'div'=>false, 
                ]); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('mobile_phone', [
                    'class'=>'form-control cellphone', 
                    'label'=>__('Celular'),
                    'div'=>false, 
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('contact_type_id', [
                    'options'=>$contactTypes, 
                    'class'=>'form-control', 
                    'label'=>__('Tipo de Contacto'),
                    'div'=>false, 
                ]); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= $this->Form->input('email', [
                    'required' => 'required',
                    'type' => 'email',
                    'class'=>'form-control', 
                    'label'=>__('Correo'),
                    'div'=>false, 
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('second_email', [
                    'type' => 'email',
                    'class'=>'form-control', 
                    'label'=>__('Segundo Correo'),
                    'div'=>false, 
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <div class="col-md-12 split-btn">
        <div class="submit">
            <?= $this->Form->button(__d('customers', 'Save'), ['class' => 'btn btn-span btn-md btn-submit', 'id' => 'save-contact-button']) ?>
        </div>
        <a href="#" id="cancel-save-contact" class="btn btn-back" data-dismiss="modal"><?= __d('customers', 'Cancel') ?></a>
    </div>
</div>
<script type="text/javascript">
  $(function(){
    $('#contacts-form').parsley().on('form:success', function() {
        $('#save-contact-button').prop('disabled', 'disabled')
    });
    $('#save-contact').parsley();
    $('.custom-datepicker').pickadate({
      'format': 'dd/mm/yyyy',
      'formatSubmit': 'yyyy-mm-dd',
      hiddenName: true,
      selectYears: true,
      selectMonths: true,
    });
    $(".cellphone").inputmask("+52 (99) 9999 9999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });  
    $(".phone").inputmask("+52 999 9999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });
    $(".postal-code").inputmask("99999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });
  });
</script>
