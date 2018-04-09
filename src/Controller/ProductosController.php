<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use PDF_Code128; 
use MP; 

use Cake\Routing\Router;

/**
 * Productos Controller
 *
 * @property \App\Model\Table\ProductosTable $Productos
 */
class ProductosController extends AppController
{   
    public $components = ['Usermgmt.Search'];

    public $helpers = ['Usermgmt.Tinymce', 'Usermgmt.Ckeditor'];

    public $paginate = [
    // Other keys here.
    'limit' => 50
    ];


    public $searchFields = [
        'index'=>[
            'Productos'=>[
                'Productos'=>[
                    'type'=>'text',
                    'label'=>'Search',
                    'tagline'=>'Buscar por nombre, usuario, email',
                    'condition'=>'multiple',
                    'searchFields'=>['Productos.nombre'],
                    'inputOptions'=>['style'=>'width:200px;']
                ],
                'Productos.cat_id'=>[
                    'type'=>'select',
                    'label'=>'Categorias',
                    'model'=>'Categorias',
                    'selector'=>'GetCategorias',
                    'inputOptions'=>['class'=>'select-simple form-control']
                ]
            ]
        ]
    ];

    public $categoria_id = null;

    public function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);


        $sesion= $this->request->session();
        $var = $sesion->read('UserAuth.Search.Productos.index');
      
        if($this->request->params['action'] == 'index'){
            if(isset($this->request->data['Productos']['cat_id'])){
               
               $this->categoria_id = $this->request->data['Productos']['cat_id'];
               unset($this->request->data['Productos']['cat_id']);
           }else{
                $sesion->delete('UserAuth.Search.Productos.index.Productos.cat_id');
                $this->categoria_id = $var['Productos']['cat_id'];
           }
        }

        if(isset($this->request->data['search_clear']) && $this->request->data['search_clear'] ==1){
               $this->categoria_id = '';
        }



    }


    public function index()
    {   
        $conditions = ['Productos.deleted'=>false];
        
        if(!is_null($this->categoria_id) && $this->categoria_id !=''){
            
            $this->loadModel('Categorias');
            $hijos = $this->Categorias->find('children', ['for'=>$this->categoria_id])->find('list', ['keyField'=>'id', 'valueField'=>'id'])->toArray(); 
            $hijos[] = $this->categoria_id;

            $productos_ids = $this->Categorias->Productos->find('list')
            ->matching('Categorias', function ($q) use ($hijos) {
                           return $q->where( [ 'Categorias.id IN' => $hijos,'Productos.deleted'=>0]);
                    })->toArray();
            
            $conditions[] = ['Productos.id IN'=>array_keys($productos_ids)];
        } 

        $this->paginate = ['limit'=>10, 'order'=>['Productos.id'=>'DESC'],'contain'=>['productosEstatuses', 'Categorias'], 'conditions'=>$conditions];

        $this->Search->applySearch($conditions);

        $productos = $this->paginate($this->Productos)->toArray();
        $this->set(compact('productos'));

        if(!is_null($this->categoria_id) && $this->categoria_id !=''){
            $sesion=$this->request->session();
            $sesion->write('UserAuth.Search.Productos.index.Productos.cat_id',$this->categoria_id);
            $this->request->data['Productos']['cat_id'] = $this->categoria_id;
        }

        $this->set('search_categoria',$this->categoria_id);

        if($this->request->is('ajax')) {
            $this->viewBuilder()->layout('ajax');
            $this->render('/Element/all_productos');
        }
    }


    public function add()
    {
        $producto = $this->Productos->newEntity();

        if ($this->request->is('post')) {

            $producto = $this->Productos->patchEntity($producto, $this->request->data);

            if($producto['activo'] == true){
                $producto['fecha_publicacion'] = date('Y-m-d H:m:s');
            }
            
            $producto['meta_titulo'] = $producto['nombre'];
            $producto['meta_descripcion'] = $producto['descripcion_corta'];

            $meta_keywords = [];
            if(preg_match_all("#<strong>(.*?)</strong>#s", $producto['descripcion_larga'],$matches))
            {
                $num_matches = count($matches[1]);
                for ($i = 0; $i < $num_matches; $i++) {
                    $meta_keywords[] = $matches[1][$i];
                }
            }
             
            $producto['meta_keywords'] =  strtolower(implode(',', $meta_keywords));

            $producto['usuario_id'] =  $this->UserAuth->getUserId();

           
            if ($this->Productos->save($producto)) {
               $this->Flash->success(__('El producto se guardo.'));
                return $this->redirect('/productos/edit/'.$producto->id);
            } else {
                $this->Flash->error(__('La producto no se pudo guardar.'));
            }
            
            
        }

        $estatus = $this->Productos->ProductosEstatuses->find('list');
       
        $this->set(compact('estatus', 'producto'));
        $this->set('_serialize', ['producto']);
    }

    public function url_existente()
    {
        if ($this->request->is('post')) {

            $busca_url = $this->Productos->find('all', ['conditions' => ['Productos.url' => $this->request->data['url']]])->first();

            die(json_encode(count($busca_url)));
        }
    }

    public function edit($id = null)
    {

        $producto = $this->Productos->get($id, ['contain'=>['PromocionProductos.Promociones']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $producto = $this->Productos->patchEntity($producto, $this->request->data);


            if($producto['activo'] == true){
                $producto['fecha_publicacion'] = date('Y-m-d H:m:s');
            }


            if(isset($this->request->data['edit_precio'])){
                if($producto['ver_precio'] || $producto['ver_precio_promocion']){
                    $producto['precio_real'] = ($producto['ver_precio_promocion'])? $producto['precio_promocion'] : $producto['precio'];
                }else{
                    $producto['precio_real'] = 0; 
                }
                $producto['modified_precios'] = date('Y-m-d H:m:s');
            }


            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('Los cambios del producto se guardaron.'));
                return $this->redirect('/productos/edit/'.$id);
            } else {
                $this->Flash->error(__('No se pudo guardar los cambios del producto.'));
            }
        }
       

        $categorias = $this->Productos->Categorias->find('treeList', ['spacer' => '-']);
        $categoria_relacionada = $this->Productos->ComplementosCategorias->find('all')->where(['producto_id'=>$id])->first();

        $this->set(compact('producto', 'categorias', 'categoria_relacionada'));
        $this->set('_serialize', ['producto']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $producto = $this->Productos->get($id);
        $producto->deleted = true;
        if ($this->Productos->save($producto)) {
            $this->Flash->success(__('El producto fue borrado.'));
        } else {
            $this->Flash->error(__('El producto no se pudo borrar. Intentalo de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function setInactive($id = null)
    {
        $this->request->allowMethod(['post']);

        $producto = $this->Productos->get($id);
        $producto->activo = false;
        $producto->estatus_id = false;

        $this->Productos->save($producto);
        $this->Flash->success(__('El producto quedo inactivo.'));

        return $this->redirect(['action' => 'index']);
    }

    public function setActive($id = null)
    {
        $this->request->allowMethod(['post']);
        
        $producto = $this->Productos->get($id);
        $producto->activo = true;
        $producto->estatus_id = true;

        $this->Productos->save($producto);
        $this->Flash->success(__('El producto quedo activo.'));

        return $this->redirect(['action' => 'index']);
    }


    /*----- FRONT ------*/

    public function detalle($url = null,$comentario =null)
    {   
        
        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);

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
        
        $producto = $this->Productos->find('all')
            ->contain(['Imagenes','Promociones','Atributos.Opciones','Complementos.Imagenes','Categorias.Productos.Imagenes','Marcas','ComplementosCategorias','Comentarios','Fichas', 'PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]],
                'Complementos.PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]],
                'Categorias.Productos.PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]]

                ])
            ->where(['Productos.url' => $url])
            ->first();

        if($producto->promocion_productos){
            unset($producto->promocion_productos[0]['id']);
            unset($producto->promocion_productos[0]['promocion_id']);
            unset($producto->promocion_productos[0]['producto_id']);
           
            foreach ($producto->promocion_productos[0]->toArray() as $key => $value) {
                $producto[$key] = $value;
            }
        }

        if($producto->complementos){
            foreach ($producto->complementos as $k => $complemento) {
                if($producto->complementos[$k]->promocion_productos){
                    unset($producto->complementos[$k]->promocion_productos[0]['id']);
                    unset($producto->complementos[$k]->promocion_productos[0]['promocion_id']);
                    unset($producto->complementos[$k]->promocion_productos[0]['producto_id']);
                   
                    foreach ($producto->complementos[$k]->promocion_productos[0]->toArray() as $key => $value) {
                        $producto->complementos[$k][$key] = $value;
                    }
                }
            }
        }

        if($producto->categorias){
            foreach ($producto->categorias as $c => $categoria) {
                foreach ($producto->categorias[$c]->productos as $k => $producto_categoria) {
                    if($producto->categorias[$c]->productos[$k]->promocion_productos){
                        unset($producto->categorias[$c]->productos[$k]->promocion_productos[0]['id']);
                        unset($producto->categorias[$c]->productos[$k]->promocion_productos[0]['promocion_id']);
                        unset($producto->categorias[$c]->productos[$k]->promocion_productos[0]['producto_id']);
                       
                        foreach ($producto->categorias[$c]->productos[$k]->promocion_productos[0]->toArray() as $key => $value) {
                            $producto->categorias[$c]->productos[$k][$key] = $value;
                        }
                    }
                }
            }
        }

        if(count( $producto->categorias[0]->productos->where  > 0)){
            $existe = array();
            foreach ($producto->categorias[0]->productos as $key => $value) {
                        
                if( in_array( $value->id  , $existe)){

                    unset($producto->categorias[0]->productos[$key]);

                }else{
                    $existe[] =  $value->id ;

                }
                    
            }
        }
        
        if(isset($producto->complementos_categoria->categoria_id)){
                
            $conditions['AND'][]= array('Productos.estatus_id in (1,3)');
            $conditions['AND'][]= array('Productos.precio>0');
                
            $categoria=$producto->complementos_categoria->categoria_id;
            $busqueda_productos = $this->Productos->find('all', 
                    ['conditions'=>$conditions, 'contain'=>['CategoriasProductos','Imagenes']])
                ->matching('CategoriasProductos', function ($q) use ($categoria) {
                return $q->where(['CategoriasProductos.categoria_id' => $categoria]);
                })->toArray();
                
            foreach($busqueda_productos as $p){
                array_push($producto->complementos,$p);
            }

        }

        $similares=$producto->categorias[0]->productos;
        shuffle($similares);
        $similares = array_slice($similares, 0, 20);
        $this->set('similares',$similares);   

        $ruta = Router::url(null, true); 
        $this->set('ruta',$ruta);    
        
        $this->set('comentariorecibo',$comentario);    
        $this->set('producto', $producto);
        $this->set('_serialize', ['producto']);
        $this->set('hoy',new Time());
        $this->render(null,'front');
    }


 

    public function buscar($buscar= null, $marca = null)
    {

        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);

        if(!$buscar){
            $this->request->data['data']['Producto']['buscar'] = str_replace(array('<', '>', '&', '{', '}', '*','/','-detail'), array('-'), $this->request->data['data']['Producto']['buscar']);
            $this->redirect('/productos/buscar/'.urlencode($this->request->data['data']['Producto']['buscar']));
        }

        if($buscar){
            $buscar = str_replace(array('<', '>', '&', '{', '}', '*','/','-detail'), array('-'), $buscar);
    
            $this->request->data['data']['Producto']['buscar']= $buscar;

        } 

        $cat = $this->Productos->Categorias->find('list', ['keyField'=>'id', 'valueField'=>'id'])
            ->where(['Categorias.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%"'])->toArray();

        $this->loadModel('CategoriasProductos');
        $catProductos = $this->CategoriasProductos->find('list', ['keyField'=>'id', 'valueField'=>'producto_id'])
            ->where(['CategoriasProductos.categoria_id IN'=>($cat)? $cat : ['']])->toArray();


        if(isset($this->request->data['data']['Producto']) && $this->request->data['data']['Producto']['buscar']){

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
            
            $productos = $this->Productos->find('all')
                   ->contain(['PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]], 'Imagenes'])
                   ->where([
                            'OR'=>[
                                'Productos.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.descripcion_corta like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.descripcion_larga like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.sku like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.meta_keywords like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.meta_descripcion like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.meta_titulo like "%'.$this->request->data['data']['Producto']['buscar'].'%"',
                                'Productos.id IN' => ($catProductos)? $catProductos : ['']
                            ],

                            'Productos.estatus_id'=>1
                        ]);


            $this->set('buscar', $buscar);
            $this->set('marca_id', $marca);
            $this->set('marcas', $marcas);
            $this->set('productos', $productos);
            $this->set('_serialize', ['productos']);
            ///$this->render('../Categorias/subcategoria','front');
            $this->render(null,'front');

        }else{

            $this->redirect('/');
        }

      
    }


    public function buscarlista($buscar= null, $marca = null)
    {


        if($buscar){
            $this->request->data['data']['Producto']['buscar']= $buscar;
        }

     
        
        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);




        if($this->request->data['data']['Producto']['buscar'] or $this->request->data['data']['Producto']['buscar']=="-1"){

            if($marca){
                if($this->request->data['data']['Producto']['buscar']=="-1"){
                    $productos = $this->Productos->find('all')
                       ->contain(['Imagenes', 'Marcas', 'Atributos.Opciones'])
                       ->where(function ($exp, $q) {
                            return $exp->isNull('padre_id');
                         })
                       ->where(['Marcas.id = '.$marca,'Productos.estatus_id'=>1]);
                        $this->set('productos', $this->paginate($productos));

                }else{

                    $productos = $this->Productos->find('all')
                       ->contain(['Imagenes', 'Marcas', 'Atributos.Opciones'])
                       ->where(function ($exp, $q) {
                            return $exp->isNull('padre_id');
                        })
                       ->where(['(Productos.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%" or Productos.sku like "%'.$this->request->data['data']['Producto']['buscar'].'%" or Marcas.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%" ) and Marcas.id = '.$marca,'Productos.estatus_id'=>1]);
                    $this->set('productos', $this->paginate($productos));
                }
                

            }else{

                $productos = $this->Productos->find('all')
                   ->contain(['Imagenes', 'Marcas', 'Atributos.Opciones'])
                   ->where(function ($exp, $q) {
                        return $exp->isNull('padre_id');
                    })
                   ->where(['((Productos.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%" or Productos.sku like "%'.$this->request->data['data']['Producto']['buscar'].'%" or Marcas.nombre like "%'.$this->request->data['data']['Producto']['buscar'].'%")  or Marcas.nombre = "'.$buscar.'") and Productos.estatus_id=1']);
                $this->set('productos', $this->paginate($productos));
            }

       
            $marcas = array();
            foreach ($productos as $key => $producto) {
                $marcas[$producto['marca']['nombre']] = $producto['marca']['id'];
            }

        }else{

            //error 

          //  $this->Flash->error('La busqueda no pudo realizarse');
        }

        $this->set('buscar', $buscar);
        $this->set('marca_id', $marca);
        $this->set('marcas', $marcas);
        $this->set('_serialize', ['productos']);
        $this->render(null,'front');
    }



    public function carrito()
    {
        $this->loadModel('Categorias');
        $datos = $this->Categorias->datosGenerales();
        $this->set('categorias', $datos['categorias']);
        $this->set('banners', $datos['banners']);
        $this->set('promociones', $datos['promociones']);
        $this->set('product', $datos['product']);
        $this->set('product_imagen', $datos['product_imagen']);


        $carrito = [];
        if($this->request->session()->check('carrito')) { 
            $carrito = $this->request->session()->read('carrito');
        }
        //$carrito = $this->request->session()->destroy('carrito');
//debug($carrito); die;
        $this->set(compact('carrito'));
        $this->render(null,'front');
    }

    


    public function agregar_carrito()
    {
        if ($this->request->is('ajax')) { 

            $id_producto = $this->request->data['id_producto'];    
            $cantidad = $this->request->data['cantidad'];


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

            // datos de producto
            $producto = $this->Productos->get($id_producto, [
                'fields'=>['id', 'nombre', 'url', 'ver_precio', 'precio', 'ver_precio_promocion', 'precio_promocion', 'ver_meses_sin_intereses', 'precio_meses_sin_intereses', 'meses_sin_intereses', 'ver_porcentaje_descuento_promocion', 'porcentaje_descuento_promocion'],
                'contain'=>['Imagenes', 'PromocionProductos'=>['conditions'=>['PromocionProductos.promocion_id IN'=>$promociones]]]
            ]);

            if($producto->promocion_productos){
                unset($producto->promocion_productos[0]['id']);
                unset($producto->promocion_productos[0]['promocion_id']);
                unset($producto->promocion_productos[0]['producto_id']);
               
                foreach ($producto->promocion_productos[0]->toArray() as $key => $value) {
                    $producto[$key] = $value;
                }
            }



            $carrito = [];
            $ids_carrito = [];
            if($this->request->session()->check('carrito')) { 
                $carrito = $this->request->session()->read('carrito');

                foreach ($carrito as $key => $product) {
                    $ids_carrito[] = $product['id'];
                }
 
                if(in_array($id_producto, $ids_carrito)){

                    $response = [];
                    $response['text'] = $producto->nombre . ' ya existe en wishlist';
                    $response['cant'] = count($carrito);
                    
                    die(json_encode($response));
                }
            }



            // Evitamos que cheque si tienes hijos.
            $producto->checkgroup = FALSE; 


            $posicion = count($carrito);
            $carrito[$posicion] = $producto->toArray();
            $carrito[$posicion]['cantidad'] = $cantidad;

        
            $this->request->session()->write('carrito', $carrito);

            $response = [];
            $response['text'] = $producto->nombre . ' se agrego al wishlist';
            $response['cant'] = count($carrito);
            
            die(json_encode($response));

        }
    }

    public function editar_carrito()
    {   
        
        if ($this->request->is('ajax')) { 

            $accion=$this->request->data['accion'];
            $posicion=$this->request->data['posicion'];

            $carrito = [];
            if($this->request->session()->check('carrito')) { 
                $carrito = $this->request->session()->read('carrito');
            }

            if($accion == 'editar_articulo')
            {

                $carrito[$posicion]['cantidad'] = $this->request->data['cantidad'];

            }else if($accion == 'eliminar_articulo'){ 

                unset($carrito[$posicion]);
                $carrito = array_values($carrito);
            }

            $this->request->session()->write('carrito', $carrito);
            $carrito = $this->request->session()->read('carrito');
            
            die(json_encode($carrito)); 
        }
       
    }

    

    public function img($url = null)
    {
           $image = WWW_ROOT."img/no_image_available.png";

           $producto = $this->Productos->find('all')
            ->contain(['Imagenes'])
            ->where(['Productos.url' => $url])
            ->limit(1);
         $prod=$producto->toArray();
         //debug($prod[0]->imagenes);

         
         if(is_array($prod[0]->imagenes) && (isset($prod[0]->imagenes[0])) && (!is_null($prod[0]->imagenes[0]->nombre)) && ($prod[0]->imagenes[0]->nombre != "") ){

            $image = WWW_ROOT."producto_files/".$prod[0]->imagenes[0]->nombre;
         }
        //debug($image);
        //die;

        $imginfo = getimagesize($image);
        //header("Content-type: ".$imginfo['mime']);


        header('Content-Type: image/png');

        // Get new dimensions
        $filename=$image;
        $width = 120;
        $height = 120;

        list($width_orig, $height_orig) = getimagesize($filename);

        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
           $width = $height*$ratio_orig;
        } else {
           $height = $width/$ratio_orig;
        }

        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefrompng($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // Output
        imagepng($image_p);
        imagedestroy($im);


        //readfile($image);
        die;
        
    }

    


}
