<?php

namespace Maps\DistanceMatrix;

use
	InvalidArgumentException,
	Zend\Http\ClientStatic as HttpClient,
	Zend\Json\Json
;

/**
 * Wrapper around the Distance Matrix API
 */
class Api
{
	/**
	 * HTTP endpoint URL for the Distance Matrix API
	 *
	 * Defaults:
	 * - units = metric
	 * - mode = driving
	 */
	const URL = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s&sensor=false';

	/**
	 * The possible values for the matrix to contain.
	 */
	const DISTANCE = 'distance';
	const DURATION = 'duration';

	/**
	 * Calculates and returns a matrix containing distance values from each origin to each destination
	 *
	 * @param array $origins The array of origin addresses to calculate.
	 * @param array $destinations The array of destination addresses to calculate.
	 * @param string $value The value the matrix should contain for each index. Either 'distance' or 'direction'.
	 * @return array The two-dimensional matrix.
	 * @throws InvalidArgumentException
	 */
	public static function calculateMatrix(array $origins, array $destinations, $value)
	{
		if (!is_string($value)) {
			throw new InvalidArgumentException('The value must be a string.');
		}
		if (count($origins) < 1 || count($destinations) < 1) {
			throw new InvalidArgumentException('The origins and destinations arrays must both contain at least one element.');
		}
		foreach ($origins as $origin) {
			if (!is_string($origin)) {
				throw new InvalidArgumentException('Each address must be a string.');
			}
		}
		foreach ($destinations as $destination) {
			if (!is_string($destination)) {
				throw new InvalidArgumentException('Each destination must be a string.');
			}
		}
		$response = HttpClient::get(sprintf(
			Api::URL,
			implode('|', array_map('urlencode', $origins)),
			implode('|', array_map('urlencode', $destinations))
		));
		$result = Json::decode($response->getBody());
		// We're going to transfer the result data into a "more compact" structure.
		// $result will typically look like this (you can imagine a larger version):
		//
		// stdClass Object
		// (
		//     [origin_addresses] => Array
		//         (
		//             [0] => St. John's, NL A1B 3X9, Canada
		//         )
		//     [destination_addresses] => Array
		//         (
		//             [0] => St. John's, NL A1A 5E8, Canada
		//         )
		//     [rows] => Array
		//         (
		//             [0] => stdClass Object
		//                 (
		//                     [elements] => Array
		//                         (
		//                             [0] => stdClass Object
		//                                 (
		//                                     [distance] => stdClass Object
		//                                         (
		//                                             [text] => 7.8 km
		//                                             [value] => 7835
		//                                         )
		//                                     [duration] => stdClass Object
		//                                         (
		//                                             [text] => 9 mins
		//                                             [value] => 551
		//                                         )
		//                                     [status] => OK
		//                                 )
		//                         )
		//                 )
		//         )
		//     [status] => OK
		// )
		//
		// But since we only need the values, we want something like so: (Assuming we're
		// working for distance values, if we're going for duration values only the value
		// itself would be different.)
		//
		// Array
		// (
		//     [0] => Array
		//         (
		//             [0] => 7835
		//         )
		// )
		//
		// Or something to this effect.
		$matrix = [];
		$count = count($result->rows);
		for ($i = 0; $i < $count; ++$i) {
			$elements = &$result->rows[$i]->elements;
			$count = count($elements);
			for ($j = 0; $j < $count; ++$j) {
				$matrix[$i][] = $elements[$j]->{$value}->value;
			}
		}
		return $matrix;
	}
}
