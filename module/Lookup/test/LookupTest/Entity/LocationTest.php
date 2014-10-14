<?php

namespace LookupTest\Entity;

use Lookup\Entity\Location;
use PHPUnit_Framework_TestCase;

class LocationTest extends PHPUnit_Framework_TestCase
{
	protected $location;

	protected function setUp()
	{
		$this->location = new Location(4, 'foo', 'bar');
	}

	public function testGetId()
	{
		$this->assertEquals(4, $this->location->getId());
	}

	public function testGetCity()
	{
		$this->assertEquals('foo', $this->location->getCity());
	}

	public function testGetPostalCode()
	{
		$this->assertEquals('bar', $this->location->getPostalCode());
	}
}
