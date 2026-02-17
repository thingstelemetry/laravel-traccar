<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class UpdateDeviceTotals extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        public int $deviceId,
        public float $totalDistance,
        public float $hours,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->deviceId}/accumulators";
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /** @return array<string, int|float> */
    protected function defaultBody(): array
    {
        return [
            'deviceId'      => $this->deviceId,
            'totalDistance' => $this->totalDistance,
            'hours'         => $this->hours,
        ];
    }
}
