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

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\RequestException;

try {
    $address = Server::geocode(latitude: -1.286389, longitude: 36.817223);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid coordinates or geocoding disabled,
        401 => // Unauthorized - check API credentials,
        404 => // No address found for coordinates,
        default => // Handle other errors
    };
}
```