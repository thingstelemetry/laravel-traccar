<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Calendar;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateCalendar extends CreateRequest
{
    public function __construct(public CalendarData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/calendars';
    }

    public function createDtoFromResponse(Response $response): CalendarData
    {
        return CalendarData::fromArray(data: $response->json());
    }
}
