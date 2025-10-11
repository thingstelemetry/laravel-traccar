<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Enums;

enum Status: string
{
    case SUCCESS = 'success';
    case FAILURE = 'failure';

    public static function default(): self
    {
        return self::FAILURE;
    }

    public function label(): string
    {
        return match ($this) {
            self::SUCCESS => 'Success',
            self::FAILURE => 'Failure',
        };
    }
}
