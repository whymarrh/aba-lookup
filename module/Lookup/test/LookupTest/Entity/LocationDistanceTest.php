<?php

namespace LookupTest\Entity;

use Lookup\Entity\LocationDistance;
use Mockery;
use PHPUnit_Framework_TestCase;

class LocationDistanceTest extends PHPUnit_Framework_TestCase
{
	protected $a;
	protected $b;
	protected $distance;

	protected function setUp()
	{
		$this->a = Mockery::mock('Lookup\Entity\Location');
		$this->b = Mockery::mock('Lookup\Entity\Location');
		$this->distance = new LocationDistance(1, $this->a, $this->b, 42);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testGetId()
	{
		$this->assertEquals(1, $this->distance->getId());
	}

	public function testGetLocationA()
	{
		$this->assertEquals($this->a, $this->distance->getLocationA());
	}

	public function testGetLocationB()
	{
		$this->assertEquals($this->b, $this->distance->getLocationB());
	}
}
