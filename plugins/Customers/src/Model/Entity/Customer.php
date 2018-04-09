<?php
namespace Customers\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $title
 * @property string $business_name
 * @property string $street
 * @property string $number
 * @property string $municipality
 * @property string $state
 * @property string $country
 * @property int $postal_code
 * @property int $customer_category_id
 * @property int $office_id
 * @property int $customer_type_id
 * @property int $customer_headcount_id
 * @property string $website
 * @property \Cake\I18n\Time $customer_since
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $deleted
 *
 * @property \Customers\Model\Entity\CustomerCategory $customer_category
 * @property \Customers\Model\Entity\Office $office
 * @property \Customers\Model\Entity\CustomerType $customer_type
 * @property \Customers\Model\Entity\CustomerHeadcount $customer_headcount
 * @property \Customers\Model\Entity\Phinxlog[] $phinxlog
 */
class Customer extends Entity
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
