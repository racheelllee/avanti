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
<script type="text/javascript">
	function validateForm() {
		if(!confirm("<?php echo __('Are you sure, you want to send this email?');?>")) {
			return false;
		}
		return true;
	}
</script>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="panel-title">
			<?php echo __('Confirm Sending Email to').' '.$name; ?>
		</span>
		<span class="panel-title-right">
			<?php echo $this->Html->link(__('Edit', true), ['action'=>'sendToUser', $userId], ['class'=>'btn btn-default']); ?>
		</span>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create($userEmailEntity, ['onSubmit'=>'return validateForm()']); ?>
		<table class="table table-striped table-bordered table-condensed table-hover">
			<tbody>
				<tr>
					<th><?php echo __('To');?></th>
					<td><?php echo $userEmailEntity['to']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('CC Email(s)');?></th>
					<td><?php echo $userEmailEntity['cc_to']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('From Name');?></th>
					<td><?php echo $userEmailEntity['from_name']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('From Email');?></th>
					<td><?php echo $userEmailEntity['from_email']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('Email Subject');?></th>
					<td><?php echo $userEmailEntity['subject']; ?></td>
				</tr>
				<tr>
					<th><?php echo __('Email Message');?></th>
					<td><?php echo $userEmailEntity['modified_message']; ?></td>
				</tr>
			</tbody>
		</table>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Send Mail'), ['class'=>'btn btn-primary', 'name'=>'confirmEmail']); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>