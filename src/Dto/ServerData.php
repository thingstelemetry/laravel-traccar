<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use TrackTelemetry\Traccar\Enums\Map;
use TrackTelemetry\Traccar\Enums\CoordinateFormat;

readonly class ServerData
{
    public function __construct(
        public int $id,
        public ServerAttributes $attributes,
        public bool $registration,
        public bool $readonly,
        public bool $deviceReadonly,
        public Map $map,
        public ?string $bingKey,
        public ?string $mapUrl,
        public ?string $overlayUrl,
        public float $latitude,
        public float $longitude,
        public int $zoom,
        public bool $forceSettings,
        public CoordinateFormat $coordinateFormat,
        public bool $limitCommands,
        public bool $disableReports,
        public bool $fixedEmail,
        public ?string $poiLayer,
        public ?string $announcement,
        public bool $emailEnabled,
        public bool $geocoderEnabled,
        public bool $textEnabled,
        public array $storageSpace,
        public bool $newServer,
        public bool $openIdEnabled,
        public bool $openIdForce,
        public string $version,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            attributes: ServerAttributes::fromArray($data['attributes']),
            registration: $data['registration'],
            readonly: $data['readonly'],
            deviceReadonly: $data['deviceReadonly'],
            map: Map::tryFrom($data['map'] ?? '') ?? Map::default(),
            bingKey: $data['bingKey'] ?? null,
            mapUrl: $data['mapUrl'] ?? null,
            overlayUrl: $data['overlayUrl'] ?? null,
            latitude: $data['latitude'],
            longitude: $data['longitude'],
            zoom: $data['zoom'],
            forceSettings: $data['forceSettings'],
            coordinateFormat:  CoordinateFormat::tryFrom($data['coordinateFormat'] ?? '') ?? CoordinateFormat::default(),
            limitCommands: $data['limitCommands'],
            disableReports: $data['disableReports'],
            fixedEmail: $data['fixedEmail'],
            poiLayer: $data['poiLayer'] ?? null,
            announcement: $data['announcement'] ?? null,
            emailEnabled: $data['emailEnabled'],
            geocoderEnabled: $data['geocoderEnabled'],
            textEnabled: $data['textEnabled'],
            storageSpace: $data['storageSpace'] ?? [],
            newServer: $data['newServer'],
            openIdEnabled: $data['openIdEnabled'],
            openIdForce: $data['openIdForce'],
            version: $data['version'],
        );
    }
}
