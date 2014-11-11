<?php

namespace Lookup\Entity;

trait Id
{
	/**
	 * The ID for the entity
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Set the ID for the entity
	 *
	 * @param int $id The ID for the entity.
	 * @throws Exception\InvalidArgumentException If the ID is not an int.
	 * @return self
	 */
	public final function setId($id)
	{
		if (!is_int($id)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects an int.',
				__METHOD__
			));
		}
		$this->id = $id;
		return $this;
	}

	/**
	 * @return int The ID for the entity.
	 */
	public function getId()
	{
		return $this->id;
	}
}
