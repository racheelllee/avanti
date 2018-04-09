


<?= $this->html->link("Documentación", "https://github.com/spipu/html2pdf/", [ 'target' => '_blank']) ?>



<br><br>
Ejemplo:
<?= $this->Html->link( 'Ver Pdf',''.$filename.".pdf"  ,[ 'target' => '_blank'] ); ?>

<?= $this->html->script('plugins/codemirror/codemirror.js',  ['block' => true]) ?>
<?= $this->html->css('plugins/codemirror/codemirror.css', ['block' => true] )?>
<?= $this->html->script('plugins/codemirror/mode/javascript/javascript.js', ['block' => true]) ?>
<br> <br>
<textarea id="code">
class DemosController extends AppController{

    public function index(){
        return $this->redirect('/');
    }

    public function pdf(){

        $pdf = new \HTML2PDF('P','LETTER','es');
     
        ob_start();
        include(ROOT. DS.'vendor'.DS.'spipu'.DS.'html2pdf'.DS.'examples'.DS.'res'.DS. 'exemple05.php');
        $content = ob_get_clean();
        $pdf->WriteHTML($content);
        $filename="PdfDemo";
        if(file_exists(WWW_ROOT.'/'.$filename.'.pdf') )
            unlink(WWW_ROOT.'/'.$filename.'.pdf');

        $pdf->Output(WWW_ROOT.'/'.$filename.'.pdf','F');


        $this->set(compact( 'filename', $filename ));
    }
}
</textarea>



<script type="text/javascript">



var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("code"),{
    lineNumbers: true,
    readOnly: true,

  //  theme:"ambiance"
  });

</script>