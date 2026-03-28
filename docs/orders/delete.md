# Delete Order

Delete an order from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Order;

$result = Order::delete(id: 13);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Orders](https://www.traccar.org/api-reference/#tag/Orders/paths/~1orders~1%7Bid%7D/delete)
