<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Enums;

enum DeviceStatus: string
{
    case ONLINE = 'online';
    case UNKNOWN = 'unknown';
    case OFFLINE = 'offline';

    public static function default(): self
    {
        return self::UNKNOWN;
    }

    public function label(): string
    {
        return match ($this) {
            self::ONLINE  => 'Online',
            self::UNKNOWN => 'Unknown',
            self::OFFLINE => 'Offline',
        };
    }
}
