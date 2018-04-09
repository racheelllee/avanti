
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        
            <form action="/imagenes/index/<?= $producto_id ?>" class="dropzone" id="uploadFile">
              <div class="fallback">
                <input name="file" type="file" multiple />
              </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
  


    $(function() { //maxFiles: 1,
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#uploadFile", {
            dictDefaultMessage: "Arrastra las fotos aquí para subirlas",
            acceptedFiles: "<?= IMG_PRODUCTO_ACCEPTEDFILES ?>",
            maxFilesize: <?= IMG_PRODUCTO_MAXFILESIZE ?>,
            accept: function(file, done) {
                file.acceptDimensions = done;
                file.rejectDimensions = function() { done("Dimensión no válida."); };
              }
        });
        
        myDropzone.on("thumbnail", function(file) {
          // Do the dimension checks you want to do
          if (file.width != <?= IMG_PRODUCTO_WIDTH ?> || file.height != <?= IMG_PRODUCTO_HEIGHT ?>) {
            file.rejectDimensions()
          }
          else {
            file.acceptDimensions();
          }
        });

        myDropzone.on("error", function(file, response) {
            
            $.notify({
                icon: false,
                title: '',
                message: file.name + ' : ' + response
              },{
                type: 'danger',
                animate: {
                  enter: 'animated fadeInUp',
                  exit: 'animated fadeOutRight'
                },
                placement: {
                  from: "top",
                  align: "right"
                },
                offset: 20,
                spacing: 10
              });
        });

        myDropzone.on("success", function(file, serverFileName) {
            
        });

        myDropzone.on("queuecomplete", function(file) {
            
            setTimeout(function(){ 
                location.reload();
            }, 2000);

        });

        $('div.dz-default.dz-message > span').show();
        $('div.dz-default.dz-message').css({'opacity':1, 'background-image': 'none', 'text-align': 'center'});

    });


</script>




    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox float-e-margins">
              
                    <table ata-order='[[ 1, "asc" ]]' data-page-length='50' class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>                       
                                <th>Imagen</th>
                                <th>Orden</th>
                                <th class="actions">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($imagenes as $imagen): ?>
                            <tr>
                              <td>
                                <div class="actions" style="width: 200px;">
                                    <img src="/upload/productos/<?= h($imagen->nombre) ?>" width="100%">
                                </div>
                            </td>
                            <td>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php 
                                        echo $this->Form->create(null,['class'=>"form-inline"]);
                                            echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$imagen->id));
                                            ?>
                                            <div class="col-xs-4">
                                            <?php echo $this->Form->input('orden', array('type'=>'number', 'label'=>'','value'=>$imagen->orden, 'class'=>'form-control'));?>
                                            </div>
                                            <div class="col-xs-4">
                                            <?php echo $this->Form->button('Guardar',['class'=>"btn btn-submit", 'style'=>'    margin-top: 16px;']);?>
                                            </div>
                                            <?php
                                        echo $this->Form->end();
                                    ?>

                                </div>
                            </td>

                            <td>
                                
                                         <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $imagen->id], ['confirm' => __('Seguro que quiere borrar # {0}?', $imagen->id), 'title' => __('Eliminar'), "escape" => false, 'class'=>"btn btn-submit", 'style'=>'    margin-top: 16px;']) ?>
                                     
                             
                            </td>
                            </tr>

                                <?php endforeach; ?>
                             </tbody>
</table>
    </div></div></div></div>

