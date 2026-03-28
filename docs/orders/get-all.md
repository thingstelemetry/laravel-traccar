# Get All Orders

Fetch orders from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Order;

$orders = Order::getAll(all: true, excludeAttributes: true);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\OrderData>`.

## Important Links
- [Traccar Orders](https://www.traccar.org/api-reference/#tag/Orders/paths/~1orders/get)
