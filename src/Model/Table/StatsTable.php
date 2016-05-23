<?php
namespace Cirici\Stats\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Stats\Model\Entity\Stat;

/**
 * Stats Model
 *
 * @property \Cake\ORM\Association\BelongsTo $StatTypes
 */
class StatsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('stats');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('StatTypes', [
            'foreignKey' => 'stat_type_id',
            'joinType' => 'INNER',
            'className' => 'Stats.StatTypes'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['stat_type_id'], 'StatTypes'));
        return $rules;
    }


    /**
     * Increases a stat for a determinated stat type.
     *
     * @param  string $name       The stat type name.
     * @param  array  $other      An array of additional information (will be serialized).
     * @param  mixed  $foreignKey An optional foreign key to relate to a
     *                            specified content defined by $model.
     * @param  string $model      The model name to which the $foreignKey is related.
     * @return bool
     */
    public function increase($name, $model, $foreignKey, $other = [])
    {
        $statType = $this->statType($name, $model);

        $stat = [
            'stat_type_id' => $statType->id,
            'foreign_key' => $foreignKey
        ];

        if (!empty($other)) {
            $stat['other'] = json_encode($other);
        }

        $stat = $this->newEntity($stat);

        return $this->save($stat);
    }

    /**
     * Decreases (removes) a stat for the specified stat type.
     *
     * @param  string $name       The stat type to be decreased.
     * @param  mixed  $foreignKey Foreign key of the stat to be removed.
     * @return bool
     */
    public function decrease($name, $foreignKey = null)
    {
        $stat = $this->find()->matching('StatTypes', function ($q) use ($name) {
            return $q->where(['StatTypes.name' => $name]);
        })->order(['Stats.created' => 'DESC']);

        if (!empty($foreignKey)) {
            $stat = $stat->where(['foreign_key' => $foreignKey])->first();
        }

        return $this->delete($stat);
    }

    /**
     * Returns the stat type with the specified name and model.
     *
     * In case the stat type does not exist it creates it.
     *
     * @param  string $name  The stat type to be decreased.
     * @param  mixed  $model The model of the stat type.
     * @return bool
     */
    protected function statType($name, $model)
    {
        if (Configure::read('Stats.singular_models')) {
            $model = Inflector::singularize($model);
        }

        $statType = $this->StatTypes->find()
            ->where(compact('name', 'model'))
            ->first();

        if (empty($statType)) {
            $statType = $this->StatTypes->newEntity(compact('name', 'model'));
            $this->StatTypes->save($statType);
        }

        return $statType;
    }
}
