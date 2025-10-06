<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Enums;

enum AltitudeUnit: string
{
    case METERS = 'm';
    case FEET = 'ft';

    public static function default(): self
    {
        return self::METERS;
    }

    public function label(): string
    {
        return match ($this) {
            self::METERS => 'Meters',
            self::FEET   => 'Feet',
        };
    }
}
