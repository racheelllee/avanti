<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

use Cake\I18n\Time;

/**
 * Sucursales Controller
 *
 * @property \App\Model\Table\SucursalesTable $sucursales
 */

class SucursalesController extends AppController
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
			'Sucursales'=>[
				'Sucursales'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['Sucursales.name'],
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

        $conditions = ['Sucursales.deleted'=>false];

        $this->paginate = ['limit'=>100, 'order'=>['Sucursales.id'=>'DESC'], 'contain'=>[], 'conditions'=>$conditions];
        $this->Search->applySearch($conditions);
        $sucursales = $this->paginate($this->Sucursales)->toArray();
        $this->set(compact('sucursales'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_sucursales');
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
        $sucursal = $this->Sucursales->get($id, [
            'contain' => []
        ]);
        $this->set('sucursal', $sucursal);
        $this->set('_serialize', ['sucursal']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sucursal = $this->Sucursales->newEntity();
        if ($this->request->is('post')) {

            $sucursal = $this->Sucursales->patchEntity($sucursal, $this->request->data);

            if ($this->Sucursales->save($sucursal)) {
                $this->Flash->success(__('La sucursal se guardo.'));
                return $this->redirect('/list-sucursales');
            } else {
                $this->Flash->error(__('La sucursal no se pudo guardar. Intentalo de nuevo.'));
            }
        }
       
        $this->set(compact('sucursal'));
        $this->set('_serialize', ['sucursal']);
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
        $sucursal = $this->Sucursales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $sucursal = $this->Sucursales->patchEntity($sucursal, $this->request->data);

            if ($this->Sucursales->save($sucursal)) {
                $this->Flash->success(__('La sucursal se guardo.'));
                return $this->redirect('/list-sucursales');
            } else {
                $this->Flash->error(__('La sucursal no se pudo guardar. Intentalo de nuevo.'));
            }
        }
        
        $this->set(compact('sucursal'));
        $this->set('_serialize', ['sucursal']);
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

        $sucursal = $this->Sucursales->get($id);
        $sucursal->deleted = true;

        if ($this->Sucursales->save($sucursal)) {
            $this->Flash->success(__('La sucursal se borro.'));
        } else {
            $this->Flash->error(__('La sucursal no se pudo borrar. Intentalo de nuevo.'));
        }
        return $this->redirect('/list-sucursales');
    }

    public function setInactive($id = null)
    {
        $this->request->allowMethod(['post']);

        $sucursal = $this->Sucursales->get($id);
        $sucursal->activo = false;

        $this->Sucursales->save($sucursal);
        $this->Flash->success(__('La sección quedo inactiva.'));

        return $this->redirect('/list-sucursales');
    }

    public function setActive($id = null)
    {
        $this->request->allowMethod(['post']);
        
        $sucursal = $this->Sucursales->get($id);
        $sucursal->activo = true;

        $this->Sucursales->save($sucursal);
        $this->Flash->success(__('La sección quedo activa.'));

        return $this->redirect('/list-sucursales');
    }
}
