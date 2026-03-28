# Reset Password

The `Password` facade provides a method to initiate a password reset for a user.

## Resetting Password

To initiate a password reset, you need to provide the user's email address. Traccar will send a password reset email to the user if the email exists in the system.

```php
use ThingsTelemetry\Traccar\Facades\Password;

$response = Password::reset(email: 'user@example.com');

if ($response->successful()) {
    // Password reset initiated successfully
}
```

::: info
This endpoint does not require authentication.
:::
