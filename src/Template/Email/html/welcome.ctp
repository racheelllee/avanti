
<div class="section">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-12">
	            
	            <div class="page-header">
		            <h3> <?php echo __('Hi {0}.', [$userEntity['first_name']]) ?> </h3><br><br>

		            <p style="font-size: 16px"><?php echo __('Starting this moment you can access to {0}',[SITE_NAME]) ?> </p>
		         

	            </div>

	            <table style="width:100%;" class="table">
	              <thead>
	                <tr></tr>
	              </thead>
	              <tbody>

	  				
	                <tr>
	                <td colspan="2"> 
	                	<p style="font-size: 16px"> Por favor dirígete a:<p> 

	                	<?php echo $link ?> <br/>

	                	<br/>

	                	<p style="font-size: 16px"> Para que puedas proporcionar una nueva contraseña.</p> </td>
	               	</tr>
	               	
	                <tr>

	                
	                </tbody>
	            </table>
	          </div>
	          <div class="col-md-12">
	          		<p  style="font-size: 14px"> <?php echo __('In the face of anywhere problem access, you have question about account or the<br>privileges assigned, please contact the support area.') ?> </p>
	        <p  style="font-size: 14px"> <?php echo __('Atentamente<br>{0}.',[SITE_NAME]); ?> <p>
	          </div>
	        </div>
	      </div>
	    </div>
