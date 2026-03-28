<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\CommandData create(\ThingsTelemetry\Traccar\Dto\CommandData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\CommandData update(\ThingsTelemetry\Traccar\Dto\CommandData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 * @method static \Illuminate\Support\Collection getSendableForDevice(int $deviceId)
 * @method static \ThingsTelemetry\Traccar\Dto\CommandDispatchResultData send(\ThingsTelemetry\Traccar\Dto\CommandData $data, ?int $groupId = null)
 * @method static \Illuminate\Support\Collection types(?int $deviceId = null, ?bool $textChannel = null)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Command
 */
class Command extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Command::class;
    }
}
