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

	public function testCalculateDistanceMatrixWithSingleOriginToSingleDestination()
	{
		$matrix = $this->api->calculateDistanceMatrix(['A1B 3X9'], ['A1A 5E8']);
		$this->assertCount(1, $matrix);
		$this->assertCount(1, $matrix[0]);
		foreach ($matrix as $row) {
			foreach ($row as $element) {
				$this->assertInternalType('integer', $element);
			}
		}
		$this->assertEquals(7835, $matrix[0][0]);
	}

	public function testCalculateDistanceMatrixWithSingleOriginToMultipleDestinations()
	{
		$matrix = $this->api->calculateDistanceMatrix(['A1B 3X9'], ['A1A 5E8', 'K1A 0A6']);
		$this->assertCount(1, $matrix);
		$this->assertCount(2, $matrix[0]);
		foreach ($matrix as $row) {
			foreach ($row as $element) {
				$this->assertInternalType('integer', $element);
			}
		}
		$this->assertEquals(   7835, $matrix[0][0]);
		$this->assertEquals(2728809, $matrix[0][1]);
	}

	public function testCalculateDistanceMatrixWithMultipleOriginsToMultipleDestinations()
	{
		$matrix = $this->api->calculateDistanceMatrix(
			['A1B 3X9', 'Y1A 2C6', 'V6B 4Y8'],
			['K1A 0A6', 'T2E 7V6', 'T5T 4J2', 'A1C 5M9']
		);
		$this->assertCount(3, $matrix);
		$this->assertCount(4, $matrix[0]);
		foreach ($matrix as $row) {
			foreach ($row as $element) {
				$this->assertInternalType('integer', $element);
			}
		}
		$this->assertEquals(2728809, $matrix[0][0]); // St. John's to Parliment Hill
		$this->assertEquals(6063772, $matrix[0][1]); // St. John's to Calgary Zoo
		$this->assertEquals(6134815, $matrix[0][2]); // St. John's to West Edmonton Mall
		$this->assertEquals(   3246, $matrix[0][3]); // St. John's to Cape Spear (St. John's)
		$this->assertEquals(5384730, $matrix[1][0]); // Yukon to Parliment Hill
		$this->assertEquals(2289236, $matrix[1][1]); // Yukon to Calgary Zoo
		$this->assertEquals(1988853, $matrix[1][2]); // Yukon to West Edmonton Mall
		$this->assertEquals(8108020, $matrix[1][3]); // Yukon to Cape Spear
		$this->assertEquals(4360126, $matrix[2][0]); // BC Place to Parliment Hill
		$this->assertEquals( 973433, $matrix[2][1]); // BC Place to Calgary Zoo
		$this->assertEquals(1154018, $matrix[2][2]); // BC Place to West Edmonton Mall
		$this->assertEquals(7445037, $matrix[2][3]); // BC Place to Cape Spear
	}
}
