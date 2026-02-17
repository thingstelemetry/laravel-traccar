# Create Session (Login)

Authenticate a user and create a new session.

## Overview

The `Session::create()` method authenticates a user with their email and password, creating a new session. This is the primary login endpoint for user authentication.

> [!NOTE]
> This endpoint does not require prior authentication - it's used to establish authentication.

## Usage

### Basic Login

Authenticate with email and password:

```php
use ThingsTelemetry\Traccar\Facades\Session;

$user = Session::create(
    email: 'user@example.com',
    password: 'secret123'
);
```

### Two-Factor Authentication (TOTP)

If the user has TOTP-based two-factor authentication enabled, the initial login will fail with a 401 status and a `WWW-Authenticate: TOTP` header. Call the method again with the TOTP code:

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

// Attempt initial login
$totpRequired = false;
$totpCode = null;

try {
    $user = Session::create(
        email: 'user@example.com',
        password: 'secret123'
    );
} catch (RequestException $e) {
    $response = $e->getResponse();
    
    // Check if TOTP is required
    if ($response->status() === 401) {
        $authHeader = $response->header('WWW-Authenticate');
        if (str_contains($authHeader, 'TOTP')) {
            $totpRequired = true;
        }
    }
}

if ($totpRequired) {
    // Get TOTP code from user (e.g., via form input)
    $totpCode = (int) request('totp_code');
    
    // Retry with TOTP code
    $user = Session::create(
        email: 'user@example.com',
        password: 'secret123',
        code: $totpCode
    );
}
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\UserData`.

```php
$user->id; // 42
$user->name; // "Jane Doe"
$user->email; // "user@example.com"
$user->administrator; // true|false
$user->map->value; // "osm"
$user->coordinateFormat; // enum CoordinateFormat
$user->attributes->toArray(); // array<string, mixed>
```

## Error Handling

### 401 Unauthorized

Returned when authentication fails or when TOTP is required.

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

try {
    $user = Session::create(
        email: 'user@example.com',
        password: 'wrong-password'
    );
} catch (RequestException $e) {
    if ($e->getResponse()->status() === 401) {
        $authHeader = $e->getResponse()->header('WWW-Authenticate');
        
        if (str_contains($authHeader, 'TOTP')) {
            // TOTP required
        } else {
            // Invalid credentials
        }
    }
}
```

## Security Notes

- Never log or store user passwords
- Consider using session tokens for mobile applications instead of storing passwords
- Always validate email format before sending to API
- Implement rate limiting to prevent brute force attacks
- Use HTTPS in production to protect credentials in transit

## Important Links
- [Traccar API: Create Session](https://www.traccar.org/api-reference/#tag/Session/paths/~1session/post)
- [UserData DTO Reference](../reference/dto/user-data)
