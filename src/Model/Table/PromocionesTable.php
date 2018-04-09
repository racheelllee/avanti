<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
/**
 * Promociones Model
 *
 * @method \App\Model\Entity\Promocione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Promocione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Promocione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Promocione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Promocione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Promocione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Promocione findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PromocionesTable extends Table
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

        $this->table('promociones');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PromocionProductos', [
            'foreignKey' => 'promocion_id'
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
            ->allowEmpty('nombre');

        $validator
            ->allowEmpty('url');

        $validator
            ->dateTime('vigencia_inicio')
            ->allowEmpty('vigencia_inicio');

        $validator
            ->dateTime('vigencia_fin')
            ->allowEmpty('vigencia_fin');

        $validator
            ->integer('orden')
            ->allowEmpty('orden');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->boolean('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    public function getOptionsForExcel(){

        $fields = [
            ['field' => 'sku', 'no_empty'=>false],
            ['field' => 'precio', 'no_empty'=>false],
            ['field' => 'ver_precio', 'no_empty'=>false],
            ['field' => 'precio_promocion', 'no_empty'=>false],
            ['field' => 'ver_precio_promocion', 'no_empty'=>false],
            ['field' => 'precio_meses_sin_intereses', 'no_empty'=>false],
            ['field' => 'ver_precio_meses_sin_intereses', 'no_empty'=>false],
            ['field' => 'meses_sin_intereses', 'no_empty'=>false],
            ['field' => 'ver_meses_sin_intereses', 'no_empty'=>false],
            ['field' => 'porcentaje_descuento_promocion', 'no_empty'=>false],
            ['field' => 'ver_porcentaje_descuento_promocion', 'no_empty'=>false]
        ];
        $headerCols = [];
        $notEmpty = [];

        foreach ($fields as $field) {
            $headerCols[] = $field['field'];
            if($field['no_empty']){
                $notEmpty[] = $field['field'];
            }
        }

        $options = [
                    'startRow'=>1,
                    'headerCols'=>$headerCols,
                    'notEmpty'=>$notEmpty,
                    'worksheetPosition'=>0
                    ];

        return $options;
    }

    public function validationExcel($promosArray = null, $promocion_id = null){
        foreach ($promosArray as $key => $promo) {

            foreach ($promo as $k => $field) {
                $promosArray[$key][$k] = str_replace(" ", "", $promo[$k]);
                $promo[$k] = str_replace(" ", "", $promo[$k]);
            }

            $promosArray[$key]['precio'] = preg_replace("/[^0-9\.]/","",$promo['precio']);
            $promosArray[$key]['precio_promocion'] = preg_replace("/[^0-9\.]/","",$promo['precio_promocion']);
            $promosArray[$key]['precio_meses_sin_intereses'] = preg_replace("/[^0-9\.]/","",$promo['precio_meses_sin_intereses']);
            $promosArray[$key]['meses_sin_intereses'] = preg_replace("/[^0-9\.]/","",$promo['meses_sin_intereses']);
            $promosArray[$key]['porcentaje_descuento_promocion'] = preg_replace("/[^0-9\.]/","",$promo['porcentaje_descuento_promocion']);

            $promosArray[$key]['ver_precio'] = (strtolower($promo['ver_precio']) == 'si')? true : false;
            $promosArray[$key]['ver_precio_promocion'] = (strtolower($promo['ver_precio_promocion']) == 'si')? true : false;
            $promosArray[$key]['ver_precio_meses_sin_intereses'] = (strtolower($promo['ver_precio_meses_sin_intereses']) == 'si')? true : false;
            $promosArray[$key]['ver_meses_sin_intereses'] = (strtolower($promo['ver_meses_sin_intereses']) == 'si')? true : false;
            $promosArray[$key]['ver_porcentaje_descuento_promocion'] = (strtolower($promo['ver_porcentaje_descuento_promocion']) == 'si')? true : false;
            

            if(!empty($promo['sku'])){
                $this->Productos = TableRegistry::get('Productos');
                $producto = $this->Productos->find('all', ['conditions'=>['Productos.sku'=>$promo['sku']]])->first();

                if(!$producto){
                    $promosArray[$key]['result_upload'][] = 'Este SKU no existe';
                }else{

                    $time = Time::now(DEFAULT_TIME_ZONE);

                    $productoActual = $this->PromocionProductos->find('all', [
                        'contain' => ['Promociones'],
                        'conditions' => [
                                '"'.$time->format('Y-m-d').'" BETWEEN DATE(Promociones.vigencia_inicio) AND DATE(Promociones.vigencia_fin)',
                                'PromocionProductos.producto_id' => $producto->id, 
                                'Promociones.deleted' => false,
                                'Promociones.status' => true
                        ] ])->toArray();

                    if($productoActual && (count($productoActual) > 1 || $productoActual[0]->promocion_id != $promocion_id)){
                        $promosArray[$key]['result_upload'][] = 'Este SKU tiene una promoción vigente';
                    }

                    $productoPromo = $this->PromocionProductos->find('all', [
                        'contain' => ['Promociones'],
                        'conditions' => [
                                'PromocionProductos.producto_id' => $producto->id, 
                                'PromocionProductos.promocion_id' => $promocion_id
                        ] ])->first();

                    if ($productoPromo) {
                        $promosArray[$key]['id'] = $productoPromo->id;   
                    }

                    $promosArray[$key]['producto_id'] = $producto->id;
                }
            }   
        }

        return $promosArray;
    }
}
