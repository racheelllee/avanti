<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ofertas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Productos
 * @property \Cake\ORM\Association\BelongsTo $Tipos
 *
 * @method \App\Model\Entity\Oferta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Oferta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Oferta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Oferta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Oferta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Oferta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Oferta findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OfertasTable extends Table
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

        $this->table('ofertas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id'
        ]);
        $this->belongsTo('Tipos', [
            'foreignKey' => 'tipo_id'
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
            ->allowEmpty('titulo');

        $validator
            ->allowEmpty('color_fondo');

        $validator
            ->allowEmpty('color_fuente');

        $validator
            ->boolean('precio_lista')
            ->allowEmpty('precio_lista');

        $validator
            ->boolean('meses_sin_intereses')
            ->allowEmpty('meses_sin_intereses');

        $validator
            ->boolean('precio_promocion')
            ->allowEmpty('precio_promocion');

        $validator
            ->boolean('descuento_promocion')
            ->allowEmpty('descuento_promocion');

        $validator
            ->date('vigencia_inicio')
            ->allowEmpty('vigencia_inicio');

        $validator
            ->date('vigencia_fin')
            ->allowEmpty('vigencia_fin');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->boolean('deleted')
            ->allowEmpty('deleted');

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
        $rules->add($rules->existsIn(['producto_id'], 'Productos'));
        $rules->add($rules->existsIn(['tipo_id'], 'Tipos'));

        return $rules;
    }
}
