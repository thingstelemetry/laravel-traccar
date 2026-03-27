<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll(?bool $all = null, ?int $userId = null, ?bool $excludeAttributes = null)
 * @method static \ThingsTelemetry\Traccar\Dto\GroupData get(int $id)
 * @method static \ThingsTelemetry\Traccar\Dto\GroupData create(\ThingsTelemetry\Traccar\Dto\GroupData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\GroupData update(\ThingsTelemetry\Traccar\Dto\GroupData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Group
 */
class Group extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Group::class;
    }
}
