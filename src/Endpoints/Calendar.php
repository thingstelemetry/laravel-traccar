<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Requests\Calendar\CreateCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\DeleteCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\UpdateCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\GetAllCalendars;

class Calendar extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(?bool $all = null, ?int $userId = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllCalendars(
                all: $all,
                userId: $userId,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(CalendarData $data): CalendarData
    {
        return $this->connector->send(request: new CreateCalendar(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(CalendarData $data): CalendarData
    {
        return $this->connector->send(request: new UpdateCalendar(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteCalendar(id: $id))->dtoOrFail();
    }
}
