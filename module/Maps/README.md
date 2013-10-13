Maps module
===========

This module is a simple wrapper around some of the [Google Maps API Web Services].

In the box:

- [Distance Matrix API]
- [Geocoding API]

To-do:

- Error handling

Accessing the API
-----------------

From a ZF2 controller:

    $api = $this->serviceLocator('Maps\Api');

Distance Matrix API
-------------------

From Google's documentation:

> The Google Distance Matrix API is a service that provides travel distance and time for a matrix of origins and destinations. The information returned is based on the recommended route between start and end points, as calculated by the Google Maps API, and consists of rows containing `duration` and `distance values` for each pair.

Given an array of origin addresses and an array of destinations, each with lengths greater than one, the matrix can be computed as shown:

    $origins = ['First place', 'Second place', 'Third place', 'Fourth place'];
    $destinations = ['First place', '2nd place', '3rd place'];
    $matrix = $api->computeDistanceMatrix($origins, $destinations);

The resulting object, `$matrix` in the above snippet, is a two dimensional array with the first indicies being the origins, each containing the distances<sup>*</sup> to the destination addresses in the order the destination addresses were provided.

<sup>*</sup> The distance value is determined my Google Maps' recommeded route from origin to destination. To have the matrix contain the duration instead of the distance, pass `Maps\DistanceMatrix\Api::DURATION` as a 3rd argument to the `calculateMatrix` function.

Additional notes:

- [As the time of writing (October 2013) the Distance Matrix has the following limits: 100 elements per query, 100 elements every 10 seconds, and 2,500 elements per day. Elements being defined as the number *origins* multiplied by the number of *destinations*.](https://developers.google.com/maps/documentation/distancematrix/#Limits)

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

  [Google Maps API Web Services]:https://developers.google.com/maps/documentation/webservices/
  [Directions API]:https://developers.google.com/maps/documentation/directions/
  [Distance Matrix API]:https://developers.google.com/maps/documentation/distancematrix/
  [GeoCoding API]:https://developers.google.com/maps/documentation/geocoding/
