<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData link(\ThingsTelemetry\Traccar\Dto\PermissionData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData unlink(\ThingsTelemetry\Traccar\Dto\PermissionData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData linkBulk(array<\ThingsTelemetry\Traccar\Dto\PermissionData> $permissions)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData unlinkBulk(array<\ThingsTelemetry\Traccar\Dto\PermissionData> $permissions)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Permission
 */
class Permission extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Permission::class;
    }
}
