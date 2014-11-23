<?php

namespace LookupTest\Entity;

use Lookup\Entity\UserType;
use PHPUnit_Framework_TestCase;

class UserTypeTest extends PHPUnit_Framework_TestCase
{
	public function testSetGetId()
	{
		$id = 42;
		$userType = new UserType('foo');
		$userType->setId($id);
		$this->assertEquals($id, $userType->getId());
	}

	public function testGetName()
	{
		$name = 'foo';
		$userType = new UserType($name);
		$this->assertEquals($name, $userType->getName());
	}
}
