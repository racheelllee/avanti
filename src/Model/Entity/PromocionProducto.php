<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PromocionProducto Entity
 *
 * @property int $id
 * @property int $promocion_id
 * @property int $producto_id
 * @property string $sku
 * @property float $precio
 * @property bool $ver_precio
 * @property float $precio_promocion
 * @property bool $ver_precio_promocion
 * @property float $precio_meses_sin_intereses
 * @property bool $ver_precio_meses_sin_intereses
 * @property int $meses_sin_intereses
 * @property bool $ver_meses_sin_intereses
 * @property int $porcentaje_descuento_promocion
 * @property bool $ver_porcentaje_descuento_promocion
 *
 * @property \App\Model\Entity\Promocion $promocion
 * @property \App\Model\Entity\Producto $producto
 */
class PromocionProducto extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
