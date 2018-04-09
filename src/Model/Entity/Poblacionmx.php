<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Poblacionmx Entity.
 *
 * @property int $id
 * @property int $year
 * @property string $estado
 * @property int $poblacion
 * @property int $hombres
 * @property int $mujeres
 * @property int $nacimientos
 * @property float $defunciones
 */
class Poblacionmx extends Entity
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
        'id' => false,
    ];
}
