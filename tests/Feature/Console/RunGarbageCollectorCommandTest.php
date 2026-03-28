<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Tests\Feature\Console;

use Saloon\Http\Faking\MockClient;
use Illuminate\Support\Facades\Log;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Requests\Server\RunGarbageCollector;

test(description: 'it can run the traccar garbage collector command successfully', closure: function () {
    MockClient::global([
        RunGarbageCollector::class => MockResponse::make(body: [], status: 200),
    ]);

    Log::shouldReceive('info')
        ->once()
        ->withArgs(fn ($message) => str_contains(haystack: $message, needle: 'Traccar garbage collector completed with status: success'));

    $this->artisan(command: 'traccar:run-gc')
        ->expectsOutput(output: 'Running Traccar garbage collector...')
        ->expectsOutput(output: 'Traccar garbage collector completed with status: success')
        ->assertExitCode(exitCode: 0);
});

test(description: 'it logs an error when the traccar garbage collector command fails', closure: function () {
    MockClient::global([
        RunGarbageCollector::class => MockResponse::make(body: ['message' => 'Unauthorized'], status: 401),
    ]);

    Log::shouldReceive('error')
        ->once()
        ->withArgs(fn ($message) => str_contains(haystack: $message, needle: 'Traccar garbage collector failed: Unauthorized'));

    $this->artisan(command: 'traccar:run-gc')
        ->expectsOutput(output: 'Running Traccar garbage collector...')
        ->expectsOutputToContain(string: 'Traccar garbage collector failed: Unauthorized')
        ->assertExitCode(exitCode: 1);
});
