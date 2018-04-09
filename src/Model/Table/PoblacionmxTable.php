<?php
namespace App\Model\Table;

use App\Model\Entity\Poblacionmx;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Poblacionmx Model
 *
 */
class PoblacionmxTable extends Table
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

        $this->table('poblacionmx');
        $this->displayField('id');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('year', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('year');

        $validator
            ->allowEmpty('estado');

        $validator
            ->add('poblacion', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('poblacion');

        $validator
            ->add('hombres', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('hombres');

        $validator
            ->add('mujeres', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mujeres');

        $validator
            ->add('nacimientos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nacimientos');

        $validator
            ->add('defunciones', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('defunciones');

        return $validator;
    }
}
