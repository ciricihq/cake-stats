<?php
namespace Cirici\Stats\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Stats\Model\Table\StatTypesTable;

/**
 * Stats\Model\Table\StatTypesTable Test Case
 */
class StatTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Stats\Model\Table\StatTypesTable
     */
    public $StatTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cirici/stats.stat_types',
        'plugin.cirici/stats.stats'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StatTypes') ? [] : ['className' => 'Cirici\Stats\Model\Table\StatTypesTable'];
        $this->StatTypes = TableRegistry::get('StatTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf('\Cake\ORM\Association\HasMany', $this->StatTypes->Stats);
        $this->assertTrue($this->StatTypes->hasBehavior('Timestamp'));
    }
}
