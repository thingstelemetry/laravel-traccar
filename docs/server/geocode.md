# Reverse Geocode

Convert coordinates (latitude, longitude) to a human-readable address. 

> [!IMPORTANT]
> [Geo decoding must be enabled](./../reference/dto/server-data#geocoderenabled-→-boolean) on the server to use this feature.

## Request

```php

$address = \ThingsTelemetry\Traccar\Facades\Server::geocode(latitude: -1.286389, longitude: 36.817223);
```

## Results

The response is a string address, e.g.:

```php
// Nairobi Expressway, Nairobi, Nairobi County, KE
```

## Important Links
- [Traccar API: Geocoding](https://www.traccar.org/api-reference/#tag/Server/paths/~1geocode/get)