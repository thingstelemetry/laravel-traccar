<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Calendar;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\CalendarData;

class CreateCalendar extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
