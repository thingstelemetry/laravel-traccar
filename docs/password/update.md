# Update Password

The `Password` facade provides a method to update a user's password using a reset token.

## Updating Password

After receiving a reset token (usually from the password reset email), you can use it to update the user's password.

```php
use ThingsTelemetry\Traccar\Facades\Password;

$result = Password::update(
    token: 'password-reset-token',
    password: 'new-secure-password'
);

if ($result->status->value === 'success') {
    // Password updated successfully
}
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$result->status->value; // "success"
```

::: warning
If the token is invalid or expired, the request will fail with a `404 Not Found` response.
:::

::: info
This endpoint does not require authentication.
:::
