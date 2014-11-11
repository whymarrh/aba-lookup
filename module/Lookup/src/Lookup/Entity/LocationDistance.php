<?php

namespace Lookup\Entity;

class LocationDistance
{
	use Id;

	/**
	 * Location A
	 *
	 * @var Location
	 */
	private $a;

	/**
	 * Location B
	 *
	 * @var Location
	 */
	private $b;

	/**
	 * The distance between A and B.
	 *
	 * @var int
	 */
	private $distance;

	/**
	 * Constructor
	 *
	 * @param Location $a Location A.
	 * @param Location $b Location B.
	 * @param int $distance The distance between location A and B.
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct(Location $a, Location $b, $distance)
	{
		$this->setLocationA($a);
		$this->setLocationB($b);
		$this->setDistance($distance);
	}

	/**
	 * @param Location $a Location A.
	 * @return self
	 */
	public final function setLocationA(Location $a)
	{
		$this->a = $a;
		return $this;
	}

	/**
	 * @param Location $b Location B.
	 * @return self
	 */
	public final function setLocationB(Location $b)
	{
		$this->b = $b;
		return $this;
	}

	/**
	 * Set the distance between location A and B
	 *
	 * @param int $distance The distance.
	 * @throws Exception\InvalidArgumentException If the distance is not an int.
	 * @return self
	 */
	public final function setDistance($distance)
	{
		if (!is_int($distance)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects an int.',
				__METHOD__
			));
		}
		$this->distance = $distance;
		return $this;
	}

	/**
	 * @return Location Location A.
	 */
	public function getLocationA()
	{
		return $this->a;
	}

	/**
	 * @return Location Location B.
	 */
	public function getLocationB()
	{
		return $this->b;
	}

	/**
	 * @return int The distance from locations A to B.
	 */
	public function getDistance()
	{
		return $this->distance;
	}
}
