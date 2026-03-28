# Check Health

Check whether the Traccar server is healthy.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Health;

$status = Health::check();
```

## Result

Returns a plain-text status string such as `OK`.

## Important Links
- [Traccar Health](https://www.traccar.org/api-reference/#tag/Health/paths/~1health/get)
