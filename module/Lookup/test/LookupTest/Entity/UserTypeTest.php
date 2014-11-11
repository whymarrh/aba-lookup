<?php

namespace LookupTest\Entity;

use Lookup\Entity\UserType;
use PHPUnit_Framework_TestCase;

class UserTypeTest extends PHPUnit_Framework_TestCase
{
	protected $type;

	protected function setUp()
	{
		$this->type = new UserType('foo');
	}

	public function testSetGetId()
	{
		$id = 42;
		$this->type->setId($id);
		$this->assertEquals($id, $this->type->getId());
	}

	public function testGetName()
	{
		$this->assertEquals('foo', $this->type->getName());
	}
}
