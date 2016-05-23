<?php
namespace Cirici\Stats\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        $this->Stats = TableRegistry::get('Cirici/Stats.Stats');
    }

    /**
     * Increases a stat for a determinated stat type.
     *
     * @param  string $name       The stat type name.
     * @param  mixed  $foreignKey An optional foreign key to relate to a
     *                            specified content defined by $model.
     * @param  array  $other      An array of additional information (will be serialized).
     * @param  string $model      The model name to which the $foreignKey is related.
     * @return bool
     */
    public function increase($name, $foreignKey = null, $other = [], $model = null)
    {
        if (empty($model)) {
            $model = $this->controller->modelClass;
        }

        return $this->Stats->increase($name, $model, $foreignKey, $other);
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
        return $this->Stats->decrease($name, $foreignKey);
    }
}
