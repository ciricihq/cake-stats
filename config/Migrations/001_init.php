<?php
use Phinx\Migration\AbstractMigration;

class Init_Stats_Plugin extends AbstractMigration
{
    public function change()
    {
        $this->table('stat_types')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('model', 'string', ['limit' => 100])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addIndex(['model'])
            ->addIndex(['name'])
            ->create()
        ;

        $this->table('stats')
            ->addColumn('stat_type_id', 'integer')
            ->addColumn('foreign_key', 'integer')
            ->addColumn('other', 'text')
            ->addColumn('created', 'datetime')
            ->addIndex(['stat_type_id'])
            ->addIndex(['foreign_key'])
            ->create()
        ;
    }
}
