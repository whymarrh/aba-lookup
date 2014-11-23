<?php

namespace LookupTest\Db;

use Lookup\Db\UserAccount as UserAccountDb;
use Lookup\Entity\Account;
use Lookup\Entity\User;
use Mockery;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class UserAccountTest extends BaseTestCase
{
	protected $userAccountDb;

	protected function setUp()
	{
		$adapter = new Adapter(array(
			'driver' => 'Pdo_Sqlite',
			'database' => ':memory:',
		));
		$this->createTables($adapter);

		// Disable foreign key constraint checking to allow mock IDs
		$adapter->query('PRAGMA foreign_keys = OFF', Adapter::QUERY_MODE_EXECUTE);

		$sql = new Sql($adapter);
		$this->userAccountDb = new UserAccountDb($sql);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testCreateAccountReturnsAccountWithIdentifier()
	{
		$account = new Account('paSSw0rd', NULL, 'foo@bar.baz', FALSE, NULL, 0, 0, time());
		$result = $this->userAccountDb->createAccount($account);
		$this->assertInstanceOf('Lookup\Entity\Account', $result);
		$this->assertNotEmpty($result->getId());
		$this->assertNotSame($account, $result);
	}

	public function testCreateUserReturnsUserWithIdentifier()
	{
		$account = Mockery::mock('Lookup\Entity\Account')->shouldReceive('getId')->andReturn(1)->mock();
		$userDisplayName = Mockery::mock('Lookup\Entity\UserDisplayName')->shouldReceive('getId')->andReturn(1)->mock();
		$userType = Mockery::mock('Lookup\Entity\UserType')->shouldReceive('getId')->andReturn(1)->mock();
		$location = Mockery::mock('Lookup\Entity\Location')->shouldReceive('getId')->andReturn(1)->mock();
		$user = new User($account, $userDisplayName, $userType, $location, 'foo', 'bar', FALSE, 0, time());
		$result = $this->userAccountDb->createUser($user);
		$this->assertInstanceOf('Lookup\Entity\User', $user);
		$this->assertNotEmpty($result->getId());
		$this->assertNotSame($user, $result);
	}
}
