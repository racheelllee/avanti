<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Promocione Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $url
 * @property \Cake\I18n\Time $vigencia_inicio
 * @property \Cake\I18n\Time $vigencia_fin
 * @property int $orden
 * @property int $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $deleted
 */
class Promocione extends Entity
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
