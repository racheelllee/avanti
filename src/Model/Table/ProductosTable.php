<?php
namespace App\Model\Table;

use App\Model\Entity\Producto;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



/**
 * Productos Model
 */
class ProductosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('productos');
        $this->displayField('nombre');
        $this->primaryKey('id');

       $this->addBehavior('Tree',['parent' => 'padre_id'  ]);


        $this->belongsTo('Users', [
            'foreignKey' => 'usuario_id'
        ]);
        $this->belongsTo('Proveedores', [
            'foreignKey' => 'proveedor_id'
        ]);
        $this->belongsTo('Marcas', [
            'foreignKey' => 'marca_id'
        ]);
        $this->belongsTo('productosEstatuses', [
            'foreignKey' => 'estatus_id'
        ]);




        $this->hasMany('Atributos', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Cupones', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Imagenes', [
            'foreignKey' => 'producto_id',
            'sort' => ['orden'=>'ASC']
        ]);
        $this->hasMany('Preciocomeptencias', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Precios', [
            'foreignKey' => 'producto_id'
        ]);
        $this->belongsToMany('Categorias', [
            'foreignKey' => 'producto_id',
            'targetForeignKey' => 'categoria_id',
            'joinTable' => 'categorias_productos',
            'conditions' => 'Categorias.publicado = 1'
        ]);
        $this->belongsToMany('Promociones', [
            'foreignKey' => 'producto_id',
            'targetForeignKey' => 'promocion_id',
            'joinTable' => 'productos_promociones'
        ]);

         $this->hasMany('Comentarios', [
            'foreignKey' => 'producto_id',
             'conditions'=> 'Comentarios.autorizado= 1'
        ]);

        $this->belongsToMany('Complementos', [
            'className' => 'Productos',
            'foreignKey' => 'producto_id',
            'targetForeignKey' => 'complemento_id',
            'joinTable' => 'complementos_productos',
              'conditions'=> 'Complementos.estatus_id= 1'
        ]);

        $this->hasMany('CategoriasProductos', [
            'foreignKey' => 'producto_id'
        ]);

        $this->hasMany('OpcionefiltrosProductos', [
            'foreignKey' => 'producto_id'
        ]);
        
        $this->hasOne('ComplementosCategorias', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Fichas', [
            'foreignKey' => 'producto_id',
            'sort' => ['orden'=>'ASC']
        ]);

        $this->hasMany('PromocionProductos', [
            'foreignKey' => 'producto_id',
            'sort' => ['PromocionProductos.id'=>'DESC']
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
            ->add('url', [
              'unique' => ['rule' => 'validateUnique', 'provider' => 'table']
              ])
            ->requirePresence('url', 'create')
            ->notEmpty('url');
            
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
}
