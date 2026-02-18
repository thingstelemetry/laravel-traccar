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

## Important Notes

- This method effectively logs the user out
- Any subsequent API calls will require re-authentication
- Session tokens are not affected by this endpoint
- To revoke a token, use `Session::revokeToken()` instead

## Important Links
- [Traccar API: Delete Session](https://www.traccar.org/api-reference/#tag/Session/paths/~1session/delete)
- [Status Enum Reference](../reference/enums/status)
