<?php

namespace LookupTest\Db;

use Lookup\Db\Schedule as ScheduleDb;
use Lookup\Entity\Schedule;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ScheduleTest extends BaseTestCase
{
	protected $scheduleDb;

	protected function setUp()
	{
		$adapter = new Adapter(array(
			'driver' => 'Pdo_Sqlite',
			'database' => ':memory:',
		));
		$this->createTables($adapter);

		// Disable foreign key constraint checking to allow fake data
		$adapter->query('PRAGMA foreign_keys = OFF', Adapter::QUERY_MODE_EXECUTE);

		$adapter->query('INSERT INTO user_schedule '
		              . 'VALUES("b-b-b", 42)', Adapter::QUERY_MODE_EXECUTE);

		$adapter->query('INSERT INTO schedule '
		              . 'VALUES(42, "foo", 1)', Adapter::QUERY_MODE_EXECUTE);

		$adapter->query('INSERT INTO schedule_interval '
		              . 'VALUES(1, 42, 12, 13, 2)', Adapter::QUERY_MODE_EXECUTE);

		$sql = new Sql($adapter);
		$this->scheduleDb = new ScheduleDb($sql);
	}

	public function testGetByUserIdReturnsNullWhenNonexistentIdPassed()
	{
		$schedule = $this->scheduleDb->getByUserId('a-a-a');
		$this->assertNull($schedule);
	}

	public function testGetByUserIdReturnsSchedule()
	{
		$schedule = $this->scheduleDb->getByUserId('b-b-b');
		$this->assertInstanceOf('Lookup\Entity\Schedule', $schedule);
		$this->assertEquals($schedule->getId(), 42);
		$this->assertEquals($schedule->getName(), 'foo');
		$this->assertTrue($schedule->isEnabled());
	}
}
