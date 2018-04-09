<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoriasProducto Entity.
 */
class CategoriasProducto extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'categoria_id' => true,
        'producto_id' => true,
        'categoria' => true,
        'producto' => true,
    ];
}
