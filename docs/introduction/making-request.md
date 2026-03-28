# Making Requests

This package provides a fluent API using Laravel facades to interact with Traccar endpoints. All requests are sent via the `TraccarConnector` using Saloon HTTP client.

## Basic Requests

Use facades to make API calls. Each facade corresponds to an endpoint group:

```php
use ThingsTelemetry\Traccar\Facades\Server;
use ThingsTelemetry\Traccar\Facades\Device;
use ThingsTelemetry\Traccar\Facades\User;

// GET requests
$serverInfo = Server::get();
$device = Device::find(id: 1);
$devices = Device::all();
$user = User::get(id: 5);
```

## Creating Resources with DTOs

Use Data Transfer Objects (DTOs) to structure request payloads:

```php
use ThingsTelemetry\Traccar\Facades\Device;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\DeviceAttributesData;

$deviceData = new DeviceData(
    name: 'Vehicle Tracker',
    uniqueId: '123456789012345',
    attributes: new DeviceAttributesData(),
    phone: '+254712345678',
    model: 'GT06N',
);

$device = Device::create(data: $deviceData);
```

## Updating Resources

Pass a modified DTO to update methods:

```php
$device = Device::find(id: 1);
$device->name = 'Updated Name';

$updatedDevice = Device::update(data: $device);
```

## Requests with Parameters

Some methods accept additional parameters:

```php
use ThingsTelemetry\Traccar\Facades\User;
use ThingsTelemetry\Traccar\Facades\Server;
use Carbon\Carbon;

// With date range
$stats = Server::statistics(
    from: Carbon::now()->subDays(7),
    to: Carbon::now()
);

// With coordinates
$address = Server::geocode(
    latitude: -1.2921,
    longitude: 36.8219
);

// With filters
$users = User::all(
    userId: 3,
    keyword: 'jane',
    limit: 10,
);
```

## Why DTOs?

- **Type Safety**: Properties are typed and validated at construction
- **IDE Autocompletion**: Full property suggestions in your IDE
- **Consistency**: Uniform structure across all API interactions
- **Serialization**: Use `toArray()` to convert back to array format

```php
$deviceData = DeviceData::fromArray([
    'name' => 'My Device',
    'uniqueId' => 'ABC123',
    'attributes' => [],
]);

$array = $deviceData->toArray(); // Convert back to array
```
