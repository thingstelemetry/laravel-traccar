# Generate TOTP Secret

Generate a new TOTP (Time-based One-Time Password) secret for the authenticated user.

## Request

Use the `ThingsTelemetry\Traccar\Facades\User::generateTotpSecret()` method to generate a TOTP secret.

```php
use ThingsTelemetry\Traccar\Facades\User;

$secret = User::generateTotpSecret(); // string
```

## Result

The response is a plain text string containing the generated TOTP secret.

```php
echo $secret; // "K5S7N7G5K5S7N7G5"
```

## Important Links
- [Traccar: Generate TOTP secret](https://www.traccar.org/api-reference/#tag/Users/paths/~1users~1totp/post)
