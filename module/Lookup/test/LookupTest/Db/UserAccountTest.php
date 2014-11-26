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

		$adapter->query('INSERT INTO ' . Account::TABLE_NAME . ' '
		              . 'VALUES("x-y-z", "password", NULL, "email@add.ress", 0, NULL, 1, 2, 3)', Adapter::QUERY_MODE_EXECUTE);

		$adapter->query('INSERT INTO ' . User::TABLE_NAME . ' '
		              . 'VALUES("b-b-b", "x-y-z", 4, 1, 4, "foo", "bar", 0, 0, 0)', Adapter::QUERY_MODE_EXECUTE);

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

	public function testGetAccountByEmailReturnsNullWhenNonexistentIdPassed()
	{
		$account = $this->userAccountDb->getAccountByEmail('this.does.not@exi.st');
		$this->assertNull($account);
	}

	public function testGetAccountByEmailReturnsAccount()
	{
		$account = $this->userAccountDb->getAccountByEmail('email@add.ress');
		$this->assertInstanceOf('Lookup\Entity\Account', $account);
		$this->assertNotNull($account->getId());
		$this->assertEquals('x-y-z', $account->getId());
	}

	public function testGetAccountIdForUserIdReturnsNullWhenNonexistentIdPassed()
	{
		$accountId = $this->userAccountDb->getAccountIdForUserId('a-a-a');
		$this->assertNull($accountId);
	}

	public function testGetAccountIdForUserIdReturnsAccountId()
	{
		$accountId = $this->userAccountDb->getAccountIdForUserId('b-b-b');
		$this->assertInternalType('string', $accountId);
		$this->assertEquals($accountId, 'x-y-z');
	}

	public function testGetAccountByIdReturnsNullWhenNonexistentIdPassed()
	{
		$result = $this->userAccountDb->getAccountById('a-a-a');
		$this->assertNull($result);
	}

	public function testGetAccountByIdReturnsAccount()
	{
		$account = $this->userAccountDb->getAccountById('x-y-z');
		$this->assertInstanceOf('Lookup\Entity\Account', $account);
		$this->assertEquals($account->getId(), 'x-y-z');
		$this->assertEquals($account->getPassword(), 'password');
		$this->assertNull($account->getPasswordResetCode());
		$this->assertEquals($account->getEmail(), 'email@add.ress');
		$this->assertFalse($account->isEmailConfirmed());
		$this->assertNull($account->getEmailConfirmCode());
		$this->assertInternalType('int', $account->getAccessLevel());
		$this->assertEquals($account->getAccessLevel(), 1);
		$this->assertInternalType('int', $account->getTermsOfService());
		$this->assertEquals($account->getTermsOfService(), 2);
		$this->assertInternalType('int', $account->getCreationTime());
		$this->assertEquals($account->getCreationTime(), 3);
	}

	public function testGetUserTypeIdForUserIdReturnsNullWhenNonexistentIdPassed()
	{
		$userTypeId = $this->userAccountDb->getUserTypeIdForUserId('a-a-a');
		$this->assertNull($userTypeId);
	}

	public function testGetUserTypeIdForUserIdReturnsUserType()
	{
		$userTypeId = $this->userAccountDb->getUserTypeIdForUserId('b-b-b');
		$this->assertInternalType('int', $userTypeId);
		$this->assertEquals($userTypeId, 1);
	}

	public function testGetLocationIdForUserIdReturnsNullWhenPassedNonexistenLocation()
	{
		$locationId = $this->userAccountDb->getLocationIdForUserId('a-a-a');
		$this->assertNull($locationId);
	}

	public function testGetLocationIdForUserIdReturnsLocationId()
	{
		$locationId = $this->userAccountDb->getLocationIdForUserId('b-b-b');
		$this->assertNotNull($locationId);
		$this->assertInternalType('int', $locationId);
		$this->assertEquals($locationId, 4);
	}

	public function testGetUserIdForAccountIdReturnsNullWhenNonexistentAccountIdPassed()
	{
		$userId = $this->userAccountDb->getUserIdForAccountId('a-a-a');
		$this->assertNull($userId);
	}

	public function testGetUserIdForAccountIdReturnsUserId()
	{
		$userId = $this->userAccountDb->getUserIdForAccountId('x-y-z');
		$this->assertNotNull($userId);
		$this->assertInternalType('string', $userId);
		$this->assertEquals('b-b-b', $userId);
	}

	public function testGetUserReturnsNullWhenPassedNonexistentId()
	{
		$account = Mockery::mock('Lookup\Entity\Account');
		$userDisplayName = Mockery::mock('Lookup\Entity\UserDisplayName');
		$userType = Mockery::mock('Lookup\Entity\UserType');
		$location = Mockery::mock('Lookup\Entity\Location');
		$result = $this->userAccountDb->getUser('a-a-a', $account, $userDisplayName, $userType, $location);
		$this->assertNull($result);
	}

	public function testGetUserReturnsUser()
	{
		$account = Mockery::mock('Lookup\Entity\Account');
		$userDisplayName = Mockery::mock('Lookup\Entity\UserDisplayName');
		$userType = Mockery::mock('Lookup\Entity\UserType');
		$location = Mockery::mock('Lookup\Entity\Location');
		$result = $this->userAccountDb->getUser('b-b-b', $account, $userDisplayName, $userType, $location);
		$this->assertInstanceOf('Lookup\Entity\User', $result);
		$this->assertNotEmpty($result->getId());
		$this->assertInternalType('string', $result->getId());
		$this->assertEquals($result->getId(), 'b-b-b');
	}
}
