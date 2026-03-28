# Update Attribute

Update a computed attribute in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Facades\Attribute;

$attribute = Attribute::update(new AttributeData(
    id: 17,
    description: 'Overspeed',
    attribute: 'overspeed',
    expression: 'speed > 80',
    type: 'Boolean',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\AttributeData`.

## Important Links
- [Traccar Attributes](https://www.traccar.org/api-reference/#tag/Attributes/paths/~1attributes~1computed~1%7Bid%7D/put)
