# OIDC Token Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\OidcTokenData` represents the response from the OIDC token endpoint.

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `accessToken` | `string` | The access token. |
| `tokenType` | `string` | The token type (e.g., `Bearer`). |
| `expiresIn` | `int` | The expiration time in seconds. |
| `idToken` | `string?` | The ID token. |
| `scope` | `string?` | The scope of the access token. |

## `accessToken` → `string`
The access token string.

```php
$token->accessToken; // "access-token"
```

## `tokenType` → `string`
The type of the token, usually "Bearer".

```php
$token->tokenType; // "Bearer"
```

## `expiresIn` → `integer`
The duration in seconds for which the access token is valid.

```php
$token->expiresIn; // 3600
```

## `idToken` → `string|null`
The ID token string, if available.

```php
$token->idToken; // "id-token"
```

## `scope` → `string|null`
The scope of the access token.

```php
$token->scope; // "openid profile"
```
