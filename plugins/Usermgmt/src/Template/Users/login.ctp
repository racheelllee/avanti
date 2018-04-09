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

<?php echo $this->Form->create($userEntity, ['id'=>'loginForm', 'class'=>'login-form']); ?>
<h3 class="form-title w-labelLogin">Sign In</h3>
<div class="alert alert-danger display-hide">
  <button class="close" data-close="alert"></button>
  <span> Enter any username and password. </span>
</div>
<div class="form-group">
  <label class="control-label visible-ie8 visible-ie9">Username</label>
  <div class="input-icon">
    <i class="fa fa-user"></i>
    <?php $this->Form->templates([
      'inputContainer' => '{{content}}'
      ]);?>
    <?php echo $this->Form->input('Users.email', ['type'=>'text', 'label'=>false, 'div'=>['class' => 'input-icon'], 'placeholder'=>__('Email'), 'class'=>'form-control placeholder-no-fix input-icon login-text', 'style'=>'color:#666;']); ?>
  </div>
</div>
<div class="form-group">
  <label class="control-label visible-ie8 visible-ie9">Password</label>
  <div class="input-icon">
    <i class="fa fa-lock"></i>
    <?php echo $this->Form->input('Users.password', ['type'=>'password', 'label'=>false, 'div'=>['class' => 'input-icon'], 'placeholder'=>__('Password'), 'class'=>'form-control placeholder-no-fix login-text', 'style'=>'color:#666;' ]); ?>
  </div>
</div>
<?php if($this->UserAuth->canUseRecaptha('login')) {
  $errors = $userEntity->errors();
  $error = "";
  if(isset($errors['captcha']['_empty'])) {
  	$error = $errors['captcha']['_empty'];
  } else if(isset($errors['captcha']['mustMatch'])) {
  	$error = $errors['captcha']['mustMatch'];
  }?>
<div class="um-form-row form-group">
  <label class="col-sm-4 control-label required"><?php echo __('Prove you\'re not a robot');?></label>
  <div class="col-sm-8">
    <?php echo $this->UserAuth->showCaptcha($error);?>
  </div>
</div>
<?php } ?>
<?php echo $this->Form->Submit(__('LOGIN'), ['div'=>false, 'class'=>'btn w-btnLogin', 'id'=>'loginSubmitBtn']); ?>
<div class="forget-password login-textRoman" style="border-top: 1px dotted #eee;text-align: center;">
  <br>
  <input type="checkbox" name="Users[terms_and_conditions]" value="1">&nbsp;&nbsp;Aceptar Términos y Condiciones <br><a href="" style="color: #000;font-size: 14px !important;opacity:.5;"> Haz click aquí </a>
  <p> 
    <?= __('¿Forgot Password?') ?>
    <br>
    <span>Haz click <a href="/usermgmt/users/forgotPassword" id="forget-password" style="color:#67809F;"> aquí </a> para recuperar tu contraseña.</span> 
  </p>
</div>
<?php if(USE_REMEMBER_ME) { ?>
<div class="form-group">
  <?php if(!isset($userEntity['remember'])) {
    $userEntity['remember'] = true;
    } ?>
  <label class="col-sm-4 control-label"><?php echo __('Remember me'); ?></label>
  <div class="col-sm-7">
    <?php echo $this->Form->input('Users.remember', ['type'=>'checkbox', 'label'=>false, 'div'=>false, 'style'=>'margin-left:0']); ?>
  </div>
</div>
<?php } ?>
<?php echo $this->Form->end(); ?>