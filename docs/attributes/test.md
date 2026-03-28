# Test Computed Attribute

Test a computed attribute against the latest position of a device.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Attribute;
use ThingsTelemetry\Traccar\Dto\AttributeData;

$attributeData = new AttributeData(
    description: 'Overspeed',
    attribute: 'overspeed',
    expression: 'speed > 80',
    type: 'boolean'
);

$result = Attribute::test(deviceId: 6, data: $attributeData);
```

## Result

Returns the result of the computation. The return type can be `string`, `int`, `float`, `bool`, or `null` depending on the attribute type and computation result.

## Important Links
- [Traccar Attributes](https://www.traccar.org/api-reference/#tag/Attributes/paths/~1attributes~1computed~1test/post)
