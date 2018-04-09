<div class="container" style="margin-bottom:50px;">
	<div class="col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Inicio</a></li>
          <li><a href="#">Contactanos</a></li>
        </ol>
    </div>

    <div class="col-md-12">
    	<div class="paga_title">
			<h1> CONTÁCTANOS </h1>

			<h2> info.avanti@avanti.com </h2>
			<h2> Tel. 17 68 2080 </h2>
		</div>
	</div>
    

    <div class="col-md-12" style="margin-top:20px;">
	    <div class="col-md-6">
	    	<h2 class="title-static-pages">ESCRÍBENOS</h2>
	    	<p style="line-height: 30px; margin-top:20px;">
	    		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
	    	</p>
	    </div>
	    <div class="col-md-6 ca-form">
	    	<?php echo $this->Form->create(null, ['class'=>'form-horizontal']); ?>
			    <div class="col-sm-12">
			    	<?php echo $this->Form->input('nombre', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'Nombre', 'required'=>true]); ?>        
			    </div>
			    <div class="col-sm-12">
			    	<?php echo $this->Form->input('apellido', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'Apellido']); ?>        
			    </div>
			    <div class="col-sm-6">
			    	<?php echo $this->Form->input('pais', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'País']); ?>        
			    </div>
			    <div class="col-sm-6">
			    	<?php echo $this->Form->input('estado', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'Estado']); ?>        
			    </div>
			    <div class="col-sm-6">
			    	<?php echo $this->Form->input('email', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'Email', 'required'=>true]); ?>        
			    </div>
			    <div class="col-sm-6">
			    	<?php echo $this->Form->input('telefono', ['type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'form-control form-input', 'placeholder'=>'Teléfono']); ?>        
			    </div>
			    <div class="col-sm-12">
			    	<?php echo $this->Form->textarea('mensaje', ['class'=>'form-control form-textarea', 'placeholder'=>'Mensaje', 'required'=>true]); ?>        
			    </div>
			    <div class="col-sm-12">
			    	<?php echo $this->Form->Submit(__('ENVIAR'), ['div'=>false, 'class'=>'btn btn-gris pull-right', 'id'=>'addUserSubmitBtn']); ?>
			    </div>
			<?php echo $this->Form->end(); ?>
	    </div>
	</div>
</div>