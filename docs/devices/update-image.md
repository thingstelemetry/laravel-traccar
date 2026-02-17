# Upload/Update Device Image

Upload or update a device image on your Traccar server.

> [!DANGER]
> - This endpoint is uploading device images to your Traccar server but the image is not displayed on the Traccar UI web interface.
> - We are investigating this issue.

> [!IMPORTANT]
> - Only the following image types are supported: `image/jpeg`, `image/png`, `image/gif`, `image/webp`, `image/svg+xml`.
> - Maximum image size is 500000 bytes (about 488 KB). Larger images will be rejected before the request is sent.

## Usage (application)

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Illuminate\Http\UploadedFile;

// From a controller/form request, you typically receive an Illuminate\Http\UploadedFile
$uploaded = request()->file('image'); // instance of UploadedFile

// returns string like "device.png"
$filename = Device::updateImage(deviceId: 6, file: $uploaded); 
```

You may also pass a string path:

```php
$filename = Device::updateImage(
    deviceId: 6, 
    file: base_path('tests/fixtures/device.png')
);
```

## Results

The response is a string representing the stored filename (e.g., `device.png`).

```php
$filename; // 'device.png'
```

## Validation

Before sending the request, Laravel validation ensures:
- `device_id`: required, integer, min:1
- `file`: required, image type must be one of jpeg/png/gif/webp/svg+xml
- `file size`: must not exceed 500000 bytes

If validation fails, an `Illuminate\Validation\ValidationException` is thrown. Make sure to catch it.

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;
use Illuminate\Validation\ValidationException;

try {
    $filename = Device::updateImage(deviceId: 6, file: $uploaded);
} catch (ValidationException $e) {
    // Handle validation errors (invalid file type, size, etc.)
    $errors = $e->errors();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // Device not found - check device ID,
        413 => // Payload too large - image exceeds server limits,
        default => // Handle other errors
    };
}
```