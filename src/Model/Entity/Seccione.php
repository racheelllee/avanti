<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seccione Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $nombre_background
 * @property string $nombre_color
 * @property bool $status
 * @property \Cake\I18n\Time $created
 */
class Seccione extends Entity
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
