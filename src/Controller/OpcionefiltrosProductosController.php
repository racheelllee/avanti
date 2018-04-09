<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OpcionefiltrosProductos Controller
 *
 * @property \App\Model\Table\OpcionefiltrosProductosTable $OpcionefiltrosProductos
 */
class OpcionefiltrosProductosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Opcionesfiltros', 'Productos']
        ];
        $this->set('opcionefiltrosProductos', $this->paginate($this->OpcionefiltrosProductos));
        $this->set('_serialize', ['opcionefiltrosProductos']);
    }

    /**
     * View method
     *
     * @param string|null $id Opcionefiltros Producto id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $opcionefiltrosProducto = $this->OpcionefiltrosProductos->get($id, [
            'contain' => ['Opcionesfiltros', 'Productos']
        ]);
        $this->set('opcionefiltrosProducto', $opcionefiltrosProducto);
        $this->set('_serialize', ['opcionefiltrosProducto']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        if ($this->request->is('post')) {
            
              
            for ($i=1; $i <= (count($this->request->data)-1)/3; $i++) { 

                if($this->request->data['nuevo'.$i] != '') {

                    $opcionefiltrosProducto = $this->OpcionefiltrosProductos->newEntity();

                    if($this->request->data['actual'.$i] != '') {
                        $opcionefiltrosProducto = $this->OpcionefiltrosProductos->find('all', ['conditions'=>['OpcionefiltrosProductos.id'=>$this->request->data['actual'.$i]]])->first();
                    }

                   

                        $opcionefiltrosProducto['producto_id'] = $this->request->data['producto_id'];
                        $opcionefiltrosProducto['opcionesfiltro_id'] = $this->request->data['nuevo'.$i];
                        $opcionefiltrosProducto['categoria_id'] = $this->request->data['categoria_id'.$i];
                    
                    
                        $this->OpcionefiltrosProductos->save($opcionefiltrosProducto);

                        
                }elseif($this->request->data['actual'.$i] != '') {
                    $opcionefiltrosProducto = $this->OpcionefiltrosProductos->newEntity();
                    $opcionefiltrosProducto = $this->OpcionefiltrosProductos->find('all', ['conditions'=>['OpcionefiltrosProductos.id'=>$this->request->data['actual'.$i]]])->first();
                    $this->OpcionefiltrosProductos->delete($opcionefiltrosProducto);
                }

            }

            die(json_encode($opcionefiltrosProducto));  

            //$this->Flash->success(__('Los filtros se guardaron.'));
            //return $this->redirect('/productos/edit/'.$this->request->data['producto_id']);
           
            /*
            $opcionefiltrosProducto = $this->OpcionefiltrosProductos->patchEntity($opcionefiltrosProducto, $this->request->data);
            if ($this->OpcionefiltrosProductos->save($opcionefiltrosProducto)) {
                $this->Flash->success(__('The opcionefiltros producto has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The opcionefiltros producto could not be saved. Please, try again.'));
            }
            */
        }
        $opcionesfiltros = $this->OpcionefiltrosProductos->Opcionesfiltros->find('list', ['limit' => 200]);
        $productos = $this->OpcionefiltrosProductos->Productos->find('list', ['limit' => 200]);
        $this->set(compact('opcionefiltrosProducto', 'opcionesfiltros', 'productos'));
        $this->set('_serialize', ['opcionefiltrosProducto']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Opcionefiltros Producto id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $opcionefiltrosProducto = $this->OpcionefiltrosProductos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $opcionefiltrosProducto = $this->OpcionefiltrosProductos->patchEntity($opcionefiltrosProducto, $this->request->data);
            if ($this->OpcionefiltrosProductos->save($opcionefiltrosProducto)) {
                $this->Flash->success(__('The opcionefiltros producto has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The opcionefiltros producto could not be saved. Please, try again.'));
            }
        }
        $opcionesfiltros = $this->OpcionefiltrosProductos->Opcionesfiltros->find('list', ['limit' => 200]);
        $productos = $this->OpcionefiltrosProductos->Productos->find('list', ['limit' => 200]);
        $this->set(compact('opcionefiltrosProducto', 'opcionesfiltros', 'productos'));
        $this->set('_serialize', ['opcionefiltrosProducto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Opcionefiltros Producto id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $opcionefiltrosProducto = $this->OpcionefiltrosProductos->get($id);
        if ($this->OpcionefiltrosProductos->delete($opcionefiltrosProducto)) {
            $this->Flash->success(__('The opcionefiltros producto has been deleted.'));
        } else {
            $this->Flash->error(__('The opcionefiltros producto could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
