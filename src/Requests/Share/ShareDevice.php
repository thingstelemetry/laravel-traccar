<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Share;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;

class ShareDevice extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        public int $deviceId,
        public CarbonInterface $expiration,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/share/device';
    }

    public function createDtoFromResponse(Response $response): DeviceShareData
    {
        return DeviceShareData::fromToken(
            deviceId: $this->deviceId,
            token: $response->body(),
            expiration: $this->expiration,
            apiBaseUrl: config('traccar.base_url'),
        );
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept'       => 'text/plain, */*',
        ];
    }

    protected function defaultBody(): array
    {
        return [
            'deviceId'   => $this->deviceId,
            'expiration' => $this->expiration->toIso8601String(),
        ];
    }
}
