<?php
namespace Customers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CustomerCategories
 * @property \Cake\ORM\Association\BelongsTo $Offices
 * @property \Cake\ORM\Association\BelongsTo $CustomerTypes
 * @property \Cake\ORM\Association\BelongsTo $CustomerHeadcounts
 * @property \Cake\ORM\Association\BelongsToMany $Phinxlog
 *
 * @method \Customers\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \Customers\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \Customers\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \Customers\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Customers\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Customers\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \Customers\Model\Entity\Customer findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends Table
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

        $this->table('customers');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CustomerCategories', [
            'foreignKey' => 'customer_category_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.CustomerCategories'
        ]);
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.Offices'
        ]);
        $this->belongsTo('CustomerTypes', [
            'foreignKey' => 'customer_type_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.CustomerTypes'
        ]);
        $this->belongsTo('CustomerHeadcounts', [
            'foreignKey' => 'customer_headcount_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.CustomerHeadcounts'
        ]);

        $this->hasMany('Contacts', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT',
            'className' => 'Customers.Contacts',
            'conditions' => [
              'Contacts.deleted' => false,
            ],
        ]);

        $this->belongsTo('Franquicias', [
            'foreignKey' => 'franquicia_id',
            'className' => 'Franquicias',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Usermgmt.Users', [
            'foreignKey' => 'seller_id',
            'propertyName' => 'seller',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('CustomerStatuses', [
            'foreignKey' => 'customer_status_id',
            'propertyName' => 'status',
            'joinType' => 'LEFT',
            'className' => 'Customers.CustomerStatuses',
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
          ->requirePresence('title', 'create')
          ->notEmpty('title');
        */

        /*$validator
          ->requirePresence('business_name', 'create')
          ->notEmpty('business_name');
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
          ->requirePresence('municipality', 'create')
          ->notEmpty('municipality');
        */

        /*$validator
          ->requirePresence('state', 'create')
          ->notEmpty('state');
        */

        /*$validator
          ->requirePresence('country', 'create')
          ->notEmpty('country');
        */

        /*$validator
          ->integer('postal_code')
          ->requirePresence('postal_code', 'create')
          ->notEmpty('postal_code');
        */

        /*$validator
          ->requirePresence('website', 'create')
          ->notEmpty('website');
        */

        /*$validator
          ->date('customer_since')
          ->allowEmpty('customer_since');
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
        #$rules->add($rules->existsIn(['customer_category_id'], 'CustomerCategories'));
        #$rules->add($rules->existsIn(['office_id'], 'Offices'));
        #$rules->add($rules->existsIn(['customer_type_id'], 'CustomerTypes'));
        #$rules->add($rules->existsIn(['customer_headcount_id'], 'CustomerHeadcounts'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options){
      $event->stopPropagation();
      $entity->deleted = 1;
      return $this->save($entity);
    }
}
