<?php

namespace Maps;

use
	Maps\DistanceMatrix\Api as DistanceMatrixApi,
	Maps\Geocoding\Api as GeocodingApi
;

/**
 * Wrapper API for the Google Maps API Web Services
 */
class Api
{
	/**
	 * Calculates and returns a matrix containing distance values from each origin to each destination
	 *
	 * @param array $origins The array of origin addresses to calculate.
	 * @param array $destinations The array of destination addresses to calculate.
	 * @param string $value The value the matrix should contain for each index. Either distance or direction.
	 * @return array The two-dimensional matrix.
	 * @throws InvalidArgumentException
	 */
	public function calculateDistanceMatrix(array $origins, array $destinations, $value = DistanceMatrixApi::DISTANCE)
	{
		return DistanceMatrixApi::calculateMatrix($origins, $destinations, $value);
	}

	/**
	 * Returns a LatLng object representing address
	 *
	 * @param string $address The address to geocode.
	 * @param string $region The ccTLD of a region to bias towards. Defaults is Canada.
	 * @return LatLng
	 * @throws InvalidArgumentException
	 */
	public function geocode($address, $region = 'ca')
	{
		return GeocodingApi::getLatLng($address, $region);
	}
}
