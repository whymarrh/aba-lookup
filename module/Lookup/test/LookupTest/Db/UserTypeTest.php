<?php

namespace LookupTest\Db;

use Lookup\Db\UserType as UserTypeDb;
use Lookup\Entity\UserType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class UserTypeTest extends BaseTestCase
{
	protected $userTypeDb;

	protected function setUp()
	{
		$adapter = new Adapter(array(
			'driver' => 'Pdo_Sqlite',
			'database' => ':memory:',
		));
		$this->createTables($adapter);

		// Test data
		$adapter->query('INSERT INTO user_type(id, name) VALUES(1, "bar")', Adapter::QUERY_MODE_EXECUTE);

		$sql = new Sql($adapter);
		$this->userTypeDb = new UserTypeDb($sql);
	}

	public function testGetNonexistentUserTypeReturnsNull()
	{
		$userType = new UserType('foo');
		$result = $this->userTypeDb->get($userType);
		$this->assertNull($result);
	}

	public function testGetUserTypeReturnsUserType()
	{
		$userType = new UserType('bar');
		$result = $this->userTypeDb->get($userType);
		$this->assertInstanceOf('Lookup\Entity\UserType', $result);
		$this->assertEquals(1, $result->getId());
	}
}
