<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class TraccarServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: TraccarConnector::class,
            concrete: function (): TraccarConnector {
                return new TraccarConnector(
                    baseUrl: Config::string(key: 'traccar.base_url'),
                    apiKey: Config::string(key: 'traccar.api_key')
                );
            }
        );
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(path: __DIR__ . '/../config/traccar.php', key: 'traccar');

        $this->publishes(paths: [
            __DIR__ . '/../config/traccar.php' => config_path('traccar.php'),
        ], groups: 'config');
    }
}
