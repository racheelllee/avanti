<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sucursale Entity
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $estado_id
 * @property int $municipio_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $deleted
 *
 * @property \App\Model\Entity\Estado $estado
 * @property \App\Model\Entity\Municipio $municipio
 */
class Sucursale extends Entity
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
