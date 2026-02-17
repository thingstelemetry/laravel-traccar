# Error Handling

This package uses Saloon's exception system. Wrap API calls in `try/catch` blocks to handle errors gracefully.

## Basic Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;

try {
    $device = Device::find(id: 999);
} catch (RequestException $e) {
    // Handle API error
    $statusCode = $e->response->status();  // 404
    $body = $e->response->json();          // Error details
    
    logger()->error('Device not found', [
        'status' => $statusCode,
        'body' => $body,
    ]);
}
```

## Exception Types

| Exception | Description |
|-----------|-------------|
| `Saloon\Exceptions\Request\RequestException` | API returned an error response (4xx, 5xx) |
| `Saloon\Exceptions\Request\FatalRequestException` | Network/Connection failure |
| `Saloon\Exceptions\SaloonException` | Base exception for all Saloon errors |

## Handling Specific HTTP Status Codes

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;

try {
    $device = Device::find(id: 1);
} catch (RequestException $e) {
    match ($e->response->status()) {
        401 => logger()->warning('Unauthorized - check API key'),
        403 => logger()->warning('Forbidden - insufficient permissions'),
        404 => logger()->info('Resource not found'),
        429 => logger()->warning('Rate limited'),
        500, 502, 503 => logger()->error('Server error'),
        default => logger()->error('API error: ' . $e->getMessage()),
    };
}
```

## Connection Errors

Handle network failures with `FatalRequestException`:

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

try {
    $info = Server::getInformation();
} catch (FatalRequestException $e) {
    // Network connectivity issues
    logger()->error('Connection failed: ' . $e->getMessage());
} catch (RequestException $e) {
    // API returned error response
    logger()->error('API error: ' . $e->getMessage());
}
```

## Validation Errors

Some methods perform local validation before sending requests:

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Illuminate\Validation\ValidationException;

try {
    Device::updateImage(deviceId: 1, file: $invalidFile);
} catch (ValidationException $e) {
    $errors = $e->errors(); // ['file' => ['The file must be an image.']]
}
```

## Best Practices

1. **Always catch `RequestException`** when making API calls that may fail
2. **Log error details** including status code and response body for debugging
3. **Use specific exception types** when you need different handling for different error scenarios
4. **Graceful degradation** - provide fallback behavior when API calls fail
