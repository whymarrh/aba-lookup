<?php

namespace MapsTest;

use
	Maps\LatLng,
	PHPUnit_Framework_TestCase
;

class LatLngTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var LatLng
	 */
	protected $latLng;

	/**
	 * LatLng properties
	 */
	protected $lat;
	protected $lng;

	/**
	 * Resets for isolation
	 */
	public function setUp()
	{
		$this->lat = 3;
		$this->lng = 4;
		$this->latLng = new LatLng($this->lat, $this->lng);
		$this->assertInstanceOf('Maps\LatLng', $this->latLng);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testExceptionIsThrownIfConstructorPassedNonNumericLatitude()
	{
		new LatLng('', 3);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testExceptionIsThrownIfConstructorPassedNonNumericLongitude()
	{
		new LatLng(3, '');
	}

	public function testGetLat()
	{
		$this->assertEquals($this->lat, $this->latLng->getLat());
	}

	/**
	 * @depends testGetLat
	 */
	public function testLatStoredAsFloat()
	{
		$this->assertInternalType('float', $this->latLng->getLat());
	}

	public function testGetLng()
	{
		$this->assertEquals($this->lng, $this->latLng->getLng());
	}

	/**
	 * @depends testGetLng
	 */
	public function testLngStoredAsFloat()
	{
		$this->assertInternalType('float', $this->latLng->getLng());
	}

	public function testToString()
	{
		$this->assertInternalType('string', $this->latLng->__toString());
	}
}
