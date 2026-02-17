# Share Device Location

Generate a temporary url token that allows sharing a specific device. Other can open the url and see the device location as long as the token is has not expired.

> [!IMPORTANT]
> The server will not allow  sharing when `ServerAttributesData` -> [`disableShare`](./../reference/dto/server-attributes-data#disableshare-→-boolean) is enabled.

## Usage

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Device;

$expiration = CarbonImmutable::now()->addHours(12);

$share = Device::share(deviceId: 6, expiration: $expiration); // ThingsTelemetry\Traccar\Dto\DeviceShareData
```

- expiration is a Carbon instance and will be converted to ISO-8601 automatically.
- The token is a plain string suitable for subsequent authenticated calls if supported by your setup.

## Results

The response is a `ThingsTelemetry\Traccar\Dto\DeviceShareData` instance.

```php
$token = $share->token; // 'eyJhbGciOi...'
$url = $share->url; // e.g., 'https://demo.traccar.org/?token=eyJhbGciOi...'
$expiration = $share->expiration; // CarbonImmutable instance
$expiresAt = $expiration->toIso8601String(); // ISO-8601
```

## Error Handling

- **403 Forbidden**: "Sharing is disabled" - Server has disabled device sharing
- **403 Forbidden**: "Temporary user" - Cannot share as a temporary user

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;

try {
    $share = Device::share(deviceId: 6, expiration: $expiration);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - sharing disabled or temporary user,
        404 => // Device not found - check device ID,
        default => // Handle other errors
    };
}
```