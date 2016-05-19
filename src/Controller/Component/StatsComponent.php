<?php
namespace Cirici\Stats\Controller\Component;

use Cake\Controller\Component;

class StatsComponent extends Component
{
    protected $controller;

    protected $Stats;

    /**
     * Startup loads (like the related controller).
     *
     * @param \Cake\Event\Event $event The startup event that was fired.
     * @return void
     */
    public function startup(Event $event)
    {
        $this->controller = $event->subject();
        $this->Stats = TableRegistry::get('Stats');
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
    public function increase($name, $other = [], $foreignKey = null, $model = null)
    {
        $statType = $this->statType($name, $model);

        $stat = [
            'stat_type_id' => $statType->id,
            'foreign_key' => $foreignKey
        ];

        if (!empty($other)) {
            $stat['other'] = json_encode($other);
        }

        return true;
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

        return true;
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
    protected function statType($name, $model = null)
    {
        if (empty($model)) {
            $model = $this->controller->modelClass;
        }

        $statType = $this->Stats->StatTypes->find()
            ->where(compact('name', 'model'))
            ->first();

        if (empty($statType)) {
            $statType = $this->Stats->StatTypes->newEntity(compact('name', 'model'));
            $this->Stats->StatTypes->save($statType);
        }

        return $statType;
    }
}
