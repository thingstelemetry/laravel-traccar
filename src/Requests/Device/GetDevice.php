<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use Throwable;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class GetDevice extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->id}";
    }

    /**
     * Determine if the request has failed based on the response.
     * Detects "200 with empty/invalid body" case when device is not found.
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        // Only handle 200 OK responses with empty/invalid body
        // Let Saloon handle all other status codes (4xx, 5xx) with default exceptions
        if ($response->status() !== 200) {
            return null;
        }

        $json = $response->json();

        // Consider request failed if body is not an array or is empty
        return ! is_array($json) || $json === [];
    }

    /**
     * Get the exception to throw when the request has failed.
     */
    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        // Only return DeviceNotFoundException for 200 responses with empty body
        // For other status codes (4xx, 5xx), return null to let Saloon use default exceptions
        if ($response->status() !== 200) {
            return null;
        }

        return new NotFoundException(
            response: $response,
            message: 'Traccar device was not found. Check the device ID and try again.'
        );
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray($response->json());
    }
}
