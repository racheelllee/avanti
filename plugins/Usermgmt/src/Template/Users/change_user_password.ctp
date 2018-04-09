<?php
/* Cakephp 3.x User Management Premium Version (a product of Ektanjali Softwares Pvt Ltd)
Website- http://ektanjali.com
Plugin Demo- http://cakephp3-user-management.ektanjali.com/
Author- Chetan Varshney (The Director of Ektanjali Softwares Pvt Ltd)
Plugin Copyright No- 11498/2012-CO/L

UMPremium is a copyrighted work of authorship. Chetan Varshney retains ownership of the product and any copies of it, regardless of the form in which the copies may exist. This license is not a sale of the original product or any copies.

By installing and using UMPremium on your server, you agree to the following terms and conditions. Such agreement is either on your own behalf or on behalf of any corporate entity which employs you or which you represent ('Corporate Licensee'). In this Agreement, 'you' includes both the reader and any Corporate Licensee and Chetan Varshney.

The Product is licensed only to you. You may not rent, lease, sublicense, sell, assign, pledge, transfer or otherwise dispose of the Product in any form, on a temporary or permanent basis, without the prior written consent of Chetan Varshney.

The Product source code may be altered (at your risk)

All Product copyright notices within the scripts must remain unchanged (and visible).

If any of the terms of this Agreement are violated, Chetan Varshney reserves the right to action against you.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Product.

THE PRODUCT IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE PRODUCT OR THE USE OR OTHER DEALINGS IN THE PRODUCT. */
?>

<?php 
$this->Html->addCrumb(__('Cambiar Contraseña'), ['controller' => 'Users', 'action' => 'changeUserPassword','plugin' => 'Usermgmt', $user['id']]);
?>

<div class="panel">
  <div class="panel-heading">
    <span class="panel-title">
      <?php echo __('Cambiar contraseña de').' '.$user['first_name'].' '.$user['last_name']; ?>
    </span>
    <span class="panel-title-right">
      
    </span>
  </div>
  <div class="panel-body">
    <?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'changeUserPasswordForm', 'submitButtonId'=>'changeUserPasswordSubmitBtn']); ?>
    <?php echo $this->Form->create($userEntity, ['id'=>'changeUserPasswordForm', 'class'=>'form-horizontal']); ?>
      <div class="ca-form">
        <div class="um-form-row form-group">
          <div class="col-sm-12"><br></div>
        </div>
        <div class="col-md-6">
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?= __('New Password'); ?></label>
            <div class="col-sm-10">
              <div class="input text">
                <?= $this->Form->input('Users.password', ['type'=>'password', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
              </div>
            </div>
          </div>
          <div class="um-form-row form-group">
            <label class="col-sm-2 control-label"><?= __('New Password'); ?></label>
            <div class="col-sm-10">
              <div class="input text">
                <?php echo $this->Form->input('Users.cpassword', ['type'=>'password', 'label'=>false, 'div'=>false, 'class'=>'form-control']); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 split-btn">
          <?= $this->Form->Submit(__('Change Password'), ['class'=>'btn btn-submit', 'id'=>'changeUserPasswordSubmitBtn']); ?>
          
        </div>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
