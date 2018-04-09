<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Atributo Entity.
 */
class Atributo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'producto_id' => true,
        'producto' => true,
        'opciones' => true,
    ];
}
