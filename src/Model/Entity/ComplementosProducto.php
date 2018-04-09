<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComplementosProducto Entity.
 */
class ComplementosProducto extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'complemento_id' => true,
        'producto_id' => true,
        'complemento' => true,
        'producto' => true,
    ];
}
