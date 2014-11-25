<?php

namespace LookupTest\Db;

use Lookup\Db\UserDisplayName as UserDisplayNameDb;
use Lookup\Entity\UserDisplayName;
use Mockery;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class UserDisplayNameTest extends BaseTestCase
{
	protected $userDisplayNameDb;

	protected function setUp()
	{
		$adapter = new Adapter(array(
			'driver' => 'Pdo_Sqlite',
			'database' => ':memory:',
		));
		$this->createTables($adapter);

		// Disable foreign key constraint checking to allow mock IDs
		$adapter->query('PRAGMA foreign_keys = OFF', Adapter::QUERY_MODE_EXECUTE);
		$adapter->query('INSERT INTO ' . UserDisplayName::TABLE_NAME . ' '
		              . 'VALUES(1, "b-b-b", "Fake Name", 3)', Adapter::QUERY_MODE_EXECUTE);

		$sql = new Sql($adapter);
		$this->userDisplayNameDb = new UserDisplayNameDb($sql);
	}

	public function testCreateDisplayNameReturnsDisplayNameWithIdentifier()
	{
		$userDisplayName = new UserDisplayName(NULL, 'John Smith', time());
		$result = $this->userDisplayNameDb->create($userDisplayName);
		$this->assertInstanceOf('Lookup\Entity\UserDisplayName', $result);
		$this->assertNotSame($userDisplayName, $result);
		$this->assertNotNull($result->getId());
	}

	public function testUpdateDisplayNameReturnsUpdatedDisplayName()
	{
		$userDisplayName = new UserDisplayName(NULL, 'John Smith', time());
		$result = $this->userDisplayNameDb->create($userDisplayName);
		$this->assertInstanceOf('Lookup\Entity\UserDisplayName', $result);
		$this->assertNotSame($userDisplayName, $result);
		$this->assertNotNull($result->getId());

		$userDisplayName = $result;
		$user = Mockery::mock('Lookup\Entity\User')->shouldReceive('getId')->andReturn(1)->mock();
		$userDisplayName->setUser($user);
		$updatedUserDisplayName = $this->userDisplayNameDb->update($userDisplayName);
		$this->assertInstanceOf('Lookup\Entity\UserDisplayName', $updatedUserDisplayName);
		$this->assertNotSame($userDisplayName, $updatedUserDisplayName);
		$this->assertNotNull($updatedUserDisplayName->getId());
		$this->assertEquals($user->getId(), $updatedUserDisplayName->getUser()->getId());
	}

	public function testGetByUserIdReturnsNullWhenPassesNonexistentUserId()
	{
		$id = 'a-a-a';
		$result = $this->userDisplayNameDb->getByUserId($id);
		$this->assertNull($result);
	}

	public function testGetByUserIdReturnsUserDisplayName()
	{
		$id = 'b-b-b';
		$result = $this->userDisplayNameDb->getByUserId($id);
		$this->assertInstanceOf('Lookup\Entity\UserDisplayName', $result);
		$this->assertNotNull($result->getId());
		$this->assertNull($result->getUser());
		$this->assertNotNull($result->getDisplayName());
		$this->assertNotNull($result->getCreationTime());
	}
}
