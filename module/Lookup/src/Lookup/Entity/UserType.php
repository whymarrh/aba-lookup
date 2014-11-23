<?php

namespace Lookup\Entity;

class UserType
{
	use Id;

	const TABLE_NAME = 'user_type';

	/**
	 * The name of the type.
	 *
	 * @var string|NULL
	 */
	private $name;

	/**
	 * @param string $name The name of the user type
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct($name)
	{
		$this->setName($name);
	}

	/**
	 * @param string|NULL $name The name of the type.
	 * @throws Exception\InvalidArgumentException If the name is of an invalid type.
	 * @return self
	 */
	public final function setName($name)
	{
		if (!is_string($name) && !is_null($name)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a string or NULL value.',
				__METHOD__
			));
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string|NULL The name of the type.
	 */
	public function getName()
	{
		return $this->name;
	}
}
