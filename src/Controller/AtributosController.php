<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

/**
 * Atributos Controller
 *
 * @property \App\Model\Table\AtributosTable $Atributos
 */

class AtributosController extends AppController
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
			'Atributos'=>[
				'Atributos'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['Atributos.nombre'],
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

        $this->paginate = ['limit'=>10, 'order'=>['Atributos.id'=>'DESC']];
        $this->Search->applySearch();
        $atributos = $this->paginate($this->Atributos)->toArray();
        $this->set(compact('atributos'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_atributos');
        }


    }

    /**
     * View method
     *
     * @param string|null $id Atributo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $atributo = $this->Atributos->get($id, [
            'contain' => ['Productos', 'Opciones']
        ]);
        $this->set('atributo', $atributo);
        $this->set('_serialize', ['atributo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($producto_id = null)
    {
        $this->layout = 'ajax';

        $atributo = $this->Atributos->newEntity();
        if ($this->request->is('post')) {
            $atributo = $this->Atributos->patchEntity($atributo, $this->request->data);


            if ($this->Atributos->save($atributo)) {
                //$this->Flash->success(__('El atributo se guardo.'));
                //return $this->redirect('/productos/edit/'.$atributo->producto_id );
                die(json_encode($atributo));

            } //else {
                //$this->Flash->error(__('El atributo no se pudo guardar.'));
            //}
        }
    
        $atributos = $this->Atributos->find('all', ['conditions' => ['producto_id'=> $producto_id], 'contain'=>['Opciones']]);

        $this->set(compact('atributo', 'producto_id', 'atributos'));
        $this->set('_serialize', ['atributo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Atributo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $atributo = $this->Atributos->get($this->request->data['id'], [
                'contain' => []
            ]);

            $atributo = $this->Atributos->patchEntity($atributo, $this->request->data);
            if ($this->Atributos->save($atributo)) {
                //$this->Flash->success(__('Los cambios en atributo se guardaron.'));
                die(json_encode($atributo));
                //return $this->redirect(['action' => 'index']);
            } //else {
                //$this->Flash->error(__('The atributo could not be saved. Please, try again.'));
            //}
        }
        //$productos = $this->Atributos->Productos->find('list', ['limit' => 200]);
        //$this->set(compact('atributo', 'productos'));
        //$this->set('_serialize', ['atributo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Atributo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        //$this->request->allowMethod(['post', 'delete']);
        if ($this->request->is('post')) {
            $atributo = $this->Atributos->get($this->request->data['atributo_id']);

            if ($this->Atributos->delete($atributo)) {

                $this->loadModel('Opciones');
                $this->Opciones->deleteAll(['atributo_id'=>$this->request->data['atributo_id']]);

                //$this->Flash->success(__('El atributo se elimino.'));

                die(json_encode($atributo));

            } //else {

                //$this->Flash->error(__('El atributo no se pudo eliminar.'));

            //}
        }
        //return $this->redirect('/productos/edit/'.$atributo['producto_id']);
    }
}
