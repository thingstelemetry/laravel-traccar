# Revoke Session Token

Invalidate a previously generated session token.

## Overview

The `Session::revokeToken()` method permanently invalidates a session token, preventing it from being used for future authentication.

## Usage

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Revoke a specific token
$token = 'abc123xyz789...';
$result = Session::revokeToken($token);
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$result->status; // Status::SUCCESS
$result->status->value; // "success"
```

## Common Use Cases

### User Logout from All Devices

```php
use ThingsTelemetry\Traccar\Facades\Session;

// When a user changes their password, revoke all their tokens
public function changePassword(Request $request)
{
    // ... change password logic ...
    
    // Revoke all known tokens for this user
    // (You need to track tokens in your application)
    foreach ($user->tokens as $token) {
        Session::revokeToken($token->value);
        $token->delete();
    }
}
```

### Mobile App Logout

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

// When user logs out from mobile app
public function logout()
{
    $token = request('token');
    
    try {
        Session::revokeToken($token);
        return response()->json(['message' => 'Logged out successfully']);
    } catch (RequestException $e) {
        return response()->json(['error' => 'Logout failed'], 500);
    }
}
```

## Important Notes

- Revoked tokens cannot be restored
- Revocation is immediate - the token cannot be used for any future requests
- You can only revoke tokens belonging to the authenticated user
- There's no bulk revoke endpoint - revoke tokens one at a time

## Important Links
- [Traccar API: Revoke Session Token](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1token~1revoke/post)
- [Status Enum Reference](../reference/enums/status)
- [Generate Token Documentation](./generate-token)
