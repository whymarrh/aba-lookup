<?php

namespace LookupTest\Entity;

use Lookup\Entity\Account;
use Mockery;
use PHPUnit_Framework_TestCase;

class AccountTest extends PHPUnit_Framework_TestCase
{
	protected $user;
	protected $account;

	protected function setUp()
	{
		$this->user = Mockery::mock('Lookup\Entity\User');
		$this->account = new Account('foo-bar-baz', $this->user, 'passw0rd', NULL, 'foo@bar.com', TRUE, NULL, 3, 4, 5);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testGetId()
	{
		$this->assertEquals('foo-bar-baz', $this->account->getId());
	}

	public function testGetUser()
	{
		$this->assertEquals($this->user, $this->account->getUser());
	}

	public function testGetPassword()
	{
		$this->assertEquals('passw0rd', $this->account->getPassword());
	}

	public function testGetPasswordResetCode()
	{
		$this->assertNull($this->account->getPasswordResetCode());
	}

	public function testGetEmail()
	{
		$this->assertEquals('foo@bar.com', $this->account->getEmail());
	}

	public function testIsEmailConfirmed()
	{
		$this->assertTrue($this->account->isEmailConfirmed());
	}

	public function testGetEmailConfirmCode()
	{
		$this->assertNull($this->account->getEmailConfirmCode());
	}

	public function testGetAccessLevel()
	{
		$this->assertEquals(3, $this->account->getAccessLevel());
	}

	public function testGetTermsOfService()
	{
		$this->assertEquals(4, $this->account->getTermsOfService());
	}

	public function testGetCreationTime()
	{
		$this->assertEquals(5, $this->account->getCreationTime());
	}
}
