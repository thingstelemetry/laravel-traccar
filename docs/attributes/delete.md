# Delete Attribute

Delete a computed attribute from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Attribute;

$result = Attribute::delete(id: 17);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Attributes](https://www.traccar.org/api-reference/#tag/Attributes/paths/~1attributes~1computed~1%7Bid%7D/delete)
