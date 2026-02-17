# SessionTokenData DTO Reference

The `ThingsTelemetry\Traccar\Dto\SessionTokenData` represents a session authentication token.

## Overview

Session tokens are long-lived authentication credentials that can be used in place of passwords. They are useful for mobile applications, external integrations, or any scenario where storing user passwords is undesirable.

## Creating SessionTokenData

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Generate a new token
$tokenData = Session::generateToken();
```

## Properties

### `token` → `string`

The authentication token string. This token can be used as a password substitute when creating sessions.

```php
$tokenData = Session::generateToken();
$token = $tokenData->token;
// e.g., "abc123xyz789..."
```

> [!CAUTION]
> Treat tokens as sensitive credentials. Store them securely and never expose them in logs or error messages.

## Methods

### `fromString(string $token): self`

Factory method to create a SessionTokenData from a plain token string.

```php
use ThingsTelemetry\Traccar\Dto\SessionTokenData;

$tokenData = SessionTokenData::fromString('abc123xyz789...');
```

### `toArray(): array`

Serialize the token to an associative array.

```php
$tokenData = Session::generateToken();
$array = $tokenData->toArray();
// ['token' => 'abc123xyz789...']
```

## Usage Examples

### Generate and Store Token

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Generate token with 30-day expiration
$tokenData = Session::generateToken(now()->addDays(30));

// Store in database (encrypted)
$userToken = UserToken::create([
    'user_id' => auth()->id(),
    'token' => encrypt($tokenData->token),
    'expires_at' => now()->addDays(30),
]);

// Return only the token ID to client
return response()->json([
    'token_id' => $userToken->id,
]);
```

### Authenticate with Token

```php
use ThingsTelemetry\Traccar\Facades\Session;

// User logs in with token instead of password
$token = decrypt($storedToken);

$user = Session::create(
    email: $userEmail,
    password: $token  // Token acts as password
);
```

### Revoke Token

```php
use ThingsTelemetry\Traccar\Facades\Session;

// When user logs out or token is compromised
Session::revokeToken($tokenData->token);
```

## Security Best Practices

1. **Encrypt at Rest**: Always encrypt tokens when storing in databases
2. **Set Expiration**: Don't create infinite tokens unless absolutely necessary
3. **Secure Transmission**: Only transmit tokens over HTTPS
4. **Token Rotation**: Implement periodic token rotation for enhanced security
5. **Revoke Unused Tokens**: Clean up tokens when no longer needed
6. **Access Control**: Restrict token generation to authenticated users only

```php
// Good: Encrypt before storing
$encrypted = encrypt($tokenData->token);

// Good: Set reasonable expiration
$tokenData = Session::generateToken(now()->addDays(30));

// Good: Revoke when done
Session::revokeToken($tokenData->token);
```

## Important Links
- [Generate Token Documentation](../session/generate-token)
- [Revoke Token Documentation](../session/revoke-token)
- [Traccar API: Session Token](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1token/post)
