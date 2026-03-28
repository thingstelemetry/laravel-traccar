# Get OIDC JWKS

Retrieve the JSON Web Key Set (JWKS) for OIDC.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Oidc::getJwks()` method.

```php
use ThingsTelemetry\Traccar\Facades\Oidc;

$jwks = Oidc::getJwks(); // array
```

## Result

Returns an `array` containing the JWKS.

```php
$keys = $jwks['keys'];
```

## Important Links
- [Traccar: JWKS](https://www.traccar.org/api-reference/#tag/OIDC/paths/~1oidc~1jwks/get)
