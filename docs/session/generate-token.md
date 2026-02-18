# Generate Session Token

Create a long-lived authentication token.

## Overview

The `Session::generateToken()` method creates a token that can be used as a password substitute for authentication. These tokens are ideal for mobile applications or external integrations that need persistent access without storing user passwords.

## Usage

### Basic Usage

Generate a token without expiration:

```php
use ThingsTelemetry\Traccar\Facades\Session;

$tokenData = Session::generateToken();
$token = $tokenData->token; // Store this securely
```

### With Custom Expiration

Generate a token that expires after a specific date/time:

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Carbon\Carbon;

// Token expires in 30 days
$expiration = Carbon::now()->addDays(30);
$tokenData = Session::generateToken($expiration);
$token = $tokenData->token;
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\SessionTokenData`.

```php
$tokenData->token; // "abc123xyz789..." (the token string)
$tokenData->toArray(); // ['token' => 'abc123xyz789...']
```

### Using the Token

Use the generated token as a password in subsequent API calls:

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Store the token securely (e.g., encrypted in database)
$tokenData = Session::generateToken();
$token = $tokenData->token;

// Later, use token for authentication
$user = Session::create(
    email: 'user@example.com',
    password: $token  // Use token as password
);
```

## Security Notes

> [!CAUTION]
> Session tokens are powerful credentials. Treat them with the same security as passwords.

- Store tokens securely (encrypted at rest)
- Never expose tokens in logs or error messages
- Set appropriate expiration dates (don't create infinite tokens unless necessary)
- Revoke tokens when no longer needed
- Implement token rotation for enhanced security
- Use HTTPS for all API communications

## Important Notes

- Tokens can be used in place of passwords for authentication
- Tokens do not expire unless an expiration date is set
- Each token is unique and tied to the user who generated it
- Revoking a token permanently invalidates it
- There's no API endpoint to list all active tokens

## Important Links
- [Traccar API: Generate Session Token](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1token/post)
- [SessionTokenData DTO Reference](../reference/dto/session-token-data)
- [Revoke Token Documentation](./revoke-token)
