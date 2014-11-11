<?php

namespace LookupTest\Entity;

use Lookup\Entity\Score;
use Mockery;
use PHPUnit_Framework_TestCase;

class ScoreTest extends PHPUnit_Framework_TestCase
{
	protected $userA;
	protected $userB;
	protected $schedule;
	protected $score;

	protected function setUp()
	{
		$this->userA = Mockery::mock('Lookup\Entity\User');
		$this->userB = Mockery::mock('Lookup\Entity\User');
		$this->schedule = Mockery::mock('Lookup\Entity\Schedule');
		$this->score = new Score($this->userA, $this->userB, $this->schedule, 42);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testSetGetId()
	{
		$id = 42;
		$this->score->setId($id);
		$this->assertEquals($id, $this->score->getId());
	}

	public function testGetA()
	{
		$this->assertEquals($this->userA, $this->score->getA());
	}

	public function testGetB()
	{
		$this->assertEquals($this->userB, $this->score->getB());
	}

	public function testGetSchedule()
	{
		$this->assertEquals($this->schedule, $this->score->getSchedule());
	}

	public function testGetScore()
	{
		$this->assertEquals(42, $this->score->getScore());
	}
}
