<?php

namespace Maps\Geocoding;

use
	InvalidArgumentException,
	Maps\LatLng,
	Zend\Http\ClientStatic as HttpClient,
	Zend\Json\Json
;

/**
 * Wrapper for Geocoding API
 */
class Api
{
	/**
	 * HTTP endpoint URL for the Geocoding API
	 */
	const URL = 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false&region=%s';

	/**
	 * Returns a LatLng object representing address
	 *
	 * @param string $address The address to geocode.
	 * @param string $region The region to bias towards.
	 * @return LatLng
	 * @throws InvalidArgumentException
	 */
	public static function getLatLng($address, $region)
	{
		if (!is_string($region)) {
			throw new InvalidArgumentException('The region must be a string');
		}
		if (!is_string($address)) {
			throw new InvalidArgumentException('The address must be a string.');
		}
		$response = HttpClient::get(sprintf(Api::URL, urlencode($address), $region));
		$result   = Json::decode($response->getBody());
		$location = $result->results[0]->geometry->location;
		return new LatLng($location->lat, $location->lng);
	}
}
