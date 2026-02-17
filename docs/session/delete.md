# Delete Session (Logout)

Terminate the current authenticated session.

## Overview

The `Session::delete()` method logs out the currently authenticated user by terminating their session.

## Usage

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Log out the current user
$result = Session::delete();
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$result->status; // Status::SUCCESS
$result->status->value; // "success"
```

## Error Handling

This endpoint typically does not return errors for valid requests. However, if the session has already expired or been invalidated:

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Session::delete();
} catch (RequestException $e) {
    // Handle error (e.g., session already expired)
}
```

## Important Notes

- This method effectively logs the user out
- Any subsequent API calls will require re-authentication
- Session tokens are not affected by this endpoint
- To revoke a token, use `Session::revokeToken()` instead

## Important Links
- [Traccar API: Delete Session](https://www.traccar.org/api-reference/#tag/Session/paths/~1session/delete)
- [Status Enum Reference](../reference/enums/status)
