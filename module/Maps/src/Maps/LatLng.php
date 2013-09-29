<?php

namespace Maps;

class LatLng
{
	private $lat;
	private $lng;

	public function __construct($lat, $lng)
	{
		$this->lat = $lat;
		$this->lng = $lng;
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function getLng()
	{
		return $this->lng;
	}

	public function __toString()
	{
		return sprintf('%s, %s', $this->lat, $this->lng);
	}
}
