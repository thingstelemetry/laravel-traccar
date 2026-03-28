<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Support;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

trait ParsesTimestamps
{
    protected static function parseTimestamp(mixed $raw, string $field): ?CarbonImmutable
    {
        if (is_string($raw) && $raw !== '') {
            try {
                return CarbonImmutable::parse($raw);
            } catch (Throwable $e) {
                Log::warning('Failed to parse '.static::class." {$field}: ".$e->getMessage());
            }
        }

        return null;
    }
}
