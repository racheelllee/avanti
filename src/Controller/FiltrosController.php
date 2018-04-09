<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Filtros Controller
 *
 * @property \App\Model\Table\FiltrosTable $Filtros
 */
class FiltrosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('filtros', $this->Filtros->find('all'));
        $this->set('_serialize', ['filtros']);
    }

    /**
     * View method
     *
     * @param string|null $id Filtro id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $filtro = $this->Filtros->get($id, [
            'contain' => ['Categorias', 'Opcionesfiltros']
        ]);
        $this->set('filtro', $filtro);
        $this->set('_serialize', ['filtro']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($categoria_id = null)
    {
        $this->layout = 'ajax';

        $filtro = $this->Filtros->newEntity();
        if ($this->request->is('post')) {
            $filtro = $this->Filtros->patchEntity($filtro, $this->request->data);

            if ($this->Filtros->save($filtro)) {
                //$this->Flash->success(__('The filtro has been saved.'));
                //return $this->redirect('categorias/edit/'.$this->request->data['categoria_id']);

                die(json_encode($filtro));  
            } //else {
                //$this->Flash->error(__('The filtro could not be saved. Please, try again.'));
            //}
        }
        
        $filtros = $this->Filtros->find('all', array(
            'conditions' => array('categoria_id'=>$categoria_id), 
            'contain' => array('Opcionesfiltros')
            ));


        $this->set(compact('filtro', 'filtros', 'categoria_id'));
        $this->set('_serialize', ['filtro']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Filtro id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $filtro = $this->Filtros->get($this->request->data['id'], [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
           
            $filtro = $this->Filtros->patchEntity($filtro, $this->request->data);
            if ($this->Filtros->save($filtro)) {
                $this->Flash->success(__('El filtro ha sido editado.'));
                
            } else {
               
            }
        }



       $this->redirect(['controller'=>'categorias','action' => 'edit',$$this->request->data['categoria_id']]);

        $this->set(compact('filtro', 'categorias'));
        $this->set('_serialize', ['filtro']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Filtro id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null,$categoria)
    {

 $this->request->allowMethod(['post', 'delete','get']);

   $filtro = $this->Filtros->get($id);
       if ($this->Filtros->delete($filtro)) {
               $this->Flash->success(__('El filtro ha sido eliminado.'));
               
            } 

        $this->redirect(['controller'=>'categorias','action' => 'edit',$categoria]);


    }
}
