<?php
namespace Customers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Contacts
 *
 * @method \Customers\Model\Entity\ContactType get($primaryKey, $options = [])
 * @method \Customers\Model\Entity\ContactType newEntity($data = null, array $options = [])
 * @method \Customers\Model\Entity\ContactType[] newEntities(array $data, array $options = [])
 * @method \Customers\Model\Entity\ContactType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Customers\Model\Entity\ContactType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Customers\Model\Entity\ContactType[] patchEntities($entities, array $data, array $options = [])
 * @method \Customers\Model\Entity\ContactType findOrCreate($search, callable $callback = null)
 */
class ContactTypesTable extends Table
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

        $this->table('contact_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Contacts', [
            'foreignKey' => 'contact_type_id',
            'className' => 'Customers.Contacts'
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

        return $validator;
    }
}
