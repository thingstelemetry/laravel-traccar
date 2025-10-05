<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar;

use Illuminate\Support\ServiceProvider;

class TraccarServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/traccar.php', 'traccar');

        $this->publishes([
            __DIR__ . '/../config/traccar.php' => config_path('traccar.php'),
        ], 'config');
    }
}
