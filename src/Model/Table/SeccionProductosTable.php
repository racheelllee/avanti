<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeccionProductos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Seccions
 * @property \Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\SeccionProducto get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeccionProducto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeccionProducto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeccionProducto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeccionProducto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeccionProducto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeccionProducto findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeccionProductosTable extends Table
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

        $this->table('seccion_productos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Seccions', [
            'foreignKey' => 'seccion_id'
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

        $validator
            ->date('vigencia_inicio')
            ->requirePresence('vigencia_inicio', 'create')
            ->notEmpty('vigencia_inicio');

        $validator
            ->date('vigencia_fin')
            ->requirePresence('vigencia_fin', 'create')
            ->notEmpty('vigencia_fin');

        $validator
            ->requirePresence('nombre_promocion', 'create')
            ->notEmpty('nombre_promocion');

        $validator
            ->requirePresence('nombre_promocion_background', 'create')
            ->notEmpty('nombre_promocion_background');

        $validator
            ->requirePresence('nombre_promocion_color', 'create')
            ->notEmpty('nombre_promocion_color');

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
