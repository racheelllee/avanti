<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Imagen Entity.
 */
class Imagen extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'producto_id' => true,
        'nombre' => true,
        'producto' => true,
    ];
}
