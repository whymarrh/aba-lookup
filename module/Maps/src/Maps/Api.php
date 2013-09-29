<?php

namespace Maps;

use
	Maps\Geocoding\Api as GeocodingApi
;

class Api
{
	public function getLatLng($address)
	{
		return GeocodingApi::getLatLng($address);
	}
}
