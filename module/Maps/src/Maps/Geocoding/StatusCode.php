<?php

namespace Maps\Geocoding;

/**
 * As per -- https://developers.google.com/maps/documentation/geocoding/#StatusCodes
 */
class StatusCode
{
	/**
	 * Status codes for the Geocoding API
	 */
	const INVALID_REQUEST  = 'INVALID_REQUEST';
	const OK               = 'OK';
	const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
	const REQUEST_DENIED   = 'REQUEST_DENIED';
	const UNKNOWN_ERROR    = 'UNKNOWN_ERROR';
	const ZERO_RESULTS     = 'ZERO_RESULTS';
}
