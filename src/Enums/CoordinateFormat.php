<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Enums;

enum CoordinateFormat: string
{
    case DD = 'dd';
    case DDM = 'ddm';
    case DMS = 'dms';

    public static function default(): self
    {
        return self::DD;
    }

    public function label(): string
    {
        return match ($this) {
            self::DD  => 'Decimal Degrees (DD)',
            self::DDM => 'Degrees Decimal Minutes (DDM)',
            self::DMS => 'Degrees Minutes Seconds (DMS)',
        };
    }
}
