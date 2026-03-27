<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Share;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Dto\GroupShareData;

class ShareGroup extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        public int $groupId,
        public CarbonInterface $expiration,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/devices/group';
    }

    public function createDtoFromResponse(Response $response): GroupShareData
    {
        return GroupShareData::fromToken(
            groupId: $this->groupId,
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
            'groupId'    => $this->groupId,
            'expiration' => $this->expiration->toIso8601String(),
        ];
    }
}
