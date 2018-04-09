<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

/**
 * CategoriasProductos Controller
 *
 * @property \App\Model\Table\CategoriasProductosTable $CategoriasProductos
 */

class CategoriasProductosController extends AppController
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
			'CategoriasProductos'=>[
				'CategoriasProductos'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['CategoriasProductos.nombre'],
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

        $this->paginate = ['limit'=>10, 'order'=>['CategoriasProductos.id'=>'DESC']];
        $this->Search->applySearch();
        $categoriasProductos = $this->paginate($this->CategoriasProductos)->toArray();
        $this->set(compact('categoriasProductos'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_categoriasProductos');
        }


    }

    /**
     * View method
     *
     * @param string|null $id Categorias Producto id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriasProducto = $this->CategoriasProductos->get($id, [
            'contain' => ['Categorias', 'Productos']
        ]);
        $this->set('categoriasProducto', $categoriasProducto);
        $this->set('_serialize', ['categoriasProducto']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($producto_id = null,$blank=null)
    {
        $this->layout = 'ajax';
        $categoriasProducto = $this->CategoriasProductos->newEntity();

        if ($this->request->is('post')) {

            $categoriasProducto = $this->CategoriasProductos->patchEntity($categoriasProducto, $this->request->data);


            if ($this->CategoriasProductos->save($categoriasProducto)) {
                die(json_encode($categoriasProducto));

            } 
        }


        $this->loadModel('Categorias');
        $categorias = $this->Categorias->find('treeList', ['spacer' => '-']);


        $categorias_producto = $this->CategoriasProductos->find('all', [
            'conditions' => ['CategoriasProductos.producto_id' => $producto_id, 'Categorias.deleted' => false], 
            'contain' => ['Categorias', 'Categorias.Filtros', 'Categorias.Filtros.Opcionesfiltros']
            ]);

        $this->loadModel('OpcionefiltrosProductos');
        $OpcionefiltrosProductos = $this->OpcionefiltrosProductos->find('list', [
            'conditions' => ['producto_id' => $producto_id],
            'keyField' => 'opcionesfiltro_id', 'valueField' => 'id'
            ])->toArray();


        $this->set(compact('categoriasProducto', 'categorias', 'producto_id', 'categorias_producto', 'OpcionefiltrosProductos'));
        $this->set('_serialize', ['categoriasProducto']);
        
        if($blank){
            $this->layout = 'blank';
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Categorias Producto id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriasProducto = $this->CategoriasProductos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriasProducto = $this->CategoriasProductos->patchEntity($categoriasProducto, $this->request->data);
            if ($this->CategoriasProductos->save($categoriasProducto)) {
                $this->Flash->success(__('The categorias producto has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The categorias producto could not be saved. Please, try again.'));
            }
        }
        $categorias = $this->CategoriasProductos->Categorias->find('list', ['limit' => 200]);
        $productos = $this->CategoriasProductos->Productos->find('list', ['limit' => 200]);
        $this->set(compact('categoriasProducto', 'categorias', 'productos'));
        $this->set('_serialize', ['categoriasProducto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Categorias Producto id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        //$this->request->allowMethod(['post', 'delete']);
        if ($this->request->is('post')) {
            $categoriasProducto = $this->CategoriasProductos->get($this->request->data['categoria_id']);

            $this->loadModel('OpcionefiltrosProductos');
            //$OpcionesFiltros = $this->OpcionefiltrosProductos->find('all', ['conditions' => ['categoria_id'=>$categoriasProducto['categoria_id'], 'producto_id'=>$categoriasProducto['producto_id']]]);


            if ($this->CategoriasProductos->delete($categoriasProducto)) {

                try {
                    
                
                $this->OpcionefiltrosProductos->deleteAll(['categoria_id'=>$categoriasProducto['categoria_id'], 'producto_id'=>$categoriasProducto['producto_id']]);

                } catch (\Exception $e) {
                    
                }

                //$this->Flash->success(__('The categorias producto has been deleted.'));
            } //else {
                //$this->Flash->error(__('The categorias producto could not be deleted. Please, try again.'));
            //}

            die(json_encode($categoriasProducto));

        }

        //return $this->redirect('/productos/edit/'.$categoriasProducto->producto_id);
        
    }
}
