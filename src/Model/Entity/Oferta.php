<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Oferta Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $color_fondo
 * @property string $color_fuente
 * @property int $producto_id
 * @property bool $precio_lista
 * @property bool $meses_sin_intereses
 * @property bool $precio_promocion
 * @property bool $descuento_promocion
 * @property \Cake\I18n\Time $vigencia_inicio
 * @property \Cake\I18n\Time $vigencia_fin
 * @property int $status
 * @property int $tipo_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $deleted
 *
 * @property \App\Model\Entity\Producto $producto
 * @property \App\Model\Entity\Tipo $tipo
 */
class Oferta extends Entity
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
