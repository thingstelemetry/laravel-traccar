# Retrieve Event Information

Fetch a specific event by its ID from your Traccar server.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Event::get(int $id)` method to retrieve a single event.

```php
use ThingsTelemetry\Traccar\Facades\Event;

$event = Event::get(1234); // ThingsTelemetry\Traccar\Dto\EventData
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\EventData`.

```php
$id         = $event->id; / 1234
$type       = $event->type; // "geofenceEnter", "ignitionOn", etc.
$occurredAt = $event->eventTime->toIso8601String();
$deviceId   = $event->deviceId; // 42
$positionId = $event->positionId; // maybe null depending on an event type
$geofenceId = $event->geofenceId; // maybe null
$attrs      = $event->attributes; // array<string, mixed>
```

## Important Links
- [Traccar: Get Event by ID](https://www.traccar.org/api-reference/#tag/Events/paths/~1events~1%7Bid%7D/get)
- [EventData DTO reference](./../reference/dto/event-data)