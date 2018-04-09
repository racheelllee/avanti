<?php
namespace Customers\Controller;

use Customers\Controller\AppController;

/**
 * Customers Controller
 *
 * @property \Customers\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{

    public $helpers = ['Usermgmt.Search'];
    public $paginate = ['limit' => '100'];
    public $components = ['Usermgmt.Search'];

    public $searchFields = [
        'index' => [
            'Customers' => [
                'Customers.title' => [
                    'type' => 'text',
                    'label' => 'Razón Social',
                    'tagline' => '',
                    'conditions' => 'like',
                    'searchFields' => 'Customers.title',
                ],
                'Customers.business_name' => [
                    'type' => 'text',
                    'label' => 'Razón Comercial',
                    'tagline' => '',
                    'conditions' => 'like',
                    'searchFields' => 'Customers.business_name',
                ],
                'Customers.customer_status_id' => [
                    'model' => 'Customers.CustomerStatuses',
                    'type' => 'select',
                    'label' => 'Estado',
                    'tagline' => '',
                    'selector' => 'statusList',
                    'conditions' => '=',
                    'searchFields' => 'Customers.customer_status_id',
                    'inputOptions'=>['class'=>'select-simple']
                ],
            ],
        ],
    ];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $page = __d('customers', 'Customers');
        $conditions[] = ['Customers.deleted' => 0];
        $customer = $this->Customers->newEntity();
        $this->paginate = [
            'conditions' => $conditions,
            'contain' => [
                'CustomerCategories',
                'Offices',
                'CustomerTypes',
                'CustomerHeadcounts',
                'Users',
                'CustomerStatuses',
                'Franquicias',
            ],
        ];
        $this->Search->applySearch($conditions);
        $customers = $this->paginate($this->Customers);
        $customerCategories = $this->Customers->CustomerCategories->find('list', ['limit' => 200]);
        $offices = $this->Customers->Offices->find('list', ['limit' => 200]);
        $customerTypes = $this->Customers->CustomerTypes->find('list', ['limit' => 200]);
        $customerHeadcounts = $this->Customers->CustomerHeadcounts->find('list', ['limit' => 200]);
        $franquicias = $this->Customers->Franquicias->find('list', ['limit' => 200]);

        $this->set(compact(
            'customer',
            'customers',
            'customerCategories',
            'offices',
            'customerTypes',
            'customerHeadcounts',
            'franquicias'
        ));
        $this->set('_serialize', ['customers']);

        if($this->request->is('ajax')) {
            $this->viewBuilder()->layout('ajax');
            $this->render('Customers.Element/Customers/all_customers');
        }

    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $page = 'Clientes';
        $customer = $this->Customers->get($id, [
          'contain' => [
            'CustomerCategories',
            'Offices',
            'CustomerTypes',
            'CustomerHeadcounts',
            'Contacts',
            'Users',
            'CustomerStatuses',
            'Franquicias',
          ]
        ]);
        $this->set(compact('customer', 'page'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__d('customers', 'The customer has been saved'));

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__d('customers', 'The customer could not be saved. Please, try again'));
            }
        }
        $customerCategories = $this->Customers->CustomerCategories->find('list', ['limit' => 200]);
        $offices = $this->Customers->Offices->find('list', ['limit' => 200]);
        $customerTypes = $this->Customers->CustomerTypes->find('list', ['limit' => 200]);
        $customerHeadcounts = $this->Customers->CustomerHeadcounts->find('list', ['limit' => 200]);
        $franquicias = $this->Customers->Franquicias->find('list', ['limit' => 200]);
        $sellers = $this->Customers->Users->usersList();
        $statusList = $this->Customers->CustomerStatuses->statusList(true);
        $this->set(compact(
            'customer',
            'customerCategories',
            'offices',
            'customerTypes',
            'customerHeadcounts',
            'franquicias',
            'sellers',
            'statusList'
        ));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Franquicias']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
            $customer->customer_since = $this->request->data('customer_since');
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__d('customers', 'The customer has been saved.'));

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__d('customers', 'The customer could not be saved. Please, try again'));
            }
        }
        $customerCategories = $this->Customers->CustomerCategories->find('list', ['limit' => 200]);
        $offices = $this->Customers->Offices->find('list', ['limit' => 200]);
        $customerTypes = $this->Customers->CustomerTypes->find('list', ['limit' => 200]);
        $customerHeadcounts = $this->Customers->CustomerHeadcounts->find('list', ['limit' => 200]);
        $franquicias = $this->Customers->Franquicias->find('list', ['limit' => 200]);
        $sellers = $this->Customers->Users->usersList();
        $statusList = $this->Customers->CustomerStatuses->statusList(true);
        $this->set(compact(
            'customer',
            'customerCategories',
            'offices',
            'customerTypes',
            'franquicias',
            'customerHeadcounts',
            'sellers',
            'statusList'
        ));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $contact = $this->Customers->get($id);
        if ($this->Customers->delete($contact)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again'));
        }
        return $this->redirect($this->referer());
    }

    /**
     * verifyRfc method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     */
    public function verifyRfc($customerId = 0)
    {
      $conditions = ['rfc' => $this->request->query('rfc')];

      if ($customerId) {
        $conditions['id !='] = $customerId;
      }

      $this->response->body('');

      $customerExists = $this->Customers->exists($conditions);

      $code = $customerExists ? 200 : 404;
      $this->response->statusCode($code);

      return $this->response;
    }
}
