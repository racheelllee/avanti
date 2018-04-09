<?php
namespace App\Controller;

use App\Controller\AppController;

use Usermgmt\Controller\UsermgmtAppController;
use Cake\View\CellTrait; 
use Cake\Mailer\Email;

/**
 * Poblacionmx Controller
 *
 * @property \App\Model\Table\PoblacionmxTable $Poblacionmx
 */
class PoblacionmxController extends AppController
{
	use CellTrait;

	 /**
     * Helpers
     *
     * @var array
     */
    public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor','Usermgmt.Search'];

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
    public $paginate = ['limit' => '100'];


    /**
     * This controller uses search filters in following functions for ex index, online function
     *
     * @var array
     */
    public $searchFields = [
        'index'=>[
            'Poblacionmx'=>[
                'Poblacionmx'=>[
                    'type'=>'text',
                    'label'=>'Buscar',
                    'tagline'=>'<br>Busca por ID',
                    'condition'=>'multiple',
                    'searchFields'=>['Poblacionmx.id'],
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
        $this->paginate = ['limit'=>10, 'order'=>['Poblacionmx.id'=>'DESC']];
        $this->Search->applySearch();
        $poblacionmx = $this->paginate($this->Poblacionmx)->toArray();
        $this->set(compact('poblacionmx'));

        if($this->request->is('ajax')) {
            $this->viewBuilder()->layout('ajax');
            $this->render('/Element/all_poblacionmx');
        }

        //$this->set('poblacionmx', $this->Poblacionmx->find('all'));
        //$this->set('_serialize', ['poblacionmx']);
    }

    /**
     * View method
     *
     * @param string|null $id Poblacionmx id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $poblacionmx = $this->Poblacionmx->get($id, [
            'contain' => []
        ]);
        $this->set('poblacionmx', $poblacionmx);
        $this->set('_serialize', ['poblacionmx']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $poblacionmx = $this->Poblacionmx->newEntity();
        if ($this->request->is('post')) {
            $poblacionmx = $this->Poblacionmx->patchEntity($poblacionmx, $this->request->data);
            if ($this->Poblacionmx->save($poblacionmx)) {
                $this->Flash->success(__('The poblacionmx has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The poblacionmx could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('poblacionmx'));
        $this->set('_serialize', ['poblacionmx']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Poblacionmx id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $poblacionmx = $this->Poblacionmx->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $poblacionmx = $this->Poblacionmx->patchEntity($poblacionmx, $this->request->data);
            if ($this->Poblacionmx->save($poblacionmx)) {
                $this->Flash->success(__('The poblacionmx has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The poblacionmx could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('poblacionmx'));
        $this->set('_serialize', ['poblacionmx']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Poblacionmx id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $poblacionmx = $this->Poblacionmx->get($id);
        if ($this->Poblacionmx->delete($poblacionmx)) {
            $this->Flash->success(__('The poblacionmx has been deleted.'));
        } else {
            $this->Flash->error(__('The poblacionmx could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
