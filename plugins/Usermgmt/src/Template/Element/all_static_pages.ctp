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
<div id="updateStaticPagesIndex">
	<?php echo $this->Search->searchForm('StaticPages', ['legend'=>false, 'updateDivId'=>'updateStaticPagesIndex']); ?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateStaticPagesIndex']); ?>
	<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight">
		<thead>
			<tr>
				<th class=""><?php echo $this->Paginator->sort('StaticPages.page_name', __('Page Name')); ?></th>
				<th class=""><?php echo $this->Paginator->sort('StaticPages.url_name', __('Url Name')); ?></th>
				<th class=""><?php echo $this->Paginator->sort('StaticPages.page_title', __('Page Title')); ?></th>
				<th><?php echo __('Page Link'); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php	if(!empty($staticPages)) {
				$page = $this->request->params['paging']['StaticPages']['page'];
				$limit = $this->request->params['paging']['StaticPages']['perPage'];
				$i = ($page-1) * $limit;
				foreach($staticPages as $row) {
					$i++;
					echo "<tr>";
						echo "<td>".$row['page_name']."</td>";
						echo "<td>".$row['url_name']."</td>";
						echo "<td>".$row['page_title']."</td>";
						echo "<td>";
							echo "<a href='".SITE_URL.'info/'.$row['url_name']."'>".SITE_URL.'info/'.$row['url_name']."</a>";
						echo "</td>";
						echo "<td>";
							echo "<div class='btn-group'>";
								echo "<button class='btn dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown'>".__('Action')." <span class='caret'></span></button>";
								echo "<ul class='dropdown-menu'>";

									if($this->UserAuth->HP('StaticPages', 'edit', 'Usermgmt')){
										echo "<li>".$this->Html->link(__('Edit Page'), ['controller'=>'StaticPages', 'action'=>'edit', $row['id'], 'page'=>$page], ['escape'=>false])."</li>";
									}

									if($this->UserAuth->HP('StaticPages', 'delete', 'Usermgmt')){
										echo "<li>".$this->Form->postLink(__('Delete Page'), ['controller'=>'StaticPages', 'action'=>'delete', $row['id']], ['escape'=>false, 'confirm'=>__('Are you sure you want to delete this page?')])."</li>";
									}
									
								echo "</ul>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=7><br/><br/>".__('No Records Available')."</td></tr>";
			} ?>
		</tbody>
	</table>
	<?php if(!empty($staticPages)) {
		echo $this->element('simple_pagination');
	} ?>
</div>