<?php

namespace LookupTest\Entity;

use Lookup\Entity\Schedule;
use PHPUnit_Framework_TestCase;

class ScheduleTest extends PHPUnit_Framework_TestCase
{
	protected $schedule;

	protected function setUp()
	{
		$this->schedule = new Schedule(5, 'foo', FALSE);
	}

	public function testGetId()
	{
		$this->assertEquals(5, $this->schedule->getId());
	}

	public function testGetName()
	{
		$this->assertEquals('foo', $this->schedule->getName());
	}

	public function testIsEnabled()
	{
		$this->assertFalse($this->schedule->isEnabled());
	}
}
