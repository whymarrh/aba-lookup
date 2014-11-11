<?php

namespace LookupTest\Entity;

use Lookup\Entity\UserDisplayName;
use Mockery;
use PHPUnit_Framework_TestCase;

class UserDisplayNameTest extends PHPUnit_Framework_TestCase
{
	protected $user;
	protected $displayName;

	protected function setUp()
	{
		$this->user = Mockery::mock('Lookup\Entity\User');
		$this->displayName = new UserDisplayName($this->user, 'foo', 42);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

	public function testSetGetId()
	{
		$id = 42;
		$this->displayName->setId($id);
		$this->assertEquals($id, $this->displayName->getId());
	}

	public function testGetUser()
	{
		$this->assertEquals($this->user, $this->displayName->getUser());
	}

	public function testGetDisplayName()
	{
		$this->assertEquals('foo', $this->displayName->getDisplayName());
	}

	public function testGetCreationTime()
	{
		$this->assertEquals(42, $this->displayName->getCreationTime());
	}
}
