<?php
namespace Stats\Model\Entity;

use Cake\ORM\Entity;

/**
 * Stat Entity.
 *
 * @property int $id
 * @property int $stat_type_id
 * @property \Stats\Model\Entity\StatType $stat_type
 * @property int $foreign_key
 * @property string $other
 * @property float $membership_total
 * @property float $shop_total
 * @property float $devolution_total
 * @property \Cake\I18n\Time $created
 */
class Stat extends Entity
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
        'id' => false,
    ];
}
