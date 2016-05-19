<?php
namespace Stats\Model\Entity;

use Cake\ORM\Entity;

/**
 * StatType Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $model
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Stats\Model\Entity\Stat[] $stats
 */
class StatType extends Entity
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
