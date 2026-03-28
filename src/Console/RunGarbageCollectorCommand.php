<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Console;

use Throwable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use ThingsTelemetry\Traccar\Facades\Server;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Attributes\Description;

#[Signature(signature: 'traccar:run-gc')]
#[Description(description: 'Trigger the JVM garbage collector on the Traccar server.')]
class RunGarbageCollectorCommand extends Command
{
    public function handle(): int
    {
        $this->info(string: 'Running Traccar garbage collector...');

        try {
            $response = Server::runGarbageCollector();

            $message = "Traccar garbage collector completed with status: {$response->status->value}";

            $this->info(string: $message);

            Log::info(message: $message);

            return self::SUCCESS;
        } catch (Throwable $e) {
            $errorMessage = "Traccar garbage collector failed: {$e->getMessage()}";

            $this->error(string: $errorMessage);

            Log::error(message: $errorMessage, context: $e->getTrace());

            return self::FAILURE;
        }
    }
}
