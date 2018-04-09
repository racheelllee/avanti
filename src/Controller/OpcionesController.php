<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Opciones Controller
 *
 * @property \App\Model\Table\OpcionesTable $Opciones
 */
class OpcionesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('opciones', $this->Opciones->find('all'));
        $this->set('_serialize', ['opciones']);
    }

    /**
     * View method
     *
     * @param string|null $id Opcion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $opcion = $this->Opciones->get($id, [
            'contain' => ['Atributos']
        ]);
        $this->set('opcion', $opcion);
        $this->set('_serialize', ['opcion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $opcion = $this->Opciones->newEntity();
        if ($this->request->is('post')) {
            
            $opcion = $this->Opciones->patchEntity($opcion, $this->request->data);

            if ($this->Opciones->save($opcion)) {
                //$this->Flash->success(__('La opcion se ha guardado.'));
                //return $this->redirect('/productos/edit/'.$this->request->data['producto_id']);

                die(json_encode($opcion));

            } //else {
                //$this->Flash->error(__('La opcion no se pudo guardar.'));
           // }
        }
    
        $this->set(compact('opcion', 'atributos'));
        $this->set('_serialize', ['opcion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Opcion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            $opcion = $this->Opciones->get($this->request->data['id'], [
                'contain' => []
            ]);

            $opcion = $this->Opciones->patchEntity($opcion, $this->request->data);
            if ($this->Opciones->save($opcion)) {

                die(json_encode($opcion));

                //$this->Flash->success(__('The opcion has been saved.'));
                //return $this->redirect(['action' => 'index']);
            } //else {
                //$this->Flash->error(__('The opcion could not be saved. Please, try again.'));
            //}
        }
        //$atributos = $this->Opciones->Atributos->find('list', ['limit' => 200]);
        //$this->set(compact('opcion', 'atributos'));
        //$this->set('_serialize', ['opcion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Opcion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
        //$this->request->allowMethod(['post', 'delete']);
        if ($this->request->is('post')) {
            $opcion = $this->Opciones->get($this->request->data['opcion_id']);
    
            if ($this->Opciones->delete($opcion)) {
                //$this->Flash->success(__('La opcion se elimino.'));

                die(json_encode($opcion));
            } //else {
                //$this->Flash->error(__('La opcion no se pudo eliminar.'));
            //}
        }
        //return $this->redirect('/productos/edit/'.$producto_id);
    }
}
