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
<div id="updateUserContactsIndex">
	<?php echo $this->Search->searchForm('UserContacts', ['legend'=>false, 'updateDivId'=>'updateUserContactsIndex']); ?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateUserContactsIndex']); ?>
	<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th><?php echo __('#'); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserContacts.user_id', __('User ID')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserContacts.name', __('Name')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserContacts.email', __('Email')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserContacts.phone', __('Contact Number')); ?></th>
				<th><?php echo __('Requirement'); ?></th>
				<th><?php echo __('Reply Message'); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserContacts.created', __('Date')); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php	if(!empty($userContacts)) {
				$page = $this->request->params['paging']['UserContacts']['page'];
				$limit = $this->request->params['paging']['UserContacts']['perPage'];
				$i = ($page-1) * $limit;
				foreach($userContacts as $row) {
					$i++;
					echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>";
							if($row['user_id']) {
								echo $this->Html->link($row['user_id'], ['controller'=>'Users', 'action'=>'viewUser', $row['user_id'], 'page'=>$page]);
							}
						echo "</td>";
						echo "<td>".h($row['name'])."</td>";
						echo "<td>".h($row['email'])."</td>";
						echo "<td>".h($row['phone'])."</td>";
						echo "<td>".nl2br($row['requirement'])."</td>";
						echo "<td>".$row['reply_message']."</td>";
						echo "<td>".$row['created']->format('d-M-Y')."</td>";
						echo "<td>";
							echo "<div class='btn-group'>";
								echo "<button class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>".__('Action')." <span class='caret'></span></button>";
								echo "<ul class='dropdown-menu'>";
									echo "<li>".$this->Html->link(__('Send Reply'), ['action'=>'sendReply', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
								echo "</ul>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=9><br/><br/>".__('No Records Available')."</td></tr>";
			} ?>
		</tbody>
	</table>
	<?php if(!empty($userContacts)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Enquiries')]);
	} ?>
</div>