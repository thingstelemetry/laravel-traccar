# Upload File

Upload a file into Traccar's web root via `/server/file/{path}`.

> [!IMPORTANT]
> This endpoint is restricted to admin users only on the Traccar server.
> You can upload files of any MIME type (i.e., `*/*`).

## Request

You can upload from a Laravel `UploadedFile`, a Symfony `File`, or a filesystem path string.

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Illuminate\Http\UploadedFile;

// Example using UploadedFile (e.g., from an incoming request)
// $uploaded = request()->file('asset');
// $result = Server::uploadFile(path: 'web/assets/readme.txt', file: $uploaded);

// Example using a local file path
$result = Server::uploadFile(path: 'web/assets/readme.txt', file: base_path('readme.txt'));
```

## Results

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$status = $result->status->value; // "success"
```

## Important Links
- [Traccar API: File Upload](https://www.traccar.org/api-reference/#tag/Server/paths/~1server/file/post)