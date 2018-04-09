<?php

namespace App\Mailer\Transport;

use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Email;

class EwsTransport extends AbstractTransport{
	
	/**
    * cambiar en la configuracion De:
	* 'EmailTransport' => [
*        'default' => [
*            'className' => 'Mail',
*            // The following keys are used in SMTP transports
*            'host' => 'localhost',
*            'port' => 25,
*            'timeout' => 30,
*            'username' => 'user',
*            'password' => 'secret',
*            'client' => null,
*            'tls' => null,
*        ],
*    ],
*    POR 
*	 'EmailTransport' => [
*        'default' => [
*            'className' => 'Ews',
*            // The following keys are used in SMTP transports
*           
*        ],
*    ],
    */

	/**
     * Send mail
     *
     * @param \Cake\Mailer\Email $email Cake Email
     * @return array
     */
    public function send(Email $email)
    {
        $eol = PHP_EOL;
        if (isset($this->_config['eol'])) {
            $eol = $this->_config['eol'];
        }
        $headers = $email->getHeaders(['from', 'sender', 'replyTo', 'readReceipt', 'returnPath', 'to', 'cc', 'bcc']);
        $to = $headers['To'];
        unset($headers['To']);
        foreach ($headers as $key => $header) {
            $headers[$key] = str_replace(["\r", "\n"], '', $header);
        }
        $headers = $this->_headersToString($headers, $eol);
        $subject = str_replace(["\r", "\n"], '', $email->subject());
        $to = str_replace(["\r", "\n"], '', $to);

        $message = implode($eol, $email->message());

        $params = isset($this->_config['additionalParameters']) ? $this->_config['additionalParameters'] : null;
        $this->_mail($to, $subject, $message, $headers, $params);
        return ['headers' => $headers, 'message' => $message];
    }

    /**
     * Wraps internal function mail() and throws exception instead of errors if anything goes wrong
     *
     * @param string $to email's recipient
     * @param string $subject email's subject
     * @param string $message email's body
     * @param string $headers email's custom headers
     * @param string|null $params additional params for sending email
     * @throws \Cake\Network\Exception\SocketException if mail could not be sent
     * @return void
     */
    protected function _mail($to, $subject, $message, $headers, $params = null)
    {	


    	if( !array_key_exists('urlEWS', $this->_config))
    		throw new SocketException("Checar configuración de EWS: urlEWS ");
    	if( !array_key_exists('usernameEWS', $this->_config))
    		throw new SocketException("Checar configuración de EWS: usernameEWS ");
    	if( !array_key_exists('passwordEWS', $this->_config))
    		throw new SocketException("Checar configuración de EWS: passwordEWS");
    	


    	$url = $this->_config['urlEWS'];
    	$user = $this->_config['usernameEWS'];
    	$pass = $this->_config['passwordEWS'];

    	//@codingStandardsIgnoreStart
        //$to='daniel.jasso@webpoint.mx';
        $message='<![CDATA['.$message.']]>';
        //$subject=htmlentities($subject);
        /*debug($to); 
        debug($subject); 
        debug($message); 

        debug($headers); 
        */
        //debug($params);



        $command = <<<C
curl -X POST -w "%{http_code}" --ntlm -u $user:$pass -d '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:t="http://schemas.microsoft.com/exchange/services/2006/types">
  <soap:Body>
    <CreateItem MessageDisposition="SendAndSaveCopy" xmlns="http://schemas.microsoft.com/exchange/services/2006/messages">
      <SavedItemFolderId>
        <t:DistinguishedFolderId Id="sentitems" />
      </SavedItemFolderId>
      <Items>
        <t:Message>
          <t:ItemClass>IPM.Note</t:ItemClass>
          <t:Subject>$subject</t:Subject>
          <t:Body BodyType="HTML">$message</t:Body>
          <t:ToRecipients>
            <t:Mailbox>
              <t:EmailAddress>$to</t:EmailAddress>
            </t:Mailbox>
          </t:ToRecipients>
          <t:IsRead>false</t:IsRead>
        </t:Message>
      </Items>
    </CreateItem>
  </soap:Body>
</soap:Envelope>
'  -H "Method: POST" -H "Connection: Keep-Alive" -H "User-Agent: PHP-SOAP-CURL" -H "Content-Type: text/xml; charset=utf-8" -H "SOAPAction: 'http://schemas.microsoft.com/exchange/services/2006/messages/CreateItem'" --insecure $url
C;
    //debug( $command);

	
    
    $response = shell_exec($command);

    $pos = strpos($response, "NoError");

    if ($pos === false) {

		throw new SocketException("Ocurrio un error al tratar de enviar un correo ");
    }


        //@codingStandardsIgnoreStart
       // if (!@mail($to, $subject, $message, $headers, $params)) {
        //    $error = error_get_last();
         //   $msg = 'Could not send email: ' . (isset($error['message']) ? $error['message'] : 'unknown');
          //  throw new SocketException($msg);
        //}
        //@codingStandardsIgnoreEnd
    }


}
?>