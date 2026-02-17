# OpenID Connect Authentication

Initiate OpenID Connect authentication flow.

## Overview

The `Session::getOpenIdAuthUrl()` method initiates the OpenID Connect (OIDC) authentication flow by returning a redirect URL to the configured identity provider. This allows users to authenticate using external identity providers like Google, Okta, Azure AD, etc.

> [!NOTE]
> This endpoint requires OpenID Connect to be enabled and configured on the Traccar server.

## Usage

```php
use ThingsTelemetry\Traccar\Facades\Session;

// Get the OpenID authorization URL
$authUrl = Session::getOpenIdAuthUrl();

// Redirect the user to the identity provider
return redirect($authUrl);
```

## Complete OpenID Flow

### Step 1: Initiate Authentication

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        try {
            $authUrl = Session::getOpenIdAuthUrl();
            return redirect($authUrl);
        } catch (RequestException $e) {
            // OpenID may not be configured on the server
            return redirect()->route('login')
                ->with('error', 'OpenID authentication is not available');
        }
    }
}
```

### Step 2: Handle Callback

After the user authenticates with the identity provider, they will be redirected back to your application:

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

class AuthController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Pass the query string to handle the callback
        $queryString = $request->getQueryString() ?? ''
        
        try {
            $redirectUrl = Session::handleOpenIdCallback($queryString);
            
            // Redirect to the final URL (usually back to your app with session info)
            return redirect($redirectUrl);
        } catch (RequestException $e) {
            // Handle authentication failure
            return redirect()->route('login')
                ->with('error', 'Authentication failed');
        }
    }
}
```

## Result

The method returns a string containing the complete authorization URL:

```php
$authUrl = Session::getOpenIdAuthUrl();
// e.g., "https://accounts.google.com/o/oauth2/auth?client_id=xxx&redirect_uri=xxx&..."
```

## Availability

> [!IMPORTANT]
> This endpoint is only available if OpenID Connect is configured on the Traccar server.

### Checking Availability

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

try {
    $authUrl = Session::getOpenIdAuthUrl();
    $openIdAvailable = true;
} catch (RequestException $e) {
    $openIdAvailable = false;
    // OpenID is not configured
}
```

## Error Handling

### Configuration Not Available

If OpenID Connect is not enabled on the server, the request may fail:

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

try {
    $authUrl = Session::getOpenIdAuthUrl();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    if ($status === 404) {
        // OpenID endpoint not found - not configured
    } elseif ($status === 503) {
        // OpenID service unavailable
    }
}
```

## Important Notes

- The Traccar server must be configured with OpenID Connect settings
- The identity provider must be properly configured to redirect back to Traccar
- This is a server-side flow - the Traccar server handles the OAuth2/OIDC exchange
- The user is redirected multiple times: Your App → Identity Provider → Traccar → Your App

## Important Links
- [Traccar API: OpenID Auth](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1openid~1auth/get)
- [OpenID Callback Documentation](./openid-callback)
- [Traccar OpenID Configuration](https://www.traccar.org/openid/)
