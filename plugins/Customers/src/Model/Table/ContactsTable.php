<?php
namespace Customers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Customers\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \Customers\Model\Entity\Contact newEntity($data = null, array $options = [])
 * @method \Customers\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \Customers\Model\Entity\Contact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Customers\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Customers\Model\Entity\Contact[] patchEntities($entities, array $data, array $options = [])
 * @method \Customers\Model\Entity\Contact findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactsTable extends Table
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

        $this->table('contacts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
            'className' => 'Customers.Customers'
        ]);

        $this->belongsTo('ContactTypes', [
            'foreignKey' => 'contact_type_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.ContactTypes'
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
        /*$validator
          ->integer('id')
          ->allowEmpty('id', 'create');
        */

        /*$validator
          ->requirePresence('first_name', 'create')
          ->notEmpty('first_name');
        */

        /*$validator
          ->requirePresence('middle_name', 'create')
          ->notEmpty('middle_name');
        */

        /*$validator
          ->requirePresence('last_name', 'create')
          ->notEmpty('last_name');
        */

        /*$validator
          ->requirePresence('department', 'create')
          ->notEmpty('department');
        */

        /*$validator
          ->email('email')
          ->requirePresence('email', 'create')
          ->notEmpty('email');
        */

        /*$validator
          ->requirePresence('phone', 'create')
          ->notEmpty('phone');
        */

        /*$validator
          ->requirePresence('phone_ext', 'create')
          ->notEmpty('phone_ext');
        */

        /*$validator
          ->requirePresence('mobile_phone', 'create')
          ->notEmpty('mobile_phone');
        */

        /*$validator
          ->requirePresence('street', 'create')
          ->notEmpty('street');
        */

        /*$validator
          ->requirePresence('number', 'create')
          ->notEmpty('number');
        */

        /*$validator
          ->requirePresence('colony', 'create')
          ->notEmpty('colony');
        */

        /*$validator
          ->requirePresence('municipality', 'create')
          ->notEmpty('municipality');
        */

        /*$validator
          ->requirePresence('country', 'create')
          ->notEmpty('country');
        */

        /*$validator
          ->requirePresence('postal_code', 'create')
          ->notEmpty('postal_code');
        */

        /*$validator
          ->integer('deleted')
          ->requirePresence('deleted', 'create')
          ->notEmpty('deleted');
        */

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
        #$rules->add($rules->isUnique(['email']));
        #$rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options){
      $event->stopPropagation();
      $entity->deleted = 1;
      return $this->save($entity);
    }
    
}
