<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

/**
 * ComplementosProductos Controller
 *
 * @property \App\Model\Table\ComplementosProductosTable $ComplementosProductos
 */

class ComplementosProductosController extends AppController
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
			'ComplementosProductos'=>[
				'ComplementosProductos'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['ComplementosProductos.nombre'],
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

        $this->paginate = ['limit'=>10, 'order'=>['ComplementosProductos.id'=>'DESC']];
        $this->Search->applySearch();
        $complementosProductos = $this->paginate($this->ComplementosProductos)->toArray();
        $this->set(compact('complementosProductos'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_complementosProductos');
        }


    }

    /**
     * View method
     *
     * @param string|null $id Complementos Producto id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $complementosProducto = $this->ComplementosProductos->get($id, [
            'contain' => []
        ]);
        $this->set('complementosProducto', $complementosProducto);
        $this->set('_serialize', ['complementosProducto']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($producto_id = null)
    {

        $this->layout = 'ajax';

        if ($this->request->is('post')) {

            //$complementosProducto=null;

            for ($i=0; $i < count($this->request->data['producto_relacionados']); $i++) { 
                $a=0;
                //debug($a++);
                $complementosProducto = $this->ComplementosProductos->newEntity();
                //debug($a++);
                $complementosProducto->complemento_id = $this->request->data['producto_relacionados'][$i];
                //debug($a++);
                $complementosProducto->producto_id = $producto_id;
                //debug($a++);
                $this->ComplementosProductos->save($complementosProducto);
                //debug($a++);
            }

            die(json_encode($complementosProducto));

            /*
            
            if ($this->ComplementosProductos->save($complementosProducto)) {
                $this->Flash->success(__('The complementos producto has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The complementos producto could not be saved. Please, try again.'));
            }*/
        }


        $productos_relacionados = $this->ComplementosProductos->find('all', ['conditions'=>['producto_id'=>$producto_id], 'contain'=>['Complementos']]);

        //die(debug($productos_relacionados->toArray()));

        $this->set(compact('complementosProducto', 'productos_relacionados'));
        $this->set('_serialize', ['complementosProducto']);

    }

    public function busqueda($palabra = null, $categoria = null, $proveedor = null, $marca = null,$masiva=0)
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
        $this->loadModel('Marcas');
        $marcas = $this->Marcas->find('list',['order'=>'nombre']);
        $this->loadModel('Proveedores');
        $proveedores = $this->Proveedores->find('list',['order'=>'nombre']);

        $this->set(compact('busqueda_productos', 'categorias', 'marcas', 'proveedores','masiva'));
        

    }

    /**
     * Edit method
     *
     * @param string|null $id Complementos Producto id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $complementosProducto = $this->ComplementosProductos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complementosProducto = $this->ComplementosProductos->patchEntity($complementosProducto, $this->request->data);
            if ($this->ComplementosProductos->save($complementosProducto)) {
                $this->Flash->success(__('The complementos producto has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The complementos producto could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('complementosProducto'));
        $this->set('_serialize', ['complementosProducto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Complementos Producto id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        //$this->request->allowMethod(['post', 'delete']);
        if ($this->request->is('post')) {
            $complementosProducto = $this->ComplementosProductos->get($this->request->data['producto_relacionado_id']);
            if ($this->ComplementosProductos->delete($complementosProducto)) {
                die(json_encode($complementosProducto));
                //$this->Flash->success(__('The complementos producto has been deleted.'));
            } //else {
                //$this->Flash->error(__('The complementos producto could not be deleted. Please, try again.'));
            //}
        }
        //return $this->redirect(['action' => 'index']);
    }
}
