<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Enums;

enum DistanceUnit: string
{
    case KILOMETERS = 'km';
    case MILES = 'mi';
    case NAUTICAL_MILES = 'nmi';

    public static function default(): self
    {
        return self::KILOMETERS;
    }

    public function label(): string
    {
        return match($this) {
            self::KILOMETERS     => 'Kilometers (km)',
            self::MILES          => 'Miles (mi)',
            self::NAUTICAL_MILES => 'Nautical miles (nmi)',
        };
    }
}
