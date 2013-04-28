php-geopoint-api
==================

ORM agnostic php library to access Neustar's GeoPoint REST api

Installation
=============
Add to composer
```js
    "require": {
        "ner0tic/php-api-core":     "*",
        "ner0tic/php-geopoint-api":   "*"
        // ...
```

Usage
=============
```php
$geo = new \GeoPoint\Client();

$geo->setApiKey( 'XXXXXXXXXXX' );
$geo->setSecret( 'XXXXXXX' );

$ipinfo = $geo->get( $ip );

$city = $ipinfo->Location->CityData->city;

```

To Do
=============
- Clean up ip info data retrieval