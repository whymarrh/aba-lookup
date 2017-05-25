<?php

namespace Maps;

use
	InvalidArgumentException
;

/**
 * Represents a point on the Earth's surface with two distinct properties,
 * the latitude and longitude.
 *
 * As per -- https://en.wikipedia.org/wiki/Coordinates_(geographic)
 */
class LatLng
{
	/**
	 * The latitude of the point
	 *
	 * @var float
	 */
	private $lat;

	/**
	 * The longitude of the point
	 *
	 * @var float
	 */
	private $lng;

	/**
	 * Constructor
	 *
	 * @param numeric $lat The latitude of the point.
	 * @param numeric $lng The longitude of the point.
	 */
	public function __construct($lat, $lng)
	{
		if (!is_numeric($lat) || !is_numeric($lng)) {
			throw new InvalidArgumentException('Latitude and longitude values must be numbers.');
		}
		$this->lat = (float) $lat;
		$this->lng = (float) $lng;
	}

	/**
	 * Returns the latitude of the point
	 *
	 * @return float
	 */
	public function getLat()
	{
		return $this->lat;
	}

	/**
	 * Returns the longitude of the point
	 *
	 * @return float
	 */
	public function getLng()
	{
		return $this->lng;
	}

	/**
	 * Returns a string representation of the point
	 *
	 * @return string
	 */
	public function __toString()
	{
		return sprintf('%s, %s', $this->lat, $this->lng);
	}
}
