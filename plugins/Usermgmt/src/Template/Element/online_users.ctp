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
<div id='updateOnlineIndex'>
	<?php echo $this->Search->searchForm('UserActivities', ['legend'=>false, 'updateDivId'=>'updateOnlineIndex']); ?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateOnlineIndex']); ?>
	<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th><?php echo __('#');?></th>
				<th><?php echo __('Name');?></th>
				<th><?php echo __('Email');?></th>
				<th><?php echo __('Last URL');?></th>
				<th><?php echo __('Browser');?></th>
				<th><?php echo __('Ip Address');?></th>
				<th><?php echo __('Last Action');?></th>
				<th><?php echo __('Action');?></th>
			</tr>
		</thead>
		<tbody>
	<?php	if(!empty($users)) {
				$page = $this->request->params['paging']['UserActivities']['page'];
				$limit = $this->request->params['paging']['UserActivities']['perPage'];
				$i = ($page-1) * $limit;
				foreach($users as $row) {
					$i++;
					echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".(($row['user_id'] == null) ? 'Guest' : ($row['user']['first_name'].' '.$row['user']['last_name']))."</td>";
						echo "<td>".$row['user']['email']."</td>";
						echo "<td>".$row['last_url']."</td>";
						echo "<td>".$row['user_browser']."</td>";
						echo "<td>".$row['ip_address']."</td>";
						echo "<td>".$this->Time->timeAgoInWords($row['last_action'])."</td>";
						echo "<td>";
							if(!empty($row['user_id']) && $row['user_id'] != 1) {
								echo "<div class='btn-group'>";
									echo "<button class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>".__('Action')." <span class='caret'></span></button>";
									echo "<ul class='dropdown-menu'>";
										echo "<li>".$this->Form->postLink(__('Sign Out'), ['controller'=>'Users', 'action'=>'logoutUser', $row['user_id']], ['escape'=>false, 'confirm'=>__('Are you sure you want to sign out this user?')])."</li>";
										echo "<li>".$this->Form->postLink(__('Inactivate'), ['controller'=>'Users', 'action'=>'setInactive', $row['user_id']], ['escape'=>false, 'confirm'=>__('This user will be signed out and will not be able to login again')])."</li>";
									echo "</ul>";
								echo "</div>";
							}
						echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=8><br/><br/>".__('No Records Available')."</td></tr>";
			} ?>
		</tbody>
	</table>
	<?php if(!empty($users)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Online Users')]);
	} ?>
</div>