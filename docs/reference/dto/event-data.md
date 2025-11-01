# Event Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\EventData` represents a Traccar event entity. Events describe state changes or notable conditions detected by the server (e.g., geofence enter/exit, ignition on/off, overspeed, etc.).

```php
use ThingsTelemetry\Traccar\Facades\Event;

$event = Event::get(1234); // EventData
```

## `id` → `integer`
Unique event identifier in Traccar.

```php
$event->id; // 1234
```

## `type` → `string`
Traccar event type string (e.g., `"geofenceEnter"`, `"ignitionOn"`, `"deviceOnline"`).

```php
$event->type; // "geofenceEnter"
```

## `eventTime` → `CarbonImmutable`
Time the event occurred, parsed from ISO 8601.

```php
$event->eventTime->toIso8601String(); // "2019-08-24T14:15:22Z"
```

## `deviceId` → `integer`
The device associated with this event.

```php
$event->deviceId; // 42
```

## `positionId` → `integer|null`
Associated position record ID, if applicable for the event type.

```php
$event->positionId; // 98765 or null
```

## `geofenceId` → `integer|null`
Associated geofence ID for geofence-related events.

```php
$event->geofenceId; // 3 or null
```

## `maintenanceId` → `integer|null`
Associated maintenance record ID, if applicable.

```php
$event->maintenanceId; // 10 or null
```

## `attributes` → `array<string, mixed>`
Event-specific attributes payload returned by Traccar.

```php
$event->attributes; // [ 'alarm' => 'powerCut', 'speed' => 32.1, ... ]
```