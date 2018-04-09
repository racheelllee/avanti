<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComplementosCategoria Entity.
 */
class ComplementosCategoria extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'producto_id' => true,
        'categoria_id' => true,
        'producto' => true,
        'categoria' => true,
    ];
}
