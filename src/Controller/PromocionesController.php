<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use PDF_Code128; 
use MP; 

use Cake\Routing\Router;

/**
 * Promociones Controller
 *
 * @property \App\Model\Table\PromocionesTable $Promociones
 */
class PromocionesController extends AppController
{   
    public $components = ['Usermgmt.Search', 'Cewi/Excel.Import']; 

    public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor'];

    public $paginate = [
    // Other keys here.
    'limit' => 50
    ];


    public $searchFields = [
        'index'=>[
            'Promociones'=>[
                'Promociones'=>[
                    'type'=>'text',
                    'label'=>'Search',
                    'tagline'=>'Buscar por nombre, usuario, email',
                    'condition'=>'multiple',
                    'searchFields'=>['Promociones.nombre'],
                    'inputOptions'=>['style'=>'width:200px;']
                ]
            ]
        ]
    ];


    public function index()
    {   
        $conditions = ['Promociones.deleted'=>false];

        $this->paginate = ['limit'=>10, 'order'=>['Promociones.id'=>'DESC'], 'conditions'=>$conditions];

        $this->Search->applySearch($conditions);

        $promociones = $this->paginate($this->Promociones)->toArray();
        $this->set(compact('promociones'));


        if($this->request->is('ajax')) {
            $this->viewBuilder()->layout('ajax');
            $this->render('/Element/all_promociones');
        }
    }


    public function add()
    {
        $promocion = $this->Promociones->newEntity();

        if ($this->request->is('post')) {

            $promocion = $this->Promociones->patchEntity($promocion, $this->request->data);

            if(!empty($this->request->data['vigencia_inicio'])){
                $promocion->vigencia_inicio = new Time(str_replace('/','-', @$this->request->data['vigencia_inicio']),  DEFAULT_TIME_ZONE  );
            }

            if(!empty($this->request->data['vigencia_fin'])){
                $promocion->vigencia_fin = new Time(str_replace('/','-', @$this->request->data['vigencia_fin']),  DEFAULT_TIME_ZONE  );
            }
           
            if ($this->Promociones->save($promocion)) {
               $this->Flash->success(__('El promocion se guardo.'));
                return $this->redirect('/promociones/edit/'.$promocion->id);
            } else {
                $this->Flash->error(__('La promocion no se pudo guardar.'));
            }
            
            
        }
       
        $this->set(compact('promocion'));
        $this->set('_serialize', ['promocion']);
    }

    public function edit($id = null, $orden = null)
    {

        $promocion = $this->Promociones->get($id, ['contain'=>['PromocionProductos']]);

        $promosArray = [];
        $promosFile = '';

        if ($this->request->is(['patch', 'post', 'put'])) {

            if(isset($this->request->data['upload-file']) && move_uploaded_file($this->request->data['upload-file']['tmp_name'], TMP.$this->request->data['upload-file']['name'])){

                $this->Promociones->addBehavior('ImportExcel');
               
                $file =  TMP.$this->request->data['upload-file']['name'];

                $options = $this->Promociones->getOptionsForExcel();
                $promosArray = $this->Promociones->prepareArrayData($file, $options); 
                $promosArray = $this->Promociones->validationExcel($promosArray, $id);

                $promosFile = $file;
            }else{

                $promocion = $this->Promociones->patchEntity($promocion, $this->request->data);


                if(!empty($this->request->data['vigencia_inicio'])){
                    $promocion->vigencia_inicio = new Time(str_replace('/','-', @$this->request->data['vigencia_inicio']),  DEFAULT_TIME_ZONE  );
                }

                if(!empty($this->request->data['vigencia_fin'])){
                    $promocion->vigencia_fin = new Time(str_replace('/','-', @$this->request->data['vigencia_fin']),  DEFAULT_TIME_ZONE  );
                }

            
                if ($this->Promociones->save($promocion)) {
                    $this->Flash->success(__('Los cambios del promocion se guardaron.'));

                    if($orden){
                        return $this->redirect('/promociones');
                    }else{
                        return $this->redirect('/promociones/edit/'.$id);
                    }
                } else {
                    $this->Flash->error(__('No se pudo guardar los cambios del promocion.'));
                }
            }
        }

        $this->set(compact('promosArray', 'promosFile'));
       
        $this->set(compact('promocion'));
        $this->set('_serialize', ['promocion']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $promocion = $this->Promociones->get($id);
        $promocion->deleted = true;
        if ($this->Promociones->save($promocion)) {
            $this->Flash->success(__('El promocion fue borrado.'));
        } else {
            $this->Flash->error(__('El promocion no se pudo borrar. Intentalo de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function addProducts($promocion_id = null){
        if ($this->request->is(['patch', 'post', 'put'])) {

            if(!empty($this->request->data['promosFile'])){

                $this->Promociones->addBehavior('ImportExcel');
               
                $file =  $this->request->data['promosFile'];

                $options = $this->Promociones->getOptionsForExcel();
                $promosArray = $this->Promociones->prepareArrayData($file, $options); 
                $promosArray = $this->Promociones->validationExcel($promosArray, $promocion_id);

                foreach ($promosArray as $key => $promo) {

                    $producto = $this->Promociones->PromocionProductos->newEntity();
                    if(isset($promo['id'])){
                        $producto = $this->Promociones->PromocionProductos->get($promo['id']);
                    }
                
                    $producto = $this->Promociones->PromocionProductos->patchEntity($producto, $promo);
                    $producto->promocion_id = $promocion_id;

                    if($producto->ver_precio || $producto->ver_precio_promocion){
                        $producto->precio_real = ($producto->ver_precio_promocion)? $producto->precio_promocion : $producto->precio;
                    }else{
                        $producto->precio_real = 0; 
                    }
                    
                    $this->Promociones->PromocionProductos->save($producto);
                }
            }

        }

        return $this->redirect(['action' => 'edit', $promocion_id]);
    }

    public function setInactive($id = null)
    {
        $this->request->allowMethod(['post']);

        $promocion = $this->Promociones->get($id);
        $promocion->status = false;

        $this->Promociones->save($promocion);
        $this->Flash->success(__('La promoción quedo inactiva.'));

        return $this->redirect(['action' => 'index']);
    }

    public function setActive($id = null)
    {
        $this->request->allowMethod(['post']);
        
        $promocion = $this->Promociones->get($id);
        $promocion->status = true;

        $this->Promociones->save($promocion);
        $this->Flash->success(__('La promoción quedo activa.'));

        return $this->redirect(['action' => 'index']);
    }

    public function suscribirme()
    {

        if ($this->request->is('post') && filter_var($this->request->data['email'], FILTER_VALIDATE_EMAIL)) {

            $this->loadModel('PromocionesSuscriptores');

            $suscriptor = $this->PromocionesSuscriptores->newEntity();

            $suscriptor = $this->PromocionesSuscriptores->patchEntity($suscriptor, $this->request->data);

            $suscriptor->ip = $this->request->clientIp();
           
            if ($this->PromocionesSuscriptores->save($suscriptor)) {
                $this->Flash->success('<div class="mini-wrapp"><h2>¡Muchas Gracias!</h2><p>Ahora podras recibir nuestras promociones.</div>');
                return $this->redirect($this->referer());
            }
             
        }

        $this->Flash->error('<div class="mini-wrapp"><h2>¡Lo Sentimos!</h2><p>Ocurrio un error al intentar suscribirte.</div>');
        return $this->redirect($this->referer());
       
        $this->set(compact('promocion'));
        $this->set('_serialize', ['promocion']);
    }

    public function suscriptores()
    {
        $this->loadModel('PromocionesSuscriptores');
        $suscriptores = $this->PromocionesSuscriptores->find('all')->toArray();

        $this->helpers = ['Cewi/Excel.Excel'=>[]];

        $this->set(compact('suscriptores'));
    }

    public function productos($promocion_id = null)
    {
        $promocion = $this->Promociones->get($promocion_id, ['contain'=>['PromocionProductos']]);

        $this->helpers = ['Cewi/Excel.Excel'=>[]];

        $this->set(compact('promocion'));
    }
}
