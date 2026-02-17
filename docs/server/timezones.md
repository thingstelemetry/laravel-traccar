# Timezones

Retrieve the list of timezones supported by the server. No admin privileges are required.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Server;

$zones = Server::timezones(); // Illuminate\Support\Collection of strings
```

## Results

The response is a Laravel Collection of timezone identifiers, for example:

```php
$zones->take(5)->all();
// ["UTC", "Africa/Abidjan", "Africa/Accra", "Africa/Addis_Ababa", "Africa/Algiers"]
```

## Generate Timezone List in PHP (alternative)

If you need to generate a timezone list in PHP (independent of the API), you can use the built-in identifiers:

```php
$timezones = \DateTimeZone::listIdentifiers();
// or
$timezones = timezone_identifiers_list();
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\RequestException;

try {
    $zones = Server::timezones();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        default => // Handle other errors
    };
}
```