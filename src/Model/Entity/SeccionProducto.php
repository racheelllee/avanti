<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeccionProducto Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $seccion_id
 * @property int $producto_id
 * @property \Cake\I18n\Time $vigencia_inicio
 * @property \Cake\I18n\Time $vigencia_fin
 * @property string $nombre_promocion
 * @property string $nombre_promocion_background
 * @property string $nombre_promocion_color
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Seccion $seccion
 * @property \App\Model\Entity\Producto $producto
 */
class SeccionProducto extends Entity
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
