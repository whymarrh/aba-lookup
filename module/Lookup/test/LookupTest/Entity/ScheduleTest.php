<?php

namespace LookupTest\Entity;

use Lookup\Entity\Schedule;
use PHPUnit_Framework_TestCase;

class ScheduleTest extends PHPUnit_Framework_TestCase
{
	protected $schedule;

	protected function setUp()
	{
		$this->schedule = new Schedule('foo', FALSE);
	}

	public function testSetGetId()
	{
		$id = 42;
		$this->schedule->setId($id);
		$this->assertEquals($id, $this->schedule->getId());
	}

	public function testGetName()
	{
		$this->assertEquals('foo', $this->schedule->getName());
	}

	public function testIsEnabled()
	{
		$this->assertFalse($this->schedule->isEnabled());
	}

	public function testSetGetIntervals()
	{
		$intervals = array(1, 2, 3);
		$this->schedule->setIntervals($intervals);
		$this->assertSame($this->schedule->getIntervals(), $intervals);
	}
}
