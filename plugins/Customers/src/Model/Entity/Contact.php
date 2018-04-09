<?php
namespace Customers\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $department
 * @property string $email
 * @property string $phone
 * @property string $phone_ext
 * @property string $mobile_phone
 * @property string $street
 * @property string $number
 * @property string $colony
 * @property string $municipality
 * @property string $country
 * @property string $postal_code
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $deleted
 *
 * @property \Customers\Model\Entity\Customer $customer
 */
class Contact extends Entity
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
