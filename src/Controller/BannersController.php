<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

use Cake\I18n\Time;

/**
 * Banners Controller
 *
 * @property \App\Model\Table\BannersTable $Banners
 */

class BannersController extends AppController
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
			'Banners'=>[
				'Banners'=>[
					'type'=>'text',
					'label'=>'Buscar',
					'tagline'=>'Busca por nombre',
					'condition'=>'multiple',
					'searchFields'=>['Banners.nombre'],
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

        $conditions = ['Banners.deleted' => 0];

        $this->paginate = ['limit'=>100, 'order'=>['Banners.id'=>'DESC'], 'contain'=>['BannersTipo'], 'conditions'=>$conditions];
        $this->Search->applySearch($conditions);
        $banners = $this->paginate($this->Banners)->toArray();
        $this->set(compact('banners'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_banners');
        }


    }

    /**
     * View method
     *
     * @param string|null $id Banner id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => []
        ]);
        $this->set('banner', $banner);
        $this->set('_serialize', ['banner']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('BannersTipo');

        $banner = $this->Banners->newEntity();
        if ($this->request->is('post')) {

            $banner = $this->Banners->patchEntity($banner, $this->request->data);

            if($this->request->data['imagen']['error'] == 0 &&  $this->request->data['imagen']['size'] > 0){

                $ext = explode(".", $this->request->data['imagen']['name']);
                $nombre =  md5($this->request->data['imagen']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/banner/'.$nombre;

                $tmp = $this->request->data['imagen']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $banner->imagen = 'upload/banner/'.$nombre;
                }
            }

            if(!empty($this->request->data['vigencia_inicio'])){
                $banner->vigencia_inicio = new Time(str_replace('/','-', @$this->request->data['vigencia_inicio']),  DEFAULT_TIME_ZONE  );
            }

            if(!empty($this->request->data['vigencia_fin'])){
                $banner->vigencia_fin = new Time(str_replace('/','-', @$this->request->data['vigencia_fin']),  DEFAULT_TIME_ZONE  );
            }

            $banner->status = true;

            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('El banner se guardo.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El banner no se pudo guardar. Intentalo de nuevo.'));
            }
        }
        $tipos = $this->BannersTipo->find('list');
        $this->set(compact('banner','tipos'));
        $this->set('_serialize', ['banner']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Banner id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $banner = $this->Banners->patchEntity($banner, $this->request->data);
            

            if($this->request->data['imagen']['error'] == 0 &&  $this->request->data['imagen']['size'] > 0){

                $ext = explode(".", $this->request->data['imagen']['name']);
                $nombre =  md5($this->request->data['imagen']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/banner/'.$nombre;

                $tmp = $this->request->data['imagen']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $banner->imagen = 'upload/banner/'.$nombre;
                }
            }

            if(!empty($this->request->data['vigencia_inicio'])){
                $banner->vigencia_inicio = new Time(str_replace('/','-', @$this->request->data['vigencia_inicio']),  DEFAULT_TIME_ZONE  );
            }

            if(!empty($this->request->data['vigencia_fin'])){
                $banner->vigencia_fin = new Time(str_replace('/','-', @$this->request->data['vigencia_fin']),  DEFAULT_TIME_ZONE  );
            }

            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('El banner se guardo.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El banner no se pudo guardar. Intentalo de nuevo.'));
            }
        }
        $this->loadModel('BannersTipo');
        $tipos = $this->BannersTipo->find('list');
        $this->set(compact('banner','tipos'));
        $this->set('_serialize', ['banner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $banner = $this->Banners->get($id);
        $banner->deleted = true;

        if ($this->Banners->save($banner)) {
            $this->Flash->success(__('El banner se borro.'));
        } else {
            $this->Flash->error(__('El banner no se pudo borrar. Intentalo de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
