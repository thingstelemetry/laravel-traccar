# Statistics

Fetch aggregated server statistics for a time range.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Server;

$from = CarbonImmutable::parse('01 June 2025');
$to   = CarbonImmutable::parse('25 Nov 2025');

$stats = Server::statistics(from: $from, to: $to); // Illuminate\Support\Collection of ServerStatisticsData
```

## Results

The response is a Laravel Collection of `ServerStatisticsData` items, for example:

```php
$first = $stats->first();
$first->captureTime->toIso8601String(); // "2019-08-24T14:15:22+00:00"
$first->activeUsers; // 2
$first->activeDevices; // 5
$first->requests;  // 120
$first->messagesReceived; // 450
$first->messagesStored; // 440
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\RequestException;

try {
    $stats = Server::statistics(from: $from, to: $to);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid date range,
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - requires admin privileges,
        404 => // No statistics found for the given date range,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar Statistics](https://www.traccar.org/api-reference/#tag/Statistics/paths/~1statistics/get)
- [ServerStatisticsData DTO reference](./../reference/dto/server-statistics-data)