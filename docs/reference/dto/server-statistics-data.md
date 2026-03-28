# Server Statistics Data DTO

Represents one statistics record returned by the Traccar `/statistics` endpoint.

```php
$stats = Server::statistics($from, $to);
$first = $stats->first();
```

## `captureTime` → `CarbonImmutable`
ISO 8601 timestamp when the snapshot was captured.

## `activeUsers` → `integer`
Number of active users.

## `activeDevices` → `integer`
Number of active devices.

## `requests` → `integer`
Number of HTTP requests processed.

## `messagesReceived` → `integer`
Number of messages received from devices.

## `messagesStored` → `integer`
Number of messages stored after processing.