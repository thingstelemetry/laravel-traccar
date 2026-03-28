# Create Order

Create an order in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Facades\Order;

$order = Order::create(new OrderData(
    uniqueId: 'ORD-1001',
    description: 'Deliver package',
    fromAddress: 'Warehouse',
    toAddress: 'Customer',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\OrderData`.

## Important Links
- [Traccar Orders](https://www.traccar.org/api-reference/#tag/Orders/paths/~1orders/post)
