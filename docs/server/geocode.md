# Reverse Geocode

Convert coordinates (latitude, longitude) to a human-readable address. 

> [!IMPORTANT]
> [Geo decoding must be enabled](./../reference/dto/server-data#geocoderenabled-→-boolean) on the server to use this feature.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Server;

$address = Server::geocode(latitude: -1.286389, longitude: 36.817223);
```

## Results

The response is a string address, e.g.:

```php
// Nairobi Expressway, Nairobi, Nairobi County, KE
```