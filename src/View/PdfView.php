<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\Core\Exception\Exception;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\View\View;
/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class PdfView extends View
{

     
    public $html2pdf = null;
    private $__filename;
    public $subDir = 'pdf';
    private $_descargar = TRUE;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
    }

    public function verNavegador(){

        $this->_descargar = FALSE;
    }

    public function __construct(Request $request = null, Response $response = null, EventManager $eventManager = null, array $viewOptions = [])
    {
        parent::__construct($request, $response, $eventManager, $viewOptions);

       
        if (isset($viewOptions['name']) && $viewOptions['name'] == 'Error') {
            $this->subDir = null;
            $this->layoutPath = null;
            $response->type('html');

            return;
        }


        if( $this->response->type() == 'application/pdf' )
            $this->html2pdf = new \HTML2PDF('P','LETTER','es');
    }


    /**
     * [render description]
     * @param  [type] $action [description]
     * @param  [type] $layout [description]
     * @param  [type] $file   [description]
     * @return [type]         [description]
     */
    public function render($action = null, $layout = null, $file = null)
    {   


        $content = parent::render($action, false, $file);

       
        if ($this->response->type() != 'application/pdf' ) {
            return $content;
        }

        //$this->setFilename("resporte");


        $this->html2pdf->WriteHTML($content );
       
        

        
       

        if($this->_descargar){
            $content = $this->html2pdf->Output('' ,True);
            $this->response->download($this->getFilename());

        }else{

            $pdf = $this->html2pdf->Output($this->getFilename() , FALSE);
           
           
        }
         $this->Blocks->set('content', $content);

        return $this->Blocks->get('content');
    }





    public function setFilename($filename)
    {
        $this->__filename = $filename;
    }

    public function getFilename()
    {
        if (!empty($this->__filename)) {
            return $this->__filename . '.pdf';
        }
        return Inflector::slug($this->request->url) . '.pdf';
    }
}
