# Run Garbage Collector Command

Trigger the JVM garbage collector on the Traccar server using a Laravel console command.

This command is a wrapper around the `ThingsTelemetry\Traccar\Facades\Server::runGarbageCollector()` method.

## Usage

You can run the command from your terminal:

```bash
php artisan traccar:run-gc
```

## Logging

The command logs its results to your Laravel log file.

- **Success:** Logs an `info` message with the status returned by Traccar.
- **Failure:** Logs an `error` message with the exception details.

## Scheduling

To automate the garbage collection process, you can schedule the command in your application's `bootstrap/app.php`.

```php

use ThingsTelemetry\Traccar\Console\RunGarbageCollectorCommand;
use Illuminate\Support\Facades\Schedule;

return Application::configure(basePath: dirname(path: __DIR__))
    // ... other configurations (withMiddleware(), withExceptions)
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command(command: RunGarbageCollectorCommand::class)->daily();
    });
```

> [!IMPORTANT]
> The garbage collector endpoint is restricted to admin users only on the Traccar server. Ensure your `TRACCAR_API_KEY` belongs to an administrator.
