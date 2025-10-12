<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use TrackTelemetry\Traccar\Enums\Status;

class StatusData
{
    public function __construct(public Status $status)
    {
    }
}
