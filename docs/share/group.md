# Share group devices

Generate a temporary URL token that allows sharing all devices within a specific group. Others can open the URL and see the group devices' location as long as the token has not expired.

> [!IMPORTANT]
> The server will not allow sharing when `ServerAttributesData` -> [`disableShare`](./../reference/dto/server-attributes-data#disableshare-→-boolean) is enabled.

## Usage

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Share;

$expiration = CarbonImmutable::now()->addHours(12);

$share = Share::group(groupId: 2, expiration: $expiration); // ThingsTelemetry\Traccar\Dto\GroupShareData
```

- `expiration` is a Carbon instance and will be converted to ISO-8601 automatically.
- The token is a plain string suitable for subsequent authenticated calls if supported by your setup.

## Results

The response is a `ThingsTelemetry\Traccar\Dto\GroupShareData` instance.

```php
$token = $share->token; // 'eyJhbGciOi...'
$url = $share->url; // e.g., 'https://demo.traccar.org/?token=eyJhbGciOi...'
$groupId = $share->groupId; // 2
$expiration = $share->expiration; // CarbonImmutable instance
$expiresAt = $expiration->toIso8601String(); // ISO-8601
```

## Important Links
- [Traccar API: Group Sharing](https://www.traccar.org/api-reference/#tag/Devices/paths/~1devices~1group/post)
- [GroupShareData DTO reference](./../reference/dto/group-share-data)