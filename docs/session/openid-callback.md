# OpenID Connect Callback

Handle the callback from the OpenID Connect identity provider.

## Overview

The `Session::handleOpenIdCallback()` method processes the callback from the OpenID Connect identity provider after the user has authenticated. This endpoint completes the OIDC flow and returns the final redirect URL.

## Usage

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function handleOpenIdCallback(Request $request)
    {
        // Get the full query string from the callback URL
        $queryString = $request->getQueryString();
        
        // Pass it to the Traccar API
        $redirectUrl = Session::handleOpenIdCallback($queryString);
        
        // Redirect to the final URL
        return redirect($redirectUrl);
    }
}
```

## Result

The method returns a string containing the final redirect URL:

```php
$redirectUrl = Session::handleOpenIdCallback($queryString);
// e.g., "/?token=abc123..." or "/dashboard"
```

## Complete Flow Example

Here's a complete example of handling OpenID Connect authentication in a Laravel application:

### Routes

```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/auth/openid/redirect', [AuthController::class, 'redirectToProvider'])
    ->name('openid.redirect');

Route::get('/auth/openid/callback', [AuthController::class, 'handleProviderCallback'])
    ->name('openid.callback');
```

### Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

class AuthController extends Controller
{
    /**
     * Redirect the user to the OpenID provider.
     */
    public function redirectToProvider()
    {
        try {
            $authUrl = Session::getOpenIdAuthUrl();
            return redirect($authUrl);
        } catch (RequestException $e) {
            return redirect()->route('login')
                ->with('error', 'OpenID authentication is not available');
        }
    }

    /**
     * Handle the callback from the OpenID provider.
     */
    public function handleProviderCallback(Request $request)
    {
        // Ensure we have callback parameters
        if (!$request->has('code') && !$request->has('state')) {
            return redirect()->route('login')
                ->with('error', 'Invalid callback');
        }

        try {
            // Pass the query string to Traccar
            $queryString = $request->getQueryString();
            $redirectUrl = Session::handleOpenIdCallback($queryString);
            
            // The redirectUrl typically contains the session token
            // Parse it to extract the token for your app
            $parsedUrl = parse_url($redirectUrl);
            parse_str($parsedUrl['query'] ?? '', $params);
            
            if (isset($params['token'])) {
                // Store the token in session or database
                session(['traccar_token' => $params['token']]);
            }
            
            // Redirect to your app's home page
            return redirect()->intended('/dashboard');
            
        } catch (RequestException $e) {
            $status = $e->getResponse()->status();
            
            if ($status === 400) {
                return redirect()->route('login')
                    ->with('error', 'Invalid authorization code');
            }
            
            return redirect()->route('login')
                ->with('error', 'Authentication failed');
        }
    }
}
```

## Important Notes

- The query string should include `code` and `state` parameters from the identity provider
- The callback must be handled quickly - authorization codes typically expire within minutes
- The returned redirect URL often contains the session token in the query string
- Store the token securely if you need to make subsequent API calls

## Important Links
- [Traccar API: OpenID Callback](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1openid~1callback/get)
- [OpenID Auth Documentation](./openid-auth)
