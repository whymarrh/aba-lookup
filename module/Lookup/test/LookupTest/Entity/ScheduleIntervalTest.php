<?php

namespace LookupTest\Entity;

use Lookup\Entity\ScheduleInterval;
use PHPUnit_Framework_TestCase;

class ScheduleIntervalTest extends PHPUnit_Framework_TestCase
{
	protected $interval;

	protected function setUp()
	{
		$this->interval = new ScheduleInterval(5, 6, 7);
	}

	public function testSetGetId()
	{
		$id = 42;
		$this->interval->setId($id);
		$this->assertEquals($id, $this->interval->getId());
	}

	public function testGetStartTime()
	{
		$this->assertEquals(5, $this->interval->getStartTime());
	}

	public function testGetEndTime()
	{
		$this->assertEquals(6, $this->interval->getEndTime());
	}

	public function testGetWeekday()
	{
		$this->assertEquals(7, $this->interval->getWeekday());
	}
}
