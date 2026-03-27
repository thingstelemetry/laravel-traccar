<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

class Share extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function device(int $deviceId, CarbonInterface $expiration): DeviceShareData
    {
        return $this->connector->send(
            request: new ShareDevice(
                deviceId: $deviceId,
                expiration: $expiration,
            )
        )->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function group(int $groupId, CarbonInterface $expiration): GroupShareData
    {
        return $this->connector->send(
            request: new ShareGroup(
                groupId: $groupId,
                expiration: $expiration,
            )
        )->dtoOrFail();
    }
}
