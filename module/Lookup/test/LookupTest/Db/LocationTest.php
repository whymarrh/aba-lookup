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
		$this->assertEquals(1, $result->getId());
	}

	public function testGetLocationReturnsLocationWithIdentifier()
	{
		$location = new Location('Somewhere', 'A1A 1A1');
		$createdLocation = $this->locationDb->create($location);

		$criteria = new Location('Somewhere', 'A1A 1A1');
		$result = $this->locationDb->get($criteria);

		$this->assertInstanceOf('Lookup\Entity\Location', $result);
		$this->assertEquals(1, $result->getId());
	}
}
