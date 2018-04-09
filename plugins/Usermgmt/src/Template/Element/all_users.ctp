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
<div id="updateUsersIndex">
  <?php echo $this->Search->searchForm('Users', ['legend'=>false, 'updateDivId'=>'updateUsersIndex']); ?>
  <?php echo $this->element('Usermgmt.paginator', ['updateDivId'=>'updateUsersIndex']); ?>
  <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight" id="UserTable" width="100%" >
    <thead>
      <tr>
        <th class="psorting" style="min-width:250px;"><?= $this->Paginator->sort('first_name', __('Name')) ?> </th>
        <th class="psorting"> <?= $this->Paginator->sort('email', __('Email')) ?> </th>
        <th class="psorting" style="min-width:150px;"> <?= $this->Paginator->sort('user_group_name', __('User Profile')) ?> </th>
        <th class="psorting"> <?= $this->Paginator->sort('active', __('Status')) ?> </th>
        <th class="psorting" style="min-width:250px;"> <?php echo __('Birth Date'); ?> </th>
        <th class="psorting" style="min-width:250px;"> <?= __('Gender') ?> </th>
        <th><?php echo __('Action'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php	if(!empty($users)) {
        $page = @$this->request->params['paging']['Users']['page'];
        $limit = @$this->request->params['paging']['Users']['perPage'];
        $i = ($page-1) * $limit;
        foreach($users as $row) {
        	$i++;
        	
        	echo "<tr>";
        		echo "<td>".h($row['first_name']).' '.h($row['last_name']).' '.h($row['clast_name'])."</td>";
        		echo "<td>".h($row['email'])."</td>";
        		echo "<td>".$row['user_group_name']."</td>";
        		echo "<td align='center'>";
        			if($row['active']) {
        				echo "<span class='label w-backgroud578EBE'>".__('Activo')."</span>";
        			} else {
        				echo "<span class='label w-backgroudC49F47'>".__('Inactivo')."</span>";
        			}
        		echo"</td>";
        		echo "<td>".$row['day_birthday'].' de '.$months[$row['month_birthday']]."</td>";
        		
        		echo "<td>".$row['gender']."</td>";
        		
        		
        		
        		echo "<td>";
        				echo "<div class='btn-group'>";
        					echo "<button class='btn dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' aria-expanded='false'>".__('Action')." <span class='caret'></span></button>";
        					echo "<ul class='dropdown-menu pull-right'>";
        
        						if($this->UserAuth->HP('Users', 'viewUser', 'Usermgmt')) {
        
        							echo "<li>".$this->Html->link(__('View User'), ['controller'=>'Users', 'action'=>'viewUser', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
        
        						}
        
        
        						if($this->UserAuth->HP('Users', 'editUser', 'Usermgmt')) { 
        
        							echo "<li>".$this->Html->link(__('Editar Usuario'), ['controller'=>'Users', 'action'=>'editUser', $row['id']], ['escape'=>false])."</li>";
        						}
        
        
        						if($this->UserAuth->HP('Users', 'changeUserPassword', 'Usermgmt')) {
        							echo "<li>".$this->Html->link(__('Change Password'), ['controller'=>'Users', 'action'=>'changeUserPassword', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
        						}
        
        
        						if($row['id'] != 1 && strtolower($row['username']) != 'admin') {
        
        							if($row['active']) {
        								echo "<li>".$this->Form->postLink(__('Inactivate'), ['controller'=>'Users', 'action'=>'setInactive', $row['id'], 'page'=>$page], ['escape'=>false, 'confirm'=>__('Are you sure you want to inactivate this user?')])."</li>";
        							} else {
        								echo "<li>".$this->Form->postLink(__('Activate'), ['controller'=>'Users', 'action'=>'setActive', $row['id'], 'page'=>$page], ['escape'=>false, 'confirm'=>__('Are you sure you want to activate this user?')])."</li>";
        							}
        							if(!$row['email_verified']) {
        								echo "<li>".$this->Form->postLink(__('Verify Email'), ['action'=>'verifyEmail', $row['id'], 'page'=>$page], ['escape'=>false, 'confirm'=>__('Are you sure you want to verify email of this user?')])."</li>";
        							}
        							echo "<li>".$this->Form->postLink(__('Delete User'), ['controller'=>'Users', 'action'=>'deleteUser', $row['id'], 'page'=>$page], ['escape'=>false, 'confirm'=>__('Are you sure you want to delete this user?')])."</li>";
        
        						}
        
        						if($this->UserAuth->HP('Users', 'viewUserPermissions', 'Usermgmt')) {
        							 "<li>".$this->Html->link(__('View Permissions'), ['controller'=>'Users', 'action'=>'viewUserPermissions', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
        						}
        
        						if($this->UserAuth->HP('Users', 'index', 'sendToUser')) {
        							 "<li>".$this->Html->link(__('Send Mail'), ['controller'=>'UserEmails', 'action'=>'sendToUser', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
        						}
        
        						if( $this->UserAuth->isAdmin() && $row['active'] == TRUE){
        
        							echo "<li>".$this->Html->link(__('Reenviar Invitación'), ['controller'=>'Users', 'action'=>'sendEmail', $row['id']], ['escape'=>false])."</li>";
        						}
        
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

  <?php if(!empty($users)) { ?>
    <?php echo $this->element('simple_pagination');?>
  <?php } ?>
  
</div>
<script type="text/javascript">
  $(document).ready(function(){
  	$('#UserTable').dataTable({bPaginate: false, searching: false, responsive: true, ordering: false,
             columnDefs: [
                 { responsivePriority: 1, targets: -1 },
             ]
         });
  
   $('.dataTables_wrapper div').first().remove();
   $('.usermgmtSearchForm').css('border-bottom','transparent');
  });
</script>