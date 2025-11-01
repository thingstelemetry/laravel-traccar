<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use ThingsTelemetry\Traccar\Enums\Status;

class StatusData
{
    public function __construct(public Status $status)
    {
    }
}
