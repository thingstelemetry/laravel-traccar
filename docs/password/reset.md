# Reset Password

The `Password` facade provides a method to initiate a password reset for a user.

## Resetting Password

To initiate a password reset, you need to provide the user's email address. Traccar will send a password reset email to the user if the email exists in the system.

```php
use ThingsTelemetry\Traccar\Facades\Password;

$result = Password::reset(email: 'user@example.com');

if ($result->status->value === 'success') {
    // Password reset initiated successfully
}
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$result->status->value; // "success"
```

::: info
This endpoint does not require authentication.
:::
