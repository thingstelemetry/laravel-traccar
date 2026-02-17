<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use InvalidArgumentException;

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
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            userId: array_key_exists('userId', $data) ? (is_null($data['userId']) ? null : (int) $data['userId']) : null,
            deviceId: array_key_exists('deviceId', $data) ? (is_null($data['deviceId']) ? null : (int) $data['deviceId']) : null,
            groupId: array_key_exists('groupId', $data) ? (is_null($data['groupId']) ? null : (int) $data['groupId']) : null,
            geofenceId: array_key_exists('geofenceId', $data) ? (is_null($data['geofenceId']) ? null : (int) $data['geofenceId']) : null,
            notificationId: array_key_exists('notificationId', $data) ? (is_null($data['notificationId']) ? null : (int) $data['notificationId']) : null,
            calendarId: array_key_exists('calendarId', $data) ? (is_null($data['calendarId']) ? null : (int) $data['calendarId']) : null,
            attributeId: array_key_exists('attributeId', $data) ? (is_null($data['attributeId']) ? null : (int) $data['attributeId']) : null,
            driverId: array_key_exists('driverId', $data) ? (is_null($data['driverId']) ? null : (int) $data['driverId']) : null,
            managedUserId: array_key_exists('managedUserId', $data) ? (is_null($data['managedUserId']) ? null : (int) $data['managedUserId']) : null,
            commandId: array_key_exists('commandId', $data) ? (is_null($data['commandId']) ? null : (int) $data['commandId']) : null,
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
        ], fn ($value) => $value !== null);

        if (count($nonNullProperties) !== 2) {
            throw new InvalidArgumentException('Permission must have exactly 2 properties set, ' . count($nonNullProperties) . ' given.');
        }
    }
}
