<?= $this->html->script('plugins/codemirror/codemirror.js',  ['block' => true]) ?>
<?= $this->html->css('plugins/codemirror/codemirror.css', ['block' => true] )?>
<?= $this->html->script('plugins/codemirror/mode/javascript/javascript.js', ['block' => true]) ?>



<br>
<br>
Configuración:

<textarea id="code">
'EmailTransport' => [
        'default' => [
            'className' => 'Mail',
            // The following keys are used in SMTP transports
            'host' => 'localhost',
            'port' => 25,
            'timeout' => 30,
            'username' => 'user',
            'password' => 'secret',
            'client' => null,
            'tls' => null,
        ],
        'ews' => [
            'className' => 'Ews',
            // The following keys are used in SMTP transports
            'urlEWS' => 'https://mail.soporteg.com.mx/EWS/Exchange.asmx',  
            'usernameEWS' => 'gp/noreply',
            'passwordEWS' => '654321sg',
            
        ],
    ],


</textarea>
<br>
<br>
Ejemplo:
<textarea id="code2">

	use Cake\Mailer\Email;

	$email = new Email('');

    $email->transport('ews');

    $email->template("default")
          ->emailFormat("html")
          ->to('francisco.carrizales@webpoint.mx')
          ->viewVars(['content' => "hola mundo ". time()])
          ->from('app@domain.com') ;
          ->send();
</textarea>


<script type="text/javascript">



var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("code"),{
    lineNumbers: true,
    readOnly: true,

  //  theme:"ambiance"
  });

var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("code2"),{
    lineNumbers: true,
    readOnly: true,

  //  theme:"ambiance"
  });

</script>