<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PromocionProductos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Promocions
 * @property \Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\PromocionProducto get($primaryKey, $options = [])
 * @method \App\Model\Entity\PromocionProducto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PromocionProducto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PromocionProducto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromocionProducto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PromocionProducto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PromocionProducto findOrCreate($search, callable $callback = null)
 */
class PromocionProductosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('promocion_productos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Promociones', [
            'foreignKey' => 'promocion_id'
        ]);
        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        

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
