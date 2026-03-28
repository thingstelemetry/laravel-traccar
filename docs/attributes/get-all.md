# Get All Attributes

Fetch computed attributes from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Attribute;

$attributes = Attribute::getAll(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\AttributeData>`.

## Important Links
- [Traccar Attributes](https://www.traccar.org/api-reference/#tag/Attributes/paths/~1attributes~1computed/get)
