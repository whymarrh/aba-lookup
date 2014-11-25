<?php

namespace LookupTest\Db;

use Lookup\Db\Location as LocationDb;
use Lookup\Entity\Location;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class LocationTest extends BaseTestCase
{
	protected $locationDb;

	protected function setUp()
	{
		$adapter = new Adapter(array(
			'driver' => 'Pdo_Sqlite',
			'database' => ':memory:',
		));

		$this->createTables($adapter);
		$adapter->query('INSERT INTO ' . Location::TABLE_NAME . ' '
		              . 'VALUES(1, "foo", "bar")', Adapter::QUERY_MODE_EXECUTE);

		$sql = new Sql($adapter);
		$this->locationDb = new LocationDb($sql);
	}

	public function testGetNonexistentLocationReturnsNull()
	{
		$location = $this->locationDb->get(new Location('Somewhere', 'A1A 1A1'));
		$this->assertNull($location);
	}

	public function testCreateLocationReturnsLocationWithIdentifier()
	{
		$location = new Location('Somewhere', 'A1A 1A1');
		$result = $this->locationDb->create($location);
		$this->assertInstanceOf('Lookup\Entity\Location', $result);
		$this->assertEquals(2, $result->getId());
		$this->assertNotSame($location, $result);
	}

	public function testGetLocationReturnsLocationWithIdentifier()
	{
		$location = new Location('Somewhere', 'A1A 1A1');
		$createdLocation = $this->locationDb->create($location);

		$criteria = new Location('Somewhere', 'A1A 1A1');
		$result = $this->locationDb->get($criteria);

		$this->assertInstanceOf('Lookup\Entity\Location', $result);
		$this->assertEquals(2, $result->getId());
		$this->assertNotSame($criteria, $result);
		$this->assertNotSame($location, $createdLocation);
	}

	public function testGetLocationByIdReturnsNullWhenPassedNonexistentId()
	{
		$locationId = $this->locationDb->getById(3);
		$this->assertNull($locationId);
	}

	public function testGetLocationByIdReturnsLocation()
	{
		$location = $this->locationDb->getById(1);
		$this->assertInstanceOf('Lookup\Entity\Location', $location);
		$this->assertInternalType('string', $location->getCity());
		$this->assertEquals($location->getCity(), 'foo');
		$this->assertInternalType('string', $location->getPostalCode());
		$this->assertEquals($location->getPostalCode(), 'bar');
	}
}
