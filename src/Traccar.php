<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar;

abstract class Traccar
{
    protected TraccarConnector $connector;

    public function __construct()
    {
        $this->connector = app(abstract: TraccarConnector::class);
    }
}
