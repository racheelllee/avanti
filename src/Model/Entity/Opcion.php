<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Opcion Entity.
 */
class Opcion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'atributo_id' => true,
        'nombre' => true,
        'atributo' => true,
    ];
}
