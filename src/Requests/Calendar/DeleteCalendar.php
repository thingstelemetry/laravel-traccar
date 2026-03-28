<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Calendar;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteCalendar extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/calendars/{$this->id}";
    }
}
