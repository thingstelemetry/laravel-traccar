<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Enums;

enum VolumeUnit: string
{
    case LITERS = 'ltr';
    case US_GALLON = 'usGal';
    case IMPERIAL_GALLON = 'impGal';

    public static function default(): self
    {
        return self::LITERS;
    }

    public function label(): string
    {
        return match ($this) {
            self::LITERS          => 'Liters',
            self::US_GALLON       => 'US Gallon',
            self::IMPERIAL_GALLON => 'Imperial Gallon',
        };
    }
}
