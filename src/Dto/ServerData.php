<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

class ServerData
{
    public function __construct(
        public int $id,
        public bool $registration,
        public bool $readonly,
        public bool $deviceReadonly,
        public bool $limitCommands,
        public string $map,
        public string $bingKey,
        public string $mapUrl,
        public string $poiLayer,
        public float $latitude,
        public float $longitude,
        public int $zoom,
        public string $version,
        public bool $forceSettings,
        public string $coordinateFormat,
        public bool $openIdEnabled,
        public bool $openIdForce,
        public array $attributes = [],
    ) {
    }
}
