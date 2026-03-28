# Authorize OIDC

Redirect the user to the OIDC authorization endpoint.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Oidc::authorize()` method.

```php
use ThingsTelemetry\Traccar\Facades\Oidc;

$location = Oidc::authorize(
    clientId: 'client-id',
    redirectUri: 'https://your-app.com/callback',
    state: 'state-123',
    scope: 'openid profile email'
);

// Redirect the user to $location
```

## Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `clientId` | `string` | The client identifier. |
| `redirectUri` | `string` | The redirect URI. |
| `state` | `string?` | An opaque value used by the client to maintain state between the request and callback. |
| `scope` | `string?` | A space-separated list of scopes. |
| `responseType` | `string?` | The response type (e.g., `code`). |
| `codeChallenge` | `string?` | PKCE code challenge. |
| `codeChallengeMethod` | `string?` | PKCE code challenge method (e.g., `S256`). |
| `nonce` | `string?` | String value used to associate a Client session with an ID Token. |

## Result

Returns a `string` containing the redirect URL.

## Important Links
- [Traccar: Authorize](https://www.traccar.org/api-reference/#tag/OIDC/paths/~1oidc~1authorize/get)
