Maps module
===========

This module is a simple wrapper around some of the [Google Maps API Web Services].

In the box:

- [Distance Matrix API]
- [Geocoding API]

Accessing the API
-----------------

    $api = $this->serviceLocator('Maps\Api');

Geocoding API
-------------

From Google's documenation:

> Geocoding is the process of converting addresses (like "1600 Amphitheatre Parkway, Mountain View, CA") into geographic coordinates (like latitude 37.423021 and longitude -122.083739), which you can use to place markers or position the map.

To convert an address into a geographic coordinate:

    $addr = '1600 Amphitheatre Parkway, Mountain View, CA';
    $ll = $api->getLatLng($addr);
    $lat = $coord->getLat();
    $lng = $coord->getLng();

Additonal notes:

- In the case that the address is too ambiguious to return a single result, the first result is what is returned.
- [As of writing (October 2013) the Geocoding API has the following limits: 2,500 request per day (24 hrs).](https://developers.google.com/maps/documentation/geocoding/#Limits)

Todo:

- Error handling

  [Google Maps API Web Services]:https://developers.google.com/maps/documentation/webservices/
  [Directions API]:https://developers.google.com/maps/documentation/directions/
  [Distance Matrix API]:https://developers.google.com/maps/documentation/distancematrix/
  [GeoCoding API]:https://developers.google.com/maps/documentation/geocoding/
