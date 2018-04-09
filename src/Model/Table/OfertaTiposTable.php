<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OfertaTipos Model
 *
 * @method \App\Model\Entity\OfertaTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\OfertaTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OfertaTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OfertaTipo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OfertaTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OfertaTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OfertaTipo findOrCreate($search, callable $callback = null)
 */
class OfertaTiposTable extends Table
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

        $this->table('oferta_tipos');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->allowEmpty('name');

        return $validator;
    }
}
