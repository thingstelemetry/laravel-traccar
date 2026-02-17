<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class UploadServerFile extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        public string $path,
        protected string $mimeType,
        protected string $contents,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/server/file/{$this->path}";
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => $this->mimeType,
            'Accept'       => '*/*',
        ];
    }

    /** @return array<string, mixed> */
    protected function defaultConfig(): array
    {
        return [
            'body' => $this->contents,
        ];
    }
}
