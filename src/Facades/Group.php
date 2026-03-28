<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Dto\StatusData;

/**
 * @method static Collection getAll(?bool $all = null, ?int $userId = null, ?bool $excludeAttributes = null)
 * @method static GroupData get(int $id)
 * @method static GroupData create(GroupData $data)
 * @method static GroupData update(GroupData $data)
 * @method static StatusData delete(int $id)
 */
class Group extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Group::class;
    }
}
