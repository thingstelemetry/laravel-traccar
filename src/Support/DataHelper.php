<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Support;

class DataHelper
{
    public static function nullableInt(array $data, string $key): ?int
    {
        if (! array_key_exists($key, $data) || $data[$key] === null) {
            return null;
        }

        return (int) $data[$key];
    }

    public static function arrayField(array $data, string $key): array
    {
        return is_array($data[$key] ?? null) ? $data[$key] : [];
    }
}
