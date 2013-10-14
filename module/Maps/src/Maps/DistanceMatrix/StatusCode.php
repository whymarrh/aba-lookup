<?php

namespace Maps\DistanceMatrix;

/**
 * As per -- https://developers.google.com/maps/documentation/distancematrix/#StatusCodes
 */
class StatusCode
{
	/**
	 * Status codes for the Distance Matrix API
	 */
	const INVALID_REQUEST       = 'INVALID_REQUEST';
	const MAX_ELEMENTS_EXCEEDED = 'MAX_ELEMENTS_EXCEEDED';
	const NOT_FOUND             = 'NOT_FOUND';
	const OK                    = 'OK';
	const OVER_QUERY_LIMIT      = 'OVER_QUERY_LIMIT';
	const REQUEST_DENIED        = 'REQUEST_DENIED';
	const UNKNOWN_ERROR         = 'UNKNOWN_ERROR';
	const ZERO_RESULTS          = 'ZERO_RESULTS';
}
