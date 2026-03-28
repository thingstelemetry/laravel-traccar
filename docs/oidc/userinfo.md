# Get OIDC User Info

Retrieve information about the authenticated user.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Oidc::getUserInfo()` method.

```php
use ThingsTelemetry\Traccar\Facades\Oidc;

$userInfo = Oidc::getUserInfo(); // ThingsTelemetry\Traccar\Dto\OidcUserInfoData
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\OidcUserInfoData`.

```php
$sub   = $userInfo->sub;   // User identifier
$name  = $userInfo->name;  // User's name
$email = $userInfo->email; // User's email
```

## Important Links
- [Traccar: User Info](https://www.traccar.org/api-reference/#tag/OIDC/paths/~1oidc~1userinfo/get)
