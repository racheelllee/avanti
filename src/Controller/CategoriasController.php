<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;


use Cake\I18n\Time;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 */
class CategoriasController extends AppController
{

    public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor'];

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Usermgmt.Search', 'Cookie'];


    public $searchFields = [
        'index'=>[
            'Categorias'=>[
                'Categorias'=>[
                    'type'=>'text',
                    'label'=>'Buscar',
                    'tagline'=>'Busca por nombre',
                    'condition'=>'multiple',
                    'searchFields'=>['Categorias.nombre'],
                    'inputOptions'=>['style'=>'width:300px;']
                ],
                'Categorias.parent_id'=>[
                    'type'=>'select',
                    'label'=>'Categoría Padre',
                    'model'=>'Categorias',
                    'selector'=>'GetCategorias',
                    'inputOptions'=>['class'=>'select-simple form-control']
                ]
            ]
        ]
    ];

    /**
     * Index method
     *
     * @return void
     */

    public $url;
    public $paginate = [
        'limit' => 50
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function index()
    {

        //$categories = TableRegistry::get('Categories');
        //$this->Categorias->recover();
        
        $this->paginate = ['limit'=>10, 'order'=>['Categorias.orden'=>'ASC'], 'contain'=>'Padre'];
        
        $this->Search->applySearch(['Categorias.deleted'=>false]);
        
        $categorias = $this->paginate($this->Categorias)->toArray();
        $this->set(compact('categorias'));
        
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->render('/Element/all_categorias');
        }

    }


    public function add()
    {
        $categoria = $this->Categorias->newEntity();

        $this->loadModel('Productos');
        $productos = $this->Productos->find('list')->toArray();

        if ($this->request->is('post')) {

            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data); 

            if($this->request->data['imagen_fondo']['error'] == 0 &&  $this->request->data['imagen_fondo']['size'] > 0){

                $ext = explode(".", $this->request->data['imagen_fondo']['name']);
                $nombre =  md5($this->request->data['imagen_fondo']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/categorias/'.$nombre;

                $tmp = $this->request->data['imagen_fondo']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $categoria->imagen_fondo = 'upload/categorias/'.$nombre;
                }
            }

            if($this->request->data['banner']['error'] == 0 &&  $this->request->data['banner']['size'] > 0){

                $ext = explode(".", $this->request->data['banner']['name']);
                $nombre =  md5($this->request->data['banner']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/categorias/'.$nombre;

                $tmp = $this->request->data['banner']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $categoria->banner = 'upload/categorias/'.$nombre;
                }
            }
        
            $orden = $this->Categorias->find('all', ['conditions'=>['parent_id'=>$categoria->parent_id], 'order'=>['orden DESC']])->first();

            if(count($orden)>0){
                $categoria->orden = $orden->orden + 1;
            }else{
                $categoria->orden = 1;
            }
            
            $categoria->publicado = 0;


            if(isset($this->request->data['producto_id'])){
                $categoria->producto_destacado_id = $this->request->data['producto_id'];
            } 

            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('La categoría se guardo.'));
                return $this->redirect('/categorias/edit/'.$categoria->id);
            } else {
                $this->Flash->error(__('La categoría no se pudo guardar.'));
            }
        }

        $categorias = $this->Categorias->find('treeList');


        $this->set(compact('categoria', 'categorias', 'productos'));
        $this->set('_serialize', ['categoria']);
    }



    public function edit($id = null, $orden = null)
    {
        $categoria = $this->Categorias->get($id, [
            'contain' => ['Productos']
        ]);
        $this->loadModel('CategoriasProductos');
        $this->loadModel('Productos');
        $catProductos = $this->CategoriasProductos->find('list', ['keyField'=>'id', 'valueField'=>'producto_id'])
                   ->where('CategoriasProductos.categoria_id ', $id)->toArray();
        $productos = $this->Productos->find('list')
                           ->where(['Productos.id IN' => ($catProductos)? $catProductos : ['']])->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data);

            if(isset($this->request->data['imagen_fondo']) && $this->request->data['imagen_fondo']['error'] == 0 &&  $this->request->data['imagen_fondo']['size'] > 0){

                $ext = explode(".", $this->request->data['imagen_fondo']['name']);
                $nombre =  md5($this->request->data['imagen_fondo']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/categorias/'.$nombre;

                $tmp = $this->request->data['imagen_fondo']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $categoria->imagen_fondo = 'upload/categorias/'.$nombre;
                }
            }    

            if(isset($this->request->data['banner']) && $this->request->data['banner']['error'] == 0 &&  $this->request->data['banner']['size'] > 0){

                $ext = explode(".", $this->request->data['banner']['name']);
                $nombre =  md5($this->request->data['banner']['name'].strtotime(date('Y-m-d H:i:s'))).'.'.$ext[1]; 
                $destino = WWW_ROOT.'upload/categorias/'.$nombre;

                $tmp = $this->request->data['banner']['tmp_name'];

                if(move_uploaded_file($tmp, $destino)){

                   $categoria->banner = 'upload/categorias/'.$nombre;
                }
            }            
            if(isset($this->request->data['producto_id'])){
                $categoria->producto_destacado_id = $this->request->data['producto_id'];
            } 
            if ($this->Categorias->save($categoria)) {

                $this->Flash->success(__('La categoria se guardo.'));

                if($orden){
                    return $this->redirect(['action' => 'index']);
                }else{
                       return $this->redirect(['action' => 'edit',$categoria->id]);
                }

            } else {
                $this->Flash->error(__('La categoria no se pudo guardar.'));
            }
        }

        $categorias = $this->Categorias->find('treeList');

        $this->set(compact('categoria', 'categorias', 'productos'));
        $this->set('_serialize', ['categoria']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoria = $this->Categorias->get($id);

        if($this->Categorias->childCount($categoria) > 0){
            $this->Flash->error(__('No puede eliminar esta categoría porque contiene subcategorías. Elimine primero las subcategorías y vuelva a intentar.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Categorias->delete($categoria)) {
            $this->Flash->success(__('La categoría se elimino.'));
        } else {
            $this->Flash->error(__('La categoría no se pudo eliminar.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function setInactive($id = null)
    {
        $this->request->allowMethod(['post']);

        $categoria = $this->Categorias->get($id);
        $categoria->publicado = false;

        $this->Categorias->save($categoria);
        $this->Flash->success(__('La categoría quedo inactiva.'));

        return $this->redirect(['action' => 'index']);
    }

    public function setActive($id = null)
    {
        $this->request->allowMethod(['post']);
        
        $categoria = $this->Categorias->get($id);
        $categoria->publicado = true;

        $this->Categorias->save($categoria);
        $this->Flash->success(__('La categoría quedo activa.'));

        return $this->redirect(['action' => 'index']);
    }

    /****  FRONT  ****/

    public function home()
    {   
        $this->Categorias->recover();
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('banners1', $datos['banners1']);
        $this->set('banners2', $datos['banners2']);
        $this->set('banners3', $datos['banners3']);
        $this->set('banners4', $datos['banners4']);
        $this->set('banners5', $datos['banners5']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);

        $this->loadModel('Secciones');
        $this->loadModel('Sucursales');

        $time = Time::now(DEFAULT_TIME_ZONE);

        $this->loadModel('Promociones');
        $promociones = $this->Promociones->find('list', [
                    'keyField'=>'id', 'valueField'=>'id',
                    'contain' => [],
                    'conditions' => [
                            '"'.$time->format('Y-m-d').'" BETWEEN DATE(Promociones.vigencia_inicio) AND DATE(Promociones.vigencia_fin)',
                            'Promociones.deleted' => false, 
                            'Promociones.status' => true, 
                    ] ])->toArray();

        $promociones[] = 0;
        
        $secciones = $this->Secciones->find('all', [    
            'contain'=>[
                'SeccionProductos'=>['conditions'=>['"'.$time->format('Y-m-d').'" BETWEEN DATE(SeccionProductos.vigencia_inicio) AND DATE(SeccionProductos.vigencia_fin)']],
                'SeccionProductos.Productos.Imagenes', 'SeccionProductos.Productos.PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]]],
            'conditions'=>[]])->toArray();

        $sucursales = $this->Sucursales->find('all', ['conditions' => ['Sucursales.activo' => true, 'Sucursales.deleted' => false]])->toArray();

        $this->set(compact('secciones', 'sucursales'));
        $this->render(null,'front');

    }

    /**
     * View method
     *
     * @param string|null $id Categoría id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
   
    public function categoria($url = null)
    {
       
        $categorias = $this->Categorias->find('all', [
            'conditions' => ['parent_id is null and publicado=1'],
            'limit' => 50
        ]);

        $subCategorias = $this->Categorias->find('all', [
            'conditions' => ['parent_id is not null and publicado=1']
        ]);

        $categorias_principales = $categorias->toArray();
        $categorias_secundarias = $subCategorias->toArray();

        $this->loadModel('Banners');
        $banner = $this->Banners->find('all');
        $banners = $banner->toArray();

        $this->set(compact('categorias_principales', 'categorias_secundarias', 'banners'));

        $categoria = $this->Categorias->find('all')
            ->where(['Categorias.url' => $url])
            ->first(); 
        //todas las subcategorias
        $subc = $this->Categorias->find('all')
            ->where(['Categorias.parent_id' => $categoria->id,'Categorias.publicado'=>1])
            ->order(['Categorias.orden' => 'ASC']);


        $ids_categoria[]= $categoria->id;

             $crumbs = $this->Categorias->find('path', ['for' => $categoria->id]);

            $this->set('crumbs',$crumbs);


        $subcIds = [];
        $subcIds[] = $categoria->id;
        foreach ($subc as $sub) {
            array_push($subcIds, $sub->id);
             $ids_categoria[]= $sub->id;
        }
        $subcNames = array();
        foreach ($subc as $sub) {
            array_push($subcNames, $sub->nombre);
        }
        $subcBanners = array();
        foreach ($subc as $sub) {
            array_push($subcBanners, $sub->imagen_fondo);
        }
        $subcurls = array();
        foreach ($subc as $sub) {
            array_push($subcurls, $sub->url);
        }

    

        //subcategorias de 2do nivel
        $subc2 = $this->Categorias->find('all')
            ->where(['Categorias.parent_id IN' => $subcIds, 'Categorias.publicado'=>1])
            ->order(['Categorias.orden' => 'ASC']);

        //generando estructura para render
        $categoria_sub = array();
        foreach ($subcIds as $ids) {
            array_push($categoria_sub, array());

            # code...
        }
         $subcount =array();
        foreach ($subc2 as $leaf_cat) {
            $index = array_search($leaf_cat->parent_id, $subcIds); 
            array_push($categoria_sub[$index], $leaf_cat);
            $ids_categoria[]= $leaf_cat->id;

             
                foreach ($subc as $sub) {
                    
                    $subcount[$leaf_cat->id] = $this->Categorias->childCount($leaf_cat);
                }
        

        }





        $conn = ConnectionManager::get('default');
        $marcas = $conn->query('select * from marcas where logo !="" and activo = 1 and  id in ( SELECT  productos.marca_id FROM productos INNER JOIN categorias_productos ON productos.id = categorias_productos.producto_id
    
where   productos.estatus_id =1 and categorias_productos.categoria_id in ('.implode(',', $ids_categoria).') group by (productos.marca_id) ) limit 20')->fetchAll('assoc');

//debug($marcas);
//exit;
        
        $this->set('marcas', $marcas);
        $this->set('categoria', $categoria);
        $this->set('subcNames', $subcNames);
        $this->set('subcBanners', $subcBanners);
        $this->set('subcurls', $subcurls);
        $this->set('subcount', $subcount);
        $this->set('title', $categoria->nombre);
        
        $this->set('categoria_sub', $categoria_sub);
        $this->set('_serialize', ['categoria']);
        $this->render(null,'front');
    }

    public function filtraPrecio($prod_url, $min, $max){

            //die(debug(json_encode($prod_url)));
            // $this->loadModel('Productos');
            // $this->url = $prod_url;
            // $productos = $this->paginate($this->Productos->find('all')
            //                    ->contain(['Imagenes', 'Marcas'])
            //                    ->matching('Categorias', function ($q) {
            //                    return $q->where(['Categorias.url' => $this->url]);
            //                }));

            //die(json_encode($productos));
            $this->redirect(array("controller" => "Categorias", 
                      "action" => "subcategoria"));

    }


    public function subcategoria($url = null, $prod = null)
    {

     
        $this->subcategorias_datos($url , $prod);
        $this->render("subcategoriasmosaico",'front');
  

    }

    private function subcategorias_datos($url , $prod){
        
        $opciones= $this->request->query;
        $this->url = $url;
        
        $this->loadModel('Banners');

        $time = Time::now(DEFAULT_TIME_ZONE);

        // Obtenemos las categorias generales para menu

        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);
        $banner_sub = $this->Banners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 0, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $this->set('banner_sub',$banner_sub);



        $this->loadModel('Precios');
        $all_precios = $this->Precios->find('all', ['conditions'=>['Precios.borrado'=>false], 'order'=>['Precios.orden'=>'ASC']])->toArray();
        $this->set('all_precios',$all_precios);

        // Obtenemos la categoría 
        $categoria = $this->Categorias->find('all')
            ->where(['Categorias.url' => $url])
            ->first();


        $crumbs = $this->Categorias->find('path', ['for' => $categoria->id]);

    
        $catHijos = $this->Categorias->find('children', ['for' => $categoria->id])->find('threaded')->toArray();

        $catsHijosArray = array();
        $catsHijosArray[] = $categoria->id;
        if($catHijos)
        foreach ($catHijos  as $key => $hijo) {
            
            $catsHijosArray[] = $hijo ->id;
            


        }



        //$test = $this->Categorias->moveUp($categoria);
        $mi_nivel = $this->Categorias->getLevel($categoria);

        $padres = [];
        if( $mi_nivel > 1 ){
            //Busco padre de mi padre.
            $padres = array();
            $categoria_padre = $this->Categorias->get($categoria->parent_id);
            $hermanos_padre = $this->Categorias->find('children', ['for' => $categoria_padre->parent_id])->find('threaded')
                ->toArray();
            $padre_nivel = $this->Categorias->getLevel($categoria_padre);
            foreach ($hermanos_padre as $hermano_padre) {
            
                $level = $this->Categorias->getLevel($hermano_padre);
                if( $level == $padre_nivel)
                    $padres[] = $hermano_padre;

            }
        }

        $this->set("padres",$padres);

        if($categoria->parent_id > 0){
            $hermanosT = $this->Categorias->find('children', ['for' => $categoria->parent_id])->find('threaded')
                ->toArray();
        }else{
            $hermanosT = [];
        }

        $hermanos = [];
        foreach ($hermanosT as $hermano) {
            
            $level = $this->Categorias->getLevel($hermano);
            if( $level == $mi_nivel)
                $hermanos[] = $hermano;

        }

        $this->set("hermanos",$hermanos);

        //todas las subcategorias
        $subc = $this->Categorias->find('all')
            ->where(['Categorias.parent_id' => $categoria->id,'Categorias.publicado'=>1])
            ->order(['Categorias.orden' => 'ASC']);



        $subcIds = array();
        $subcNames = array();
        $subcBanners = array();
        $subcurls = array();
        $categoria_sub = array();
        foreach ($subc as $sub) {
            array_push($subcIds, $sub->id);
            array_push($subcNames, $sub->nombre);
            array_push($subcBanners, $sub->imagen_fondo);
            array_push($subcurls, $sub->url);
            $ids_categoria[]= $sub->id;

           array_push ( $categoria_sub, $sub );


        }
        
        

      

    

       

        $this->loadModel('Filtros');
        $filtros = $this->Filtros->find('all', array(
            'conditions'=>array('Filtros.categoria_id =' => $categoria->id),
            'contain' => 'Opcionesfiltros'));

        //Obtenemos el minimo y maximo de los precios

        if( isset($this->request->query['precio'])){
            $precios = array();
            $precio = explode('-', $this->request->query['precio']);
            $precios['min'] = $precio[0];
            $precios['max'] = $precio[1];
            $this->set('precios', $precios);
        }

        if( isset($this->request->query['marca'])){
            $marca = $this->request->query['marca'];
        }
        $i=0;
                //$seleccion="OpcionefiltrosProductos.opcionesfiltro_id is not null ";
                $seleccion = '';
                 foreach($opciones as $k =>$val){
                    if(strpos($k,'art') !== false){
                        //$seleccion .= " and OpcionefiltrosProductos.opcionesfiltro_id =".$val;
                        if($i==0){

                             $seleccion .= 'Productos.id in (select producto_id from opcionefiltros_productos where  opcionefiltros_productos.opcionesfiltro_id='.$val;
                             $i++;

                        }else{

                            $seleccion .= ' and producto_id in (select producto_id from opcionefiltros_productos where  opcionefiltros_productos.opcionesfiltro_id='.$val.')';

                        }
                    }
                 }


        $condiciones = ['Productos.estatus_id'=>1]; 
        $condiciones = ['Productos.deleted'=>0];        
        if(isset($precio)){

          $condiciones['Productos.precio_real <=']=$precios['max'];
          $condiciones['Productos.precio_real >=']=$precios['min'];
          /*$condiciones[] = '(
                (Productos.ver_precio = 1 AND
                Productos.ver_precio_promocion = 0 AND
                Productos.precio <= '.$precios['max'].' AND 
                Productos.precio >= '.$precios['min'].') 
            OR
                (Productos.ver_precio_promocion = 1 AND
                Productos.precio_promocion <= '.$precios['max'].' AND 
                Productos.precio_promocion >= '.$precios['min'].')
            )'; */
        }
        if(isset($marca)){
          $condiciones['Marcas.nombre']=$marca;
        }
        if($seleccion !=''){
          //$condiciones[$seleccion.')']=true;
          array_push($condiciones, $seleccion.')');
        }
        
        $sort='precio_real ASC';
        if( isset($this->request->query['sort'])){
            $sort = $this->request->query['sort'];    
        }
        
        $this->loadModel('Promociones');
        $time = Time::now(DEFAULT_TIME_ZONE);
        $promociones = $this->Promociones->find('list', [
                    'keyField'=>'id', 'valueField'=>'id',
                    'contain' => [],
                    'conditions' => [
                            '"'.$time->format('Y-m-d').'" BETWEEN DATE(Promociones.vigencia_inicio) AND DATE(Promociones.vigencia_fin)',
                            'Promociones.deleted' => false, 
                            'Promociones.status' => true, 
                    ] ])->toArray();
        $promociones[] = 0;
        
        $productos = $this->Categorias->Productos->find('all')
            ->distinct(['Productos.id'])
            ->contain(['Imagenes', 'Marcas', 'Atributos.Opciones', 'OpcionefiltrosProductos', 'PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]]])
            ->where($condiciones)
            ->where(function ($exp, $q) {
                return $exp->isNull('padre_id');
            })
            ->matching('Categorias', function ($q) use ($catsHijosArray) {
                           return $q->where( [ 'Categorias.id IN' => $catsHijosArray,'Productos.estatus_id'=>1,'Productos.deleted'=>0]);
                    })
           ->order (['Productos.'.$sort]);


        $marcas = $this->Categorias->Productos->find('all', ['fields'=>'Marcas.nombre'])
                           ->contain(['Marcas'])
                           ->group('Productos.marca_id')
                           ->matching('Categorias', function ($q)  use ($catsHijosArray)  {
                           return $q->where([ 'Categorias.id IN ' => $catsHijosArray ,'Productos.estatus_id'=>1,'Productos.deleted'=>0]);
                    });

        

        $precio_productos = $this->Categorias->Productos->find('all')
          ->matching('Categorias', function ($q)  use ($catsHijosArray) {
          return $q->where([ 'Categorias.id IN ' => $catsHijosArray ]);
          });

        $precio_productos->select(['max' => $precio_productos->func()->max('Productos.precio'), 'min' => $precio_productos->func()->min('Productos.precio')]);
        $precio_productos = $precio_productos->toArray();
        //debug($precio_productos); die();

        $precio_global = array();
        $precio_global['min'] = $precio_productos[0]['min'];
        $precio_global['max'] = $precio_productos[0]['max'];
        $this->set('precios_globales', $precio_global);



        //die(debug($marcas->toArray()));
        /*
        $marcas = array();
        foreach ($productos as $key => $producto) {
            $marcas[$producto['marca']['nombre']] = 1;
        }
        */

        

        // obtener arbol de categorias

        $treeList = $this->Categorias->find('treeList',['for' => $categoria->id]);

        $this->set('treeList', $treeList);

        $this->set('crumbs',$crumbs);
               
        
        $this->set('filtros', $filtros);

        $this->set('categoria', $categoria);
     
        $this->set('categoria_sub', $categoria_sub);
       

        $this->set('marcas', $marcas);
        $this->set('productos', $this->paginate($productos));
        $this->set('_serialize', ['categorias']);
        $this->set('opciones', $opciones);

    }

     
   public function subcategorialista($url = null, $prod = null)
    {

        
        
        $this->subcategorias_datos($url , $prod);

        $this->render(null,'front');
  

    }
}
