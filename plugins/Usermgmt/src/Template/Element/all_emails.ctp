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
<div id="updateUserEmailIndex">
	<?php echo $this->Search->searchForm('UserEmails', ['legend'=>false, 'updateDivId'=>'updateUserEmailIndex']); ?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateUserEmailIndex']); ?>
	<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th><?php echo __('#');?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserEmails.type', __('Type')); ?></th>
				<th><?php echo __('Groups(s)');?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserEmails.from_name', __('From Name')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserEmails.from_email', __('From Email')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserEmails.subject', __('Subject')); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('Users.first_name', __('Sent By')); ?></th>
				<th><?php echo __('Sent?'); ?></th>
				<th class="psorting"><?php echo $this->Paginator->sort('UserEmails.created', __('Date Sent')); ?></th>
				<th><?php echo __('Action');?></th>
			</tr>
		</thead>
		<tbody>
	<?php	if(!empty($userEmails)) {
				$page = $this->request->params['paging']['UserEmails']['page'];
				$limit = $this->request->params['paging']['UserEmails']['perPage'];
				$i = ($page-1) * $limit;
				foreach($userEmails as $row) {
					$i++;
					echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>";
							if($row['type'] == 'USERS') {
								echo __('Selected Users');
							} else if($row['type'] == 'GROUPS') {
								echo __('Group Users');
							} else {
								echo __('Manual Emails');
							}
						echo "</td>";
						echo "<td>";
							if(!empty($row['user_group_id'])) {
								echo $row['group_name'];
							} else {
								echo __('N/A');
							}
						echo "</td>";
						echo "<td>".$row['from_name']."</td>";
						echo "<td>".$row['from_email']."</td>";
						echo "<td>".$row['subject']."</td>";
						echo "<td>".$row['user']['first_name'].' '.$row['user']['last_name']."</td>";
						echo "<td>";
							if($row['total_sent_emails'] > 0) {
								echo "<span class='label label-success'>".__('Yes')."</span>";
							} else {
								echo "<span class='label label-danger'>".__('No')."</span>";
							}
						echo"</td>";
						echo "<td>".$row['created']->format('d-M-Y')."</td>";
						echo "<td>";
							echo "<div class='btn-group'>";
								echo "<button class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>".__('Action')." <span class='caret'></span></button>";
								echo "<ul class='dropdown-menu'>";
									echo "<li>".$this->Html->link(__('View Full Email & Recipients'), ['action'=>'view', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
								echo "</ul>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=10><br/><br/>".__('No Records Available')."</td></tr>";
			} ?>
		</tbody>
	</table>
	<?php if(!empty($userEmails)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Emails')]);
	}?>
</div>