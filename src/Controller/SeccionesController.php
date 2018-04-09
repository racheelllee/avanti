<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

use Cake\I18n\Time;

/**
 * Secciones Controller
 *
 * @property \App\Model\Table\SeccionesTable $secciones
 */

class SeccionesController extends AppController
{






    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor'];

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Usermgmt.Search'];

    /**
     * Paginate 
     *
     * @var array
     */
    public $paginate = ['limit' => '25'];

	/**
	 * This controller uses search filters in following functions for ex index, online function
	 *
	 * @var array
	 */
	public $searchFields = [
		'index'=>[
			'Secciones'=>[
				'Secciones'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['Secciones.nombre'],
					'inputOptions'=>['style'=>'width:300px;']
				]
			]
		]
	];
	

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {   

        $conditions = [];

        $this->paginate = ['limit'=>100, 'order'=>['Secciones.id'=>'DESC'], 'contain'=>[], 'conditions'=>$conditions];
        $this->Search->applySearch($conditions);
        $secciones = $this->paginate($this->Secciones)->toArray();
        $this->set(compact('secciones'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_Secciones');
        }


    }

    /**
     * View method
     *
     * @param string|null $id seccion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seccion = $this->Secciones->get($id, [
            'contain' => []
        ]);
        $this->set('seccion', $seccion);
        $this->set('_serialize', ['seccion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seccion = $this->Secciones->newEntity();
        if ($this->request->is('post')) {

            $seccion = $this->Secciones->patchEntity($seccion, $this->request->data);

            if ($this->Secciones->save($seccion)) {
                $this->Flash->success(__('El seccion se guardo.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El seccion no se pudo guardar. Intentalo de nuevo.'));
            }
        }
       
        $this->set(compact('seccion'));
        $this->set('_serialize', ['seccion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id seccion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seccion = $this->Secciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $seccion = $this->Secciones->patchEntity($seccion, $this->request->data);

            if ($this->Secciones->save($seccion)) {
                $this->Flash->success(__('El seccion se guardo.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El seccion no se pudo guardar. Intentalo de nuevo.'));
            }
        }
        
        $this->set(compact('seccion'));
        $this->set('_serialize', ['seccion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id seccion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $seccion = $this->Secciones->get($id);
        $seccion->deleted = true;

        if ($this->Secciones->save($seccion)) {
            $this->Flash->success(__('El seccion se borro.'));
        } else {
            $this->Flash->error(__('El seccion no se pudo borrar. Intentalo de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function busquedaProducto($palabra = null, $categoria = null)
    {
        $this->layout = 'ajax';

        $this->loadModel('Productos');

        $conditions = array();
        $busca = 0;
        if($palabra != 'null'){
            $conditions['AND'][] = array('Productos.nombre LIKE' => '%'.$palabra.'%');
            $busca = 1;
        }



        $busqueda_productos = array();
        if($busca == 1 AND $categoria == 'null'){
            $busqueda_productos = $this->Productos->find('all', ['conditions'=>$conditions]); 
        }elseif($categoria != 'null'){
            $busqueda_productos = $this->Productos->find('all', ['conditions'=>$conditions, 'contain'=>['CategoriasProductos']])->matching(
            'CategoriasProductos', function ($q) use ($categoria) {
            return $q->where(['CategoriasProductos.categoria_id' => $categoria]);
            });
        }
        
        

        $this->loadModel('Categorias');
        $categorias = $this->Categorias->find('treeList', ['spacer' => '-']);
        

        $this->set(compact('busqueda_productos', 'categorias'));
    }

    public function listProducto($seccion_id = null)
    {

        $this->layout = 'ajax';

        if ($this->request->is('post')) {

            

            if(isset($this->request->data['producto_relacionados'])){
                for ($i=0; $i < count($this->request->data['producto_relacionados']); $i++) { 
                    $a=0;
                    
                    $complementosProducto = $this->Secciones->SeccionProductos->newEntity();
                    
                    $complementosProducto->producto_id = $this->request->data['producto_relacionados'][$i];
                    
                    $complementosProducto->seccion_id = $seccion_id;
                    
                    $this->Secciones->SeccionProductos->save($complementosProducto);
                    
                }

                die(json_encode($complementosProducto));
            }else{

                
                foreach ($this->request->data['productos'] as $k => $data) {
                    $producto = $this->Secciones->SeccionProductos->get($k);

                    $producto->vigencia_inicio = (!empty($data['vigencia_inicio']))? new Time(str_replace('/','-', @$data['vigencia_inicio']),  DEFAULT_TIME_ZONE  ) : '';
                    $producto->vigencia_fin = (!empty($data['vigencia_fin']))? new Time(str_replace('/','-', @$data['vigencia_fin']),  DEFAULT_TIME_ZONE  ) : '';
                    $producto->nombre_promocion = $data['nombre_promocion'];
                    $producto->nombre_promocion_background = $data['nombre_promocion_background'];
                    $producto->nombre_promocion_color = $data['nombre_promocion_color'];

                    $this->Secciones->SeccionProductos->save($producto);
                }

                return $this->redirect(['action' => 'edit', $seccion_id]);

            }
        }


        $productos_relacionados = $this->Secciones->SeccionProductos->find('all', ['conditions'=>['seccion_id'=>$seccion_id], 'contain'=>['Productos']]);

        $this->set(compact('complementosProducto', 'productos_relacionados'));
        $this->set('_serialize', ['complementosProducto']);

    }

    public function deleteProducto()
    {
        if ($this->request->is('post')) {
            $producto = $this->Secciones->SeccionProductos->get($this->request->data['producto_relacionado_id']);
            if ($this->Secciones->SeccionProductos->delete($producto)) {
                die(json_encode($producto));
            }
        }
    }

    public function setInactive($id = null)
    {
        $this->request->allowMethod(['post']);

        $seccion = $this->Secciones->get($id);
        $seccion->status = false;

        $this->Secciones->save($seccion);
        $this->Flash->success(__('La sección quedo inactiva.'));

        return $this->redirect(['action' => 'index']);
    }

    public function setActive($id = null)
    {
        $this->request->allowMethod(['post']);
        
        $seccion = $this->Secciones->get($id);
        $seccion->status = true;

        $this->Secciones->save($seccion);
        $this->Flash->success(__('La sección quedo activa.'));

        return $this->redirect(['action' => 'index']);
    }
}
