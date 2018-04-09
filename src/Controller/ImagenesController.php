<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Imagenes Controller
 *
 * @property \App\Model\Table\ImagenesTable $Imagenes
 */
class ImagenesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index($producto_id = null)
    {

        if ($this->request->is('post')) {

            if($this->request->is('ajax')) {
            
                if($this->request->data['file']['error'] == 0 &&  $this->request->data['file']['size'] > 0){

                    $ext = explode(".", $this->request->data['file']['name']);
                    $nombre =  $producto_id.'-'.md5($this->request->data['file']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                    $destino = WWW_ROOT.'upload/productos/'.$nombre;

                    $tmp = $this->request->data['file']['tmp_name'];

                    if(move_uploaded_file($tmp, $destino)){

                        $imagen = $this->Imagenes->newEntity();

                        $imagen['producto_id'] = $producto_id;
                        $imagen['nombre'] = $nombre;
                        $imagen['nombre_real'] = $this->request->data['file']['name'];
                        $imagen['size'] = $this->request->data['file']['size'];

                        $this->Imagenes->save($imagen);
                        
                        die(json_encode($imagen->id));
                    }
                }
                
            }else{

                $imagen = $this->Imagenes->get($this->request->data['id']);
                $imagen = $this->Imagenes->patchEntity($imagen, $this->request->data);

                if ($this->Imagenes->save($imagen)) {
            
                } else {
                    $this->Flash->error(__('El orden no se pudo guardar.'));
                }
            }
        }

        $this->set('imagenes', $this->Imagenes->find('all',['conditions'=>['producto_id'=>$producto_id], 'order' => ['orden' => 'ASC']]));
        $this->set('_serialize', ['imagenes']);
        $this->set('producto_id',$producto_id);
        $this->render(null,'iframe');
    }

    /**
     * View method
     *
     * @param string|null $id Imagen id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imagen = $this->Imagenes->get($id, [
            'contain' => ['Productos']
        ]);
        $this->set('imagen', $imagen);
        $this->set('_serialize', ['imagen']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($producto_id = null)
    {
        $imagen = $this->Imagenes->newEntity();
        if ($this->request->is('post')) {

            
             if(count($this->request->data['imagenes']) > 0){
                foreach ($this->request->data['imagenes'] as $imagen_upload) {
                    $this->validPathFiles( $imagen_upload ) ;
                    $imagen = $this->Imagenes->newEntity();

                    $imagen['producto_id'] = $this->request->data['producto_id'];
                    $imagen['nombre'] = $imagen_upload['name'];

                    $ruta = '/mnt/stor11-wc2-dfw1/496430/981757/tienda.padmont.com.mx/web/content/webroot/img/productos/original/'.$imagen_upload['name'];
                    $ruta = FRONT_WWW_ROOT.'/img/productos/original/'.$imagen_upload['name'];
                    
                    $tmp = $imagen_upload['tmp_name'];
                    move_uploaded_file($tmp, $ruta);

                    $this->Imagenes->save($imagen);
                }


                $this->Flash->success(__('La imagen ha sido agregada.'));
                return $this->redirect(['action' => 'index', $this->request->data['producto_id']]);
            }

            /*
            $imagen = $this->Imagenes->patchEntity($imagen, $this->request->data);
            
             if($this->request->data['nombre']['tmp_name'] != ''){
                
                    $ruta = '/var/www/html/app/webroot/img/productos/original/'.$this->request->data['nombre']['name'];
                    //$ruta = WWW_ROOT.'img/'.$this->request->data['nombre']['name'];
                    //debug($ruta);
                    //die;
                    $tmp = $this->request->data['nombre']['tmp_name'];
                    move_uploaded_file($tmp, $ruta);
                    $imagen->nombre = $this->request->data['nombre']['name'];
                }


            if ($this->Imagenes->save($imagen)) {
                $this->Flash->success(__('La imagen ha sido agregada.'));
                return $this->redirect(['action' => 'index',$imagen->producto_id]);
            } else {
                $this->Flash->error(__('The imagen could not be saved. Please, try again.'));
            }

            */
        }
       
        $this->set(compact('imagen'));
        $this->set('_serialize', ['imagen']);
          $this->set('producto_id',$producto_id);
        $this->render(null,'iframe');
    }

    /**
     * Edit method
     *
     * @param string|null $id Imagen id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imagen = $this->Imagenes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imagen = $this->Imagenes->patchEntity($imagen, $this->request->data);
            if ($this->Imagenes->save($imagen)) {
                $this->Flash->success(__('The imagen ha sido editada.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La imagen no pudo ser editada, intente de nuevo.'));
            }
        }
        $productos = $this->Imagenes->Productos->find('list', ['limit' => 200]);
        $this->set(compact('imagen', 'productos'));
        $this->set('_serialize', ['imagen']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Imagen id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imagen = $this->Imagenes->get($id);
        if ($this->Imagenes->delete($imagen)) {
            
        } else {
            $this->Flash->error(__('La imagen no pudo ser eliminada, intente de nuevo.'));
        }
        return $this->redirect(['action' => 'index',$imagen->producto_id]);
    }
}
