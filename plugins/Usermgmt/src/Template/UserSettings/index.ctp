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
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('All Settings');?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Add Setting', true), ['action'=>'addSetting'], ['class'=>'btn btn-default']);?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Setting Options', true), ['controller'=>'SettingOptions', 'action'=>'index'], ['class'=>'btn btn-default']);?>
		</span>
	</div>
	<div class="panel-body">
		<div class="well">
			<span class="label label-success">Help: How to use these settings</span>
			<br/><br/>
			<ul>
				<li>Configure::read(key); for e.g. Configure::read('site_name'); , Configure::read('site_name_short'); <strong>Please Note: You may need to add "use Cake\Core\Configure;" (without quotes) in the file</strong></li>
				<li>You can also use as contants (defines) in upper case of key for e.g. SITE_NAME , SITE_NAME_SHORT</li>
			</ul>
		</div>
		<?php echo $this->element('Usermgmt.all_settings');?>
	</div>
</div>