<?php
namespace Cirici\Stats\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Stats\Model\Table\StatsTable;

/**
 * Stats\Model\Table\StatsTable Test Case
 */
class StatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Stats\Model\Table\StatsTable
     */
    public $Stats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cirici/stats.stats',
        'plugin.cirici/stats.stat_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Stats') ? [] : ['className' => 'Cirici\Stats\Model\Table\StatsTable'];
        $this->Stats = TableRegistry::get('Stats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stats);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf('\Cake\ORM\Association\BelongsTo', $this->Stats->StatTypes);
        $this->assertTrue($this->Stats->hasBehavior('Timestamp'));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $stat = [
            'stat_type_id' => 9999,
            'foreign_key' => 23
        ];

        $stat = $this->Stats->newEntity($stat);
        $this->Stats->save($stat);

        $this->assertFalse(empty($stat->errors()));
    }

    /**
     * Test increase method.
     *
     * @return void
     */
    public function testIncrease()
    {
        $result = $this->Stats->increase('Test', 'Posts', 23);

        $this->assertTrue(empty($result->errors()));
        $this->assertNotNull($result->stat_type_id);

        $result2 = $this->Stats->increase('Test', 'Posts', 26);
        $this->assertTrue(empty($result2->errors()));
        $this->assertNotNull($result->stat_type_id);
        $this->assertEquals($result2->stat_type_id, $result->stat_type_id);
        $this->assertNotEquals($result2->id, $result->id);
    }

    /**
     * Test increase uses singular models when configured.
     *
     * @return void
     */
    public function testIncreaseGeneratesSingularModel()
    {
        Configure::write('Stats.singular_models', true);
        $result = $this->Stats->increase('Test', 'Posts', 23);

        $statType = $this->Stats->StatTypes
            ->find()
            ->where(['id' => $result->stat_type_id])
            ->first()
        ;

        $this->assertEquals('Post', $statType->model);
    }

    /**
     * Test decrease method.
     *
     * @depends testIncrease
     * @return void
     */
    public function testDecrease()
    {
        $this->Stats->increase('Test', 'Posts', 23);

        $this->assertEquals(2, count($this->Stats->find()->toArray()));

        $this->Stats->decrease('Test', 23);

        $stat = $this->Stats->find()->matching('StatTypes', function ($q) {
            return $q->where(['StatTypes.name' => 'Test']);
        })->where(['foreign_key' => 23])->first();

        $this->assertNull($stat);
        $this->assertEquals(1, count($this->Stats->find()->toArray()));
    }
}
