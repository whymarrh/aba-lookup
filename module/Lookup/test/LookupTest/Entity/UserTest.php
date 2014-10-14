<?php

namespace LookupTest\Entity;

use Lookup\Entity\User;
use Mockery;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
	protected $location;
	protected $userType;
	protected $displayName;
	protected $user;

	protected function setUp()
	{
		$this->location = Mockery::mock('Lookup\Entity\Location');
		$this->userType = Mockery::mock('Lookup\Entity\UserType');
		$this->displayName = Mockery::mock('Lookup\Entity\UserDisplayName');
		$this->user = new User('foo-bar-baz', $this->displayName, $this->userType, $this->location, 'foo', 'bar', FALSE, 3, 4);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testGetId()
	{
		$this->assertEquals('foo-bar-baz', $this->user->getId());
	}

	public function testGetDisplayName()
	{
		$this->assertEquals($this->displayName, $this->user->getDisplayName());
	}

	public function testGetUserType()
	{
		$this->assertEquals($this->userType, $this->user->getUserType());
	}

	public function testGetLocation()
	{
		$this->assertEquals($this->location, $this->user->getLocation());
	}

	public function testGetGender()
	{
		$this->assertEquals('foo', $this->user->getGender());
	}

	public function testGetPhoneNumber()
	{
		$this->assertEquals('bar', $this->user->getPhoneNumber());
	}

	public function testIsAbaCourse()
	{
		$this->assertFalse($this->user->isAbaCourse());
	}

	public function testGetCertificateOfConduct()
	{
		$this->assertEquals(3, $this->user->getCertificateOfConduct());
	}

	public function testGetCreationTime()
	{
		$this->assertEquals(4, $this->user->getCreationTime());
	}
}
