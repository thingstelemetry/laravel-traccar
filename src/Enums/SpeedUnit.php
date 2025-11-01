<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Enums;

enum SpeedUnit: string
{
    case KNOTS = 'kn';
    case KILOMETERS_PER_HOUR = 'kmh';
    case MILES_PER_HOUR = 'mph';

    public static function default(): self
    {
        return self::KNOTS;
    }

    public function label(): string
    {
        return match ($this) {
            self::KNOTS               => 'Knots (kn)',
            self::KILOMETERS_PER_HOUR => 'Kilometers per Hour (km/h)',
            self::MILES_PER_HOUR      => 'Miles per Hour (mph)',
        };
    }
}
