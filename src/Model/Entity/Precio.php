<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Precio Entity
 *
 * @property int $id
 * @property string $nombre
 * @property float $min
 * @property float $max
 * @property int $orden
 * @property bool $borrado
 * @property \Cake\I18n\Time $created
 */
class Precio extends Entity
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
