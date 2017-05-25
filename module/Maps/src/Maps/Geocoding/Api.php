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
	 * @param bool $retry Is this a 2nd attempt at this request.
	 * @return LatLng
	 * @throws InvalidArgumentException If the given parameters are not vaild types.
	 * @throws GeocodingException If the provided address does not translate.
	 */
	public static function getLatLng($address, $region, $retry = FALSE)
	{
		if (!is_string($region)) {
			throw new InvalidArgumentException('The region must be a string');
		}
		if (!is_string($address)) {
			throw new InvalidArgumentException('The address must be a string.');
		}
		$response = HttpClient::get(sprintf(Api::URL, urlencode($address), $region));
		$result   = Json::decode($response->getBody());
		switch ($result->status) {
			case StatusCode::OK:
				// All good.
				break;
			case StatusCode::UNKNOWN_ERROR:
				if (!$retry) {
					// Reattempt request only once
					Api::getLatLng($address, $region, TRUE);
				}
			case StatusCode::INVALID_REQUEST:
			case StatusCode::OVER_QUERY_LIMIT:
			case StatusCode::REQUEST_DENIED:
			case StatusCode::ZERO_RESULTS:
				throw new GeocodingException($result->status);
				break;
		}
		$location = $result->results[0]
		                   ->geometry
		                   ->location;
		return new LatLng($location->lat, $location->lng);
	}
}
