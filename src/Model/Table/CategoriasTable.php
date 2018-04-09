<?php
namespace App\Model\Table;

use App\Model\Entity\Categoria;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Categorias Model
 */
class CategoriasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('categorias');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->addBehavior('Tree');



        $this->belongsTo('Padre', [
            'className' => 'Categorias',
            'foreignKey' => 'parent_id'
        ]);
       /* $this->hasMany('Categorias', [
            'foreignKey' => 'categoria_id'
        ]);*/

        
        $this->hasMany('Cupones', [
            'foreignKey' => 'categoria_id'
        ]);
        $this->hasMany('Filtros', [
            'foreignKey' => 'categoria_id'
        ]);
        $this->belongsToMany('Productos', [
            'foreignKey' => 'categoria_id',
            'targetForeignKey' => 'producto_id',
            'joinTable' => 'categorias_productos',
            'conditions'=>'Productos.estatus_id=1 and Productos.padre_id is null'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->allowEmpty('nombre');
            
        $validator
            ->add('url', [
              'unique' => ['rule' => 'validateUnique', 'provider' => 'table']
              ])
            ->requirePresence('url', 'create')
            ->notEmpty('url');
            
        $validator
            ->add('orden', 'valid', ['rule' => 'numeric'])
            ->requirePresence('orden', 'create')
            ->notEmpty('orden');

        $validator
            ->integer('producto_destacado_id')
            ->allowEmpty('producto_destacado_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }


    public function datosGenerales()
    {
        $tableBanners = TableRegistry::get('Banners');
        $tablePromociones = TableRegistry::get('Promociones');
        $productos = TableRegistry::get('Productos');
        $imagenes = TableRegistry::get('Imagenes');
        $time = Time::now(DEFAULT_TIME_ZONE);

        //$this->Categorias->recover('parent_id');

        $datos = [];

        $datos['categorias'] = $this->find('threaded', [
            'order' => ['orden' => 'asc'], 
            'conditions'=>['Categorias.deleted'=>0]
        ])->toArray();


        $datos['banners'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 1, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['banners1'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 2, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['banners2'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 3, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['banners3'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 4, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['banners4'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 5, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['banners5'] = $tableBanners->find('all', [
            'order' => 'Banners.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Banners.vigencia_inicio) AND DATE(Banners.vigencia_fin)',
                    'Banners.principal' => 6, 
                    'Banners.status' => true, 
                    'Banners.deleted' => false]])->toArray();

        $datos['promociones'] = $tablePromociones->find('all', [
            'order' => 'Promociones.orden ASC',
            'conditions' => [
                    '"'.$time->format('Y-m-d').'" BETWEEN DATE(Promociones.vigencia_inicio) AND DATE(Promociones.vigencia_fin)',
                    'Promociones.deleted' => false, 
                    'Promociones.status' => true ] ])->toArray();

        $product_ids = [];
        foreach ($datos['categorias'] as $cat) {
            if(!is_null($cat['producto_destacado_id'])){
                array_push($product_ids, $cat['producto_destacado_id']);
            }
        }
        $datos['product'] = '';
        $datos['product_imagen'] = '';
        if(sizeof($product_ids) > 0){
            
            $datos['product'] = [];
            $dumb = $productos->find('all')->where(['id IN' => $product_ids])->toArray();
            $datos['product_imagen'] = $imagenes->find('list', ['keyField'=>'producto_id', 'valueField'=>'nombre'])->where(['producto_id IN' => $product_ids])->toArray();
            foreach ($dumb as $p) {
                $datos['product'][$p['id']]= $p;
            }
        }

        
        return $datos;
    }

    public function getCategorias(){

       $categorias=$this->find('treeList', ['order' => ['nombre' => 'asc']])->toArray();
       $categorias=[''=>' -- Seleccione -- ']+$categorias;
       return $categorias;  

    }

    public function beforeDelete($event, $entity, $options){
        $event->stopPropagation();
        $entity->deleted = 1;
        return $this->save($entity);
    }

   public function beforeFind($event, $query, $options, $primary){
        $query->andWhere([$query->repository()->alias() . '.deleted' => '0']);
    }
}
