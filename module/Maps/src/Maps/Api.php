<?php

namespace Maps;

use
	Maps\Geocoding\Api as GeocodingApi
;

/**
 * Wrapper API for the Google Maps API Web Services
 */
class Api
{
	/**
	 * Returns a LatLng object representing address
	 *
	 * @param string $address The address to geocode.
	 * @param string $region The ccTLD of a region to bias towards. Defaults is Canada.
	 * @return LatLng
	 * @throws InvalidArgumentException
	 */
	public function getLatLng($address, $region = 'ca')
	{
		return GeocodingApi::getLatLng($address, $region);
	}
}
