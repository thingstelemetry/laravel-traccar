# Get OIDC Token

Exchange an authorization code for an OIDC token.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Oidc::getToken()` method.

```php
use ThingsTelemetry\Traccar\Facades\Oidc;

$token = Oidc::getToken(
    grantType: 'authorization_code',
    code: 'your-auth-code',
    redirectUri: 'https://your-app.com/callback'
);
// ThingsTelemetry\Traccar\Dto\OidcTokenData
```

## Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `grantType` | `string` | The grant type (e.g., `authorization_code`). |
| `code` | `string` | The authorization code received from the authorization endpoint. |
| `redirectUri` | `string?` | The redirect URI. |
| `clientId` | `string?` | The client identifier. |
| `clientSecret` | `string?` | The client secret. |
| `codeVerifier` | `string?` | PKCE code verifier. |

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\OidcTokenData`.

```php
$accessToken = $token->accessToken;
$tokenType   = $token->tokenType; // "Bearer"
$expiresIn   = $token->expiresIn; // e.g., 3600
$idToken     = $token->idToken;
$scope       = $token->scope;
```

## Important Links
- [Traccar: Get Token](https://www.traccar.org/api-reference/#tag/OIDC/paths/~1oidc~1token/post)
