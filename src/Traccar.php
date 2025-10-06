<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar;

use Illuminate\Support\Facades\App;

abstract class Traccar
{
    protected TraccarConnector $connector;

    public function __construct()
    {
        $this->connector = App::make(abstract: TraccarConnector::class);
    }
}
