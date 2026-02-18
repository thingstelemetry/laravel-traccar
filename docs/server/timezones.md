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

## Important Links
- [Traccar API: Timezones](https://www.traccar.org/api-reference/#tag/Server/paths/~1server/timezones/get)