<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Filtro Entity.
 */
class Filtro extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'categoria_id' => true,
        'categoria' => true,
        'opcionesfiltros' => true,
    ];
}
