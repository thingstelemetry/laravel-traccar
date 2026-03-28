# Combined Report Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\CombinedReportData` represents the result of a combined report query. It groups multiple data types (Route, Events) for a single device.

## `deviceId` → `integer`
The ID of the device this report data belongs to.

## `route` → `Collection<int, PositionData>`
A collection of `PositionData` objects representing the route taken by the device.

## `events` → `Collection<int, EventData>`
A collection of `EventData` objects representing events that occurred during the report interval.
