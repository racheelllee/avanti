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

<div id="updateFranquiciasIndex">

	<?php echo $this->Search->searchForm('Franquicias', ['legend'=>false, 'updateDivId'=>'updateFranquiciasIndex']); ?>
	<?php echo $this->element('Usermgmt.paginator', ['updateDivId'=>'updateFranquiciasIndex']); ?>

	<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight" id="UserTable" width="100%" data-page-length='50' >
		<thead>
			<tr>
				<th class="sorting" style="min-width:250px;"> <?php echo __('Nombre'); ?> </th>
				
				<th class="sorting" style="min-width:250px;"> <?php echo __('Calle Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Colonia Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Municipio Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Estado Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('País Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Código Postal Fiscal'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Calle Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Colonia Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Municipio Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Estado Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('País Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Código Postal Entrega'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Teléfono 1'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Teléfono 2'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Teléfono 3'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Fecha Ingreso'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Estatus'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('RFC'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Nombre'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Apellido Paterno'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Apellido Materno'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Fecha Nacimiento'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Correo'); ?> </th>

				<th class="sorting" style="min-width:250px;"> <?php echo __('Creado'); ?> </th>
	
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php	if(!empty($franquicias)) {
				$page = @$this->request->params['paging']['Users']['page'];
				$limit = @$this->request->params['paging']['Users']['perPage'];
				$i = ($page-1) * $limit;
				foreach($franquicias as $row) {
					$i++;
					
					echo "<tr>";
						echo "<td>".h($row['name']).' '.h($row['last_name'])."</td>";
						echo "<td>".h($row['calle_fiscal'])."</td>";
						echo "<td>".h($row['colonia_fiscal'])."</td>";
						echo "<td>".h($row['mun_fiscal'])."</td>";
						echo "<td>".h($row['estado_fiscal'])."</td>";
						echo "<td>".h($row['pais_fiscal'])."</td>";
						echo "<td>".h($row['cod_postal_fiscal'])."</td>";
						echo "<td>".h($row['calle_entrega'])."</td>";
						echo "<td>".h($row['col_entrega'])."</td>";
						echo "<td>".h($row['mun_entrega'])."</td>";
						echo "<td>".h($row['estado_entrega'])."</td>";
						echo "<td>".h($row['pais_entrega'])."</td>";
						echo "<td>".h($row['col_postal_entrega'])."</td>";
						echo "<td>".h($row['tel_1'])."</td>";
						echo "<td>".h($row['tel_2'])."</td>";
						echo "<td>".h($row['tel_3'])."</td>";
						echo "<td>".h($this->Time->format($row['fecha_ingreso'], 'dd/MM/YYYY'))."</td>";
						echo "<td align='center'>";
							if($row['status'] == 1) {
								echo "<span class='label w-backgroud578EBE'>".__('Activo')."</span>";
							} else {
								echo "<span class='label w-backgroudC49F47'>".__('Inactivo')."</span>";
							}
						echo"</td>";
						echo "<td>".h($row['rfc'])."</td>";
						echo "<td>".h($row['nombre_franq'])."</td>";
						echo "<td>".h($row['ap_franq'])."</td>";
						echo "<td>".h($row['am_franq'])."</td>";
						echo "<td>".h($this->Time->format($row['fecha_nac_franq'], 'dd/MM/YYYY'))."</td>";
						echo "<td>".h($row['correo_franq'])."</td>";
						echo "<td>".h($this->Time->format($row['created'], 'dd/MM/YYYY'))."</td>";
						echo "<td>";
							echo "<div class='col-xs-12' style='text-align: center;'>";
								echo "<div class='btn-group'>";
									echo "<button class='btn dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' aria-expanded='false'>".__('Action')." <span class='caret'></span></button>";
									echo "<ul class='dropdown-menu pull-right'>";

										if($this->UserAuth->HP('Franquicias', 'view', false)) { 

											echo "<li>".$this->Html->link(__('Ver'), ['controller'=>'Franquicias', 'action'=>'view', $row['id']], ['escape'=>false])."</li>";
										}

										if($this->UserAuth->HP('Franquicias', 'edit', false)) { 

											echo "<li>".$this->Html->link(__('Edit'), ['controller'=>'Franquicias', 'action'=>'edit', $row['id']], ['escape'=>false])."</li>";
										}

										if($this->UserAuth->HP('Franquicias', 'delete', false)) {
											echo "<li>".$this->Form->postLink(__('Borrar'), ['controller'=>'Franquicias', 'action'=>'delete', $row['id'], 'page'=>$page], ['escape'=>false, 'confirm'=>__('¿Esta seguro de quierer borrar este franquicia?')])."</li>";
										}

										if($this->UserAuth->isAdmin()){
											if($row['status'] == 1) {
												echo "<li>".$this->Form->postLink(__('Inactivate'), ['controller'=>'Franquicias', 'action'=>'setInactive', $row['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer desactivar este franquicia?')])."</li>";
											} else {
												echo "<li>".$this->Form->postLink(__('Activate'), ['controller'=>'Franquicias', 'action'=>'setActive', $row['id']], ['escape'=>false, 'confirm'=>__('¿Esta seguro de querer activar este franquicia?')])."</li>";
											}
										}

									echo "</ul>";
							echo "</div>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=10><br/><br/>".__('No Records Available')."</td></tr>";
			} ?>
		</tbody>
	</table>
	
	<?php if(!empty($franquicias)) { ?>
		<?php echo $this->element('simple_pagination');?>
	<?php } ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#UserTable').dataTable({bPaginate: false, searching: false, responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
            ]
        });

        $('.dataTables_wrapper div').first().remove();
        $('.usermgmtSearchForm').css('border-bottom','transparent');
	});
</script>
