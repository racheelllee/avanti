<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Precios Model
 *
 * @method \App\Model\Entity\Precio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Precio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Precio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Precio|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Precio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Precio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Precio findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PreciosTable extends Table
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

        $this->table('precios');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->decimal('min')
            ->requirePresence('min', 'create')
            ->notEmpty('min');

        $validator
            ->decimal('max')
            ->requirePresence('max', 'create')
            ->notEmpty('max');

        $validator
            ->integer('orden')
            ->requirePresence('orden', 'create')
            ->notEmpty('orden');

        $validator
            ->boolean('borrado')
            ->requirePresence('borrado', 'create')
            ->notEmpty('borrado');

        return $validator;
    }
}
