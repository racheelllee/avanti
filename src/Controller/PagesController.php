<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use Cake\I18n\Time;
use Cake\Network\Email\Email;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{


    public function sucursales(){

        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);

        $this->loadModel('Sucursales');
        $sucursales = $this->Sucursales->find('all', ['conditions' => ['Sucursales.activo' => true, 'Sucursales.deleted' => false]])->toArray();

        $this->set(compact('sucursales'));
        $this->render(null,'front');
        
    }

    public function formasDePago(){

        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);

        $this->loadModel('FormasPagos');
        $formas_pagos = $this->FormasPagos->find('all', ['conditions' => ['FormasPagos.activo' => true], 'order'=>['FormasPagos.orden'=>'ASC']])->toArray();

        $this->set(compact('formas_pagos'));
        $this->render(null,'front');
        
    }

    public function contactanos(){

        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);



        if($this->request->is('post')) {

            $data = $this->request->data;

            $emailObj = new Email('default');
            $emailObj->emailFormat('both');
            $fromConfig = EMAIL_FROM_ADDRESS;
            $fromNameConfig = EMAIL_FROM_NAME;
            $emailObj->from('noresponderwp@gmail.com');
            $emailObj->sender('noresponderwp@gmail.com');
            $emailObj->to(EMAIL_CONTACTO);
            $emailObj->subject(SITE_NAME.': Contacto '.$data['nombre']);
            $body = __('Nombre: {0} <br>Apellido: {1} <br>País: {2} <br>Estado: {3} <br>Email: {4} <br>Teléfono: {5} <br>Mensaje: {6}', [$data['nombre'], $data['apellido'], $data['pais'], $data['estado'], $data['email'], $data['telefono'], $data['mensaje']]);
            try{
                $emailObj->template('default');
                $emailObj->viewVars(array('body' => $body));
                $emailObj->send();
            } catch (Exception $ex){
            }

            $this->Flash->success('<div class="mini-wrapp"><h2>¡Muchas Gracias!</h2><p>Hemos recibido tu información de contacto.</div>');
        }

        
        $this->render(null,'front');
    }

    public function acercaDe(){

        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);


        $this->render(null,'front');
        
    }

    public function enviarWishlist(){

        if($this->request->is('post')) {

            $data = $this->request->data;

            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {


                $emailObj = new Email('default');
                $emailObj->emailFormat('html');
                $fromConfig = EMAIL_FROM_ADDRESS;
                $fromNameConfig = EMAIL_FROM_NAME;
                $emailObj->from('noresponderwp@gmail.com');
                $emailObj->sender('noresponderwp@gmail.com');
                $emailObj->to($data['email']);
                $emailObj->subject(SITE_NAME.': Wishlist');

                $carrito = [];
                if($this->request->session()->check('carrito')) { 
                    $carrito = $this->request->session()->read('carrito');
                }

                try{
                    $emailObj->template('enviar_wishlist');
                    $emailObj->viewVars(array('carrito' => $carrito));
                    $emailObj->send();
                } catch (Exception $ex){
                }

                $this->Flash->success('<div class="mini-wrapp"><h2>¡Muchas Gracias!</h2><p>Enviamos wishlist al correo que proporcionaste.</div>');

            }else{
                $this->Flash->success('<div class="mini-wrapp"><h2>Ocurrio un Error</h2><p>Favor de verificar que tu correo este correcto.</div>');
            }
        }
        
        return $this->redirect($this->referer());

        $carrito = [];
        if($this->request->session()->check('carrito')) { 
            $carrito = $this->request->session()->read('carrito');
        }

        $this->set('carrito', $carrito);

        $this->render(null,'ajax');
    }
}
