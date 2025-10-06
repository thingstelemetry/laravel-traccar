<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TrackTelemetry\Traccar\Dto\ServerData;

class GetServerInformation extends Request
{
    protected Method $method = Method::GET;

    /**
     * Resolves and returns the API endpoint for initializing a transaction.
     */
    public function resolveEndpoint(): string
    {
        return '/server';
    }

    /**
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json()['data'];

        return new ServerData(
            id: $data['id'],
            registration: $data['registration'],
            readonly: $data['readonly'],
            deviceReadonly: $data['deviceReadonly'],
            limitCommands: $data['limitCommands'],
            map: $data['map'],
            bingKey: $data['bingKey'],
            mapUrl: $data['mapUrl'],
            poiLayer: $data['poiLayer'],
            latitude: $data['latitude'],
            longitude: $data['longitude'],
            zoom: $data['zoom'],
            version: $data['version'],
            forceSettings: $data['forceSettings'],
            coordinateFormat: $data['coordinateFormat'],
            openIdEnabled: $data['openIdEnabled'],
            openIdForce: $data['openIdForce'],
            attributes: $data['attributes'],
        );
    }
}
