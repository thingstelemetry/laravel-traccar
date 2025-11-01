<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use ThingsTelemetry\Traccar\Enums\Map;
use ThingsTelemetry\Traccar\Support\StorageInfo;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;

class ServerData
{
    public function __construct(
        public int $id,
        public ServerAttributesData $attributes,
        public bool $registration,
        public bool $readonly,
        public bool $deviceReadonly,
        public Map $map,
        public ?string $bingKey,
        public ?string $mapUrl,
        public ?string $overlayUrl,
        public float $latitude = 0,
        public float $longitude = 0,
        public int $zoom = 0,
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
        public StorageInfo $storageSpace,
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
            attributes: ServerAttributesData::fromArray(data: $data['attributes'] ?? []),
            registration: $data['registration'],
            readonly: $data['readonly'],
            deviceReadonly: $data['deviceReadonly'],
            map: Map::tryFrom(value: $data['map'] ?? '') ?? Map::default(),
            bingKey: $data['bingKey'] ?? null,
            mapUrl: $data['mapUrl'] ?? null,
            overlayUrl: $data['overlayUrl'] ?? null,
            latitude: $data['latitude'],
            longitude: $data['longitude'],
            zoom: $data['zoom'],
            forceSettings: $data['forceSettings'],
            coordinateFormat: CoordinateFormat::tryFrom(value: $data['coordinateFormat'] ?? '') ?? CoordinateFormat::default(),
            limitCommands: $data['limitCommands'],
            disableReports: $data['disableReports'],
            fixedEmail: $data['fixedEmail'],
            poiLayer: $data['poiLayer'] ?? null,
            announcement: $data['announcement'] ?? null,
            emailEnabled: $data['emailEnabled'],
            geocoderEnabled: $data['geocoderEnabled'],
            textEnabled: $data['textEnabled'],
            storageSpace: new StorageInfo(storageSpace: $data['storageSpace']),
            newServer: $data['newServer'],
            openIdEnabled: $data['openIdEnabled'],
            openIdForce: $data['openIdForce'],
            version: $data['version'],
        );
    }

    public function toArray(): array
    {
        return [
            'id'               => $this->id,
            'attributes'       => $this->attributes->toArray(),
            'registration'     => $this->registration,
            'readonly'         => $this->readonly,
            'deviceReadonly'   => $this->deviceReadonly,
            'map'              => $this->map->value,
            'bingKey'          => $this->bingKey,
            'mapUrl'           => $this->mapUrl,
            'overlayUrl'       => $this->overlayUrl,
            'latitude'         => $this->latitude,
            'longitude'        => $this->longitude,
            'zoom'             => $this->zoom,
            'forceSettings'    => $this->forceSettings,
            'coordinateFormat' => $this->coordinateFormat->value,
            'limitCommands'    => $this->limitCommands,
            'disableReports'   => $this->disableReports,
            'fixedEmail'       => $this->fixedEmail,
            'poiLayer'         => $this->poiLayer,
            'announcement'     => $this->announcement,
            'emailEnabled'     => $this->emailEnabled,
            'geocoderEnabled'  => $this->geocoderEnabled,
            'textEnabled'      => $this->textEnabled,
            'storageSpace'     => $this->storageSpace->toArray(),
            'newServer'        => $this->newServer,
            'openIdEnabled'    => $this->openIdEnabled,
            'openIdForce'      => $this->openIdForce,
            'version'          => $this->version,
        ];
    }
}
