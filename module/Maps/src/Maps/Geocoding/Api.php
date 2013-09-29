<?php

namespace Maps\Geocoding;

use
	Maps\LatLng,
	Zend\Http\ClientStatic as HttpClient,
	Zend\Json\Json
;

class Api
{
	const URL = 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false';

	public static function getLatLng($address)
	{
		$response = HttpClient::get(sprintf(Api::URL, urlencode($address)));
		$result   = Json::decode($response->getBody());
		$location = $result->results[0]->geometry->location;
		return new LatLng($location->lat, $location->lng);
	}
}
