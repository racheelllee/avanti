<?php
namespace Customers\Controller;

//use App\Controller\AppController;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $contact = $this->Contacts->newEntity();
        $this->paginate = [
            'conditions' => ['Contacts.deleted' => 0],
            'contain' => ['Customers']
        ];
        $contacts = $this->paginate($this->Contacts);
        $customers = $this->Contacts->Customers->find('list', ['limit' => 200]);
        $this->set(compact('contact', 'contacts', 'customers'));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('contact', $contact);
        $this->set('_serialize', ['contact']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($customer_id = 0)
    {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('El contacto ha sido guardado.'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('El contacto no se pudo guardar. Por favor, intente nuevamente.'));
            }
        }
        $customers = $this->Contacts->Customers->find('list', ['limit' => 200]);
        $contactTypes = $this->Contacts->ContactTypes->find('list', ['limit' => 200]);
        $this->set(compact('contact', 'customers', 'customer_id', 'contactTypes'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $customer_id)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('El contacto ha sido guardado.'));

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('El contacto no se pudo guardar. Por favor, intente nuevamente.'));
            }
        }
        $customers = $this->Contacts->Customers->find('list', ['limit' => 200]);
        $contactTypes = $this->Contacts->ContactTypes->find('list', ['limit' => 200]);
        $this->set(compact('contact', 'customers', 'customer_id', 'contactTypes'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('El contacto ha sido borrado.'));
        } else {
            $this->Flash->error(__('El contacto no se pudo borrar. Por favor, intente nuevamente.'));
        }
        return $this->redirect($this->referer());
    }
}
