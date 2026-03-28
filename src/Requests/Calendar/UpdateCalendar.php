<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Calendar;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateCalendar extends UpdateRequest
{
    public function __construct(public CalendarData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'Calendar ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/calendars/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): CalendarData
    {
        return CalendarData::fromArray(data: $response->json());
    }
}
