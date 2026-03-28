# Update Order

Update an existing order in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Facades\Order;

$order = Order::update(new OrderData(
    id: 13,
    uniqueId: 'ORD-1001',
    description: 'Deliver package',
    fromAddress: 'Warehouse',
    toAddress: 'Customer',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\OrderData`.

## Important Links
- [Traccar Orders](https://www.traccar.org/api-reference/#tag/Orders/paths/~1orders~1%7Bid%7D/put)
