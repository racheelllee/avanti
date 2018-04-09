<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Secciones Model
 *
 * @method \App\Model\Entity\Seccione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Seccione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Seccione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Seccione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seccione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Seccione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Seccione findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeccionesTable extends Table
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

        $this->table('secciones');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('SeccionProductos', [
            'joinTable' => 'seccion_productos',
            'foreignKey' => 'seccion_id'
        ]);

        $this->hasMany('SeccionProductos', [
            'foreignKey' => 'seccion_id'
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('nombre_background', 'create')
            ->notEmpty('nombre_background');

        $validator
            ->requirePresence('nombre_color', 'create')
            ->notEmpty('nombre_color');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
