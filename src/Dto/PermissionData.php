<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use InvalidArgumentException;
use ThingsTelemetry\Traccar\Support\DataHelper;

class PermissionData
{
    public function __construct(
        public ?int $userId = null,
        public ?int $deviceId = null,
        public ?int $groupId = null,
        public ?int $geofenceId = null,
        public ?int $notificationId = null,
        public ?int $calendarId = null,
        public ?int $attributeId = null,
        public ?int $driverId = null,
        public ?int $managedUserId = null,
        public ?int $commandId = null,
        public ?int $maintenanceId = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            userId: DataHelper::nullableInt(data: $data, key: 'userId'),
            deviceId: DataHelper::nullableInt(data: $data, key: 'deviceId'),
            groupId: DataHelper::nullableInt(data: $data, key: 'groupId'),
            geofenceId: DataHelper::nullableInt(data: $data, key: 'geofenceId'),
            notificationId: DataHelper::nullableInt(data: $data, key: 'notificationId'),
            calendarId: DataHelper::nullableInt(data: $data, key: 'calendarId'),
            attributeId: DataHelper::nullableInt(data: $data, key: 'attributeId'),
            driverId: DataHelper::nullableInt(data: $data, key: 'driverId'),
            managedUserId: DataHelper::nullableInt(data: $data, key: 'managedUserId'),
            commandId: DataHelper::nullableInt(data: $data, key: 'commandId'),
            maintenanceId: DataHelper::nullableInt(data: $data, key: 'maintenanceId'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'userId'         => $this->userId,
            'deviceId'       => $this->deviceId,
            'groupId'        => $this->groupId,
            'geofenceId'     => $this->geofenceId,
            'notificationId' => $this->notificationId,
            'calendarId'     => $this->calendarId,
            'attributeId'    => $this->attributeId,
            'driverId'       => $this->driverId,
            'managedUserId'  => $this->managedUserId,
            'commandId'      => $this->commandId,
            'maintenanceId'  => $this->maintenanceId,
        ], fn ($value) => $value !== null);
    }

    public function validate(): void
    {
        $nonNullProperties = array_filter([
            $this->userId,
            $this->deviceId,
            $this->groupId,
            $this->geofenceId,
            $this->notificationId,
            $this->calendarId,
            $this->attributeId,
            $this->driverId,
            $this->managedUserId,
            $this->commandId,
            $this->maintenanceId,
        ], fn ($value) => $value !== null);

        if (count($nonNullProperties) !== 2) {
            throw new InvalidArgumentException('Permission must have exactly 2 properties set, ' . count($nonNullProperties) . ' given.');
        }
    }
}
