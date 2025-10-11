<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Support;

class Mount
{
    public int $free;

    public int $total;

    public function __construct(int $free, int $total)
    {
        $this->free = $free;
        $this->total = $total;
    }

    public function freeFormatted(): string
    {
        return $this->formatBytes(bytes: $this->free);
    }

    public function totalFormatted(): string
    {
        return $this->formatBytes(bytes: $this->total);
    }

    public function usedFormatted(): string
    {
        return $this->formatBytes(bytes: $this->total - $this->free);
    }

    public function freePercent(): float
    {
        return round(num: ($this->free / $this->total) * 100, precision: 2);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes.' B';
        }

        $power = (int) floor(num: log(num: $bytes, base: 1024));

        return match ($power) {
            0       => $bytes.' B',
            1       => round(num: $bytes / 1024, precision: 2).' KB',
            2       => round(num: $bytes / 1024 ** 2, precision: 2).' MB',
            3       => round(num: $bytes / 1024 ** 3, precision: 2).' GB',
            4       => round(num: $bytes / 1024 ** 4, precision: 2).' TB',
            5       => round(num: $bytes / 1024 ** 5, precision: 2).' PB',
            default => round(num: $bytes / 1024 ** $power, precision: 2).' B',
        };
    }
}
