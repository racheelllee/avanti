<?php
namespace App\Model\Table;

use App\Model\Entity\ComplementosProducto;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComplementosProductos Model
 */
class ComplementosProductosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('complementos_productos');
        $this->primaryKey('id');
        $this->belongsTo('Complementos', [
            //'foreignKey' => 'complemento_id',
            //'joinType' => 'INNER'
            'className' => 'productos',
            'foreignKey' => 'complemento_id',
            'targetForeignKey' => 'producto_id',
            'joinTable' => 'productos'
        ]);
        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id',
            'joinType' => 'INNER'
        ]);
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
        //$rules->add($rules->existsIn(['complemento_id'], 'Complementos'));
        $rules->add($rules->existsIn(['producto_id'], 'Productos'));
        return $rules;
    }
}
