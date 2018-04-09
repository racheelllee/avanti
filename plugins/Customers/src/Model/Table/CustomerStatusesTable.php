<?php
namespace Customers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerStatuses Model
 *
 * @property \Cake\ORM\Association\HasMany $Customers
 *
 * @method \Customers\Model\Entity\CustomerStatus get($primaryKey, $options = [])
 * @method \Customers\Model\Entity\CustomerStatus newEntity($data = null, array $options = [])
 * @method \Customers\Model\Entity\CustomerStatus[] newEntities(array $data, array $options = [])
 * @method \Customers\Model\Entity\CustomerStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Customers\Model\Entity\CustomerStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Customers\Model\Entity\CustomerStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Customers\Model\Entity\CustomerStatus findOrCreate($search, callable $callback = null)
 */
class CustomerStatusesTable extends Table
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

        $this->table('customer_statuses');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Customers', [
            'foreignKey' => 'customer_status_id',
            'className' => 'Customers.Customers'
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
        #$validator
            #->integer('id')
            #->allowEmpty('id', 'create');

        #$validator
            #->requirePresence('name', 'create')
            #->notEmpty('name');

        #$validator
            #->requirePresence('label', 'create')
            #->notEmpty('label');

        #$validator
            #->requirePresence('color', 'create')
            #->notEmpty('color');

        return $validator;
    }

    public function statusList($required = false){
        $statuses = $this->find('list')->toArray();
        return $required ? $statuses : [NULL => __d('customers', 'Estatus...')] + $statuses;
    }
}
