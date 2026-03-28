<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Enums\Map;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class UserData
{
    use ParsesTimestamps;
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public bool $readonly,
        public bool $administrator,
        public Map $map,
        public float $latitude,
        public float $longitude,
        public int $zoom,
        public ?string $password,
        public CoordinateFormat $coordinateFormat,
        public bool $disabled,
        public ?CarbonImmutable $expirationTime,
        public int $deviceLimit,
        public int $userLimit,
        public bool $deviceReadonly,
        public bool $limitCommands,
        public bool $fixedEmail,
        public ?string $poiLayer,
        public UserAttributesData $attributes,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            phone: $data['phone'] ?? null,
            readonly: (bool) ($data['readonly'] ?? false),
            administrator: (bool) ($data['administrator'] ?? false),
            map: Map::tryFrom((string) ($data['map'] ?? '')) ?? Map::default(),
            latitude: (float) ($data['latitude'] ?? 0),
            longitude: (float) ($data['longitude'] ?? 0),
            zoom: (int) ($data['zoom'] ?? 0),
            password: $data['password'] ?? null,
            coordinateFormat: CoordinateFormat::tryFrom((string) ($data['coordinateFormat'] ?? '')) ?? CoordinateFormat::default(),
            disabled: (bool) ($data['disabled'] ?? false),
            expirationTime: self::parseTimestamp(raw: $data['expirationTime'] ?? null, field: 'expirationTime'),
            deviceLimit: (int) ($data['deviceLimit'] ?? 0),
            userLimit: (int) ($data['userLimit'] ?? 0),
            deviceReadonly: (bool) ($data['deviceReadonly'] ?? false),
            limitCommands: (bool) ($data['limitCommands'] ?? false),
            fixedEmail: (bool) ($data['fixedEmail'] ?? false),
            poiLayer: $data['poiLayer'] ?? null,
            attributes: UserAttributesData::fromArray($data['attributes'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'readonly'         => $this->readonly,
            'administrator'    => $this->administrator,
            'map'              => $this->map->value,
            'latitude'         => $this->latitude,
            'longitude'        => $this->longitude,
            'zoom'             => $this->zoom,
            'password'         => $this->password,
            'coordinateFormat' => $this->coordinateFormat->value,
            'disabled'         => $this->disabled,
            'expirationTime'   => $this->expirationTime?->toIso8601String(),
            'deviceLimit'      => $this->deviceLimit,
            'userLimit'        => $this->userLimit,
            'deviceReadonly'   => $this->deviceReadonly,
            'limitCommands'    => $this->limitCommands,
            'fixedEmail'       => $this->fixedEmail,
            'poiLayer'         => $this->poiLayer,
            'attributes'       => $this->attributes->toArray(),
        ];
    }
}
