<?php

namespace MapsTest;

use
	Maps\Api,
	PHPUnit_Framework_TestCase
;

/**
 * Test methods for the Pairing entity
 */
class ApiTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Api
	 */
	protected $api;

	/**
	 * Resets for isolation
	 */
	public function setUp()
	{
		$this->api = new Api();
		$this->assertInstanceOf('Maps\Api', $this->api);
	}

	public function testGetLatLngForPostalCode()
	{
		$address = 'A1B 3X9';
		$this->assertInternalType('string', $address);
		$latLng = $this->api->getLatLng($address, 'ca');
		$this->assertInstanceOf('Maps\LatLng', $latLng);
		$this->assertInternalType('float', $latLng->getLat());
		$this->assertInternalType('float', $latLng->getLng());
		$this->assertEquals( 47.5709447, $latLng->getLat());
		$this->assertEquals(-52.7305255, $latLng->getLng());
	}
}
