<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection all(?bool $all = null, ?int $userId = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\CalendarData create(\ThingsTelemetry\Traccar\Dto\CalendarData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\CalendarData update(\ThingsTelemetry\Traccar\Dto\CalendarData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Calendar
 */
class Calendar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Calendar::class;
    }
}
