<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Opcionesfiltros Controller
 *
 * @property \App\Model\Table\OpcionesfiltrosTable $Opcionesfiltros
 */
class OpcionesfiltrosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('opcionesfiltros', $this->Opcionesfiltros->find('all'));
        $this->set('_serialize', ['opcionesfiltros']);
    }

    /**
     * View method
     *
     * @param string|null $id Opcionesfiltro id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $opcionesfiltro = $this->Opcionesfiltros->get($id, [
            'contain' => ['Filtros', 'OpcionefiltrosProductos']
        ]);
        $this->set('opcionesfiltro', $opcionesfiltro);
        $this->set('_serialize', ['opcionesfiltro']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $opcionesfiltro = $this->Opcionesfiltros->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['nombre']= $this->request->data['opcion'];
            $opcionesfiltro = $this->Opcionesfiltros->patchEntity($opcionesfiltro, $this->request->data);
            if ($this->Opcionesfiltros->save($opcionesfiltro)) {
                //$this->Flash->success(__('The opcionesfiltro has been saved.'));
                //return $this->redirect('categorias/edit/'.$this->request->data['categoria_id']);
                die(json_encode($opcionesfiltro)); 

            } //else {
                //$this->Flash->error(__('The opcionesfiltro could not be saved. Please, try again.'));
            //}
        }
        $filtros = $this->Opcionesfiltros->Filtros->find('list', ['limit' => 200]);
        $this->set(compact('opcionesfiltro', 'filtros'));
        $this->set('_serialize', ['opcionesfiltro']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Opcionesfiltro id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {

    
        $opcionesfiltro = $this->Opcionesfiltros->get($this->request->data['id'], [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put','get'])) {
            $opcionesfiltro = $this->Opcionesfiltros->patchEntity($opcionesfiltro, $this->request->data);
            if ($this->Opcionesfiltros->save($opcionesfiltro)) {
                die(json_encode($opcionesfiltro));
            } else {
                
            }
        }
       
        $this->set(compact('opcionesfiltro'));
        $this->set('_serialize', ['opcionesfiltro']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Opcionesfiltro id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        //$this->request->allowMethod(['post', 'delete']);
        if ($this->request->is('post')) {
            $opcionesfiltro = $this->Opcionesfiltros->get($this->request->data['opcion_id']);
            if ($this->Opcionesfiltros->delete($opcionesfiltro)) {
                //$this->Flash->success(__('The opcionesfiltro has been deleted.'));
                die(json_encode($opcionesfiltro));

            } //else {
                //$this->Flash->error(__('The opcionesfiltro could not be deleted. Please, try again.'));
            //}
        }

        //header ('location:'.');
        //$actualizar = $_SERVER['HTTP_REFERER'];
        //return $this->redirect($actualizar);
    }
}
