<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormasPagos Model
 *
 * @method \App\Model\Entity\FormasPago get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormasPago newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormasPago[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormasPago|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormasPago patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormasPago[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormasPago findOrCreate($search, callable $callback = null)
 */
class FormasPagosTable extends Table
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

        $this->table('formas_pagos');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->integer('orden')
            ->requirePresence('orden', 'create')
            ->notEmpty('orden');

        $validator
            ->requirePresence('imagen', 'create')
            ->notEmpty('imagen');

        $validator
            ->integer('activo')
            ->requirePresence('activo', 'create')
            ->notEmpty('activo');

        return $validator;
    }
}
