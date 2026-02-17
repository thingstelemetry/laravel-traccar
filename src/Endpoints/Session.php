<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\GetSession;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;
use ThingsTelemetry\Traccar\Requests\CreateSession;
use ThingsTelemetry\Traccar\Requests\DeleteSession;
use ThingsTelemetry\Traccar\Requests\GetOpenIdAuth;
use ThingsTelemetry\Traccar\Requests\GetSessionById;
use ThingsTelemetry\Traccar\Requests\GetOpenIdCallback;
use ThingsTelemetry\Traccar\Requests\RevokeSessionToken;
use ThingsTelemetry\Traccar\Requests\GenerateSessionToken;

class Session extends Traccar
{
    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function get(?string $token = null): UserData
    {
        $response = $this->connector->send(request: new GetSession(token: $token));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function getById(int $userId): UserData
    {
        $response = $this->connector->send(request: new GetSessionById(userId: $userId));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function create(string $email, string $password, ?int $code = null): UserData
    {
        $response = $this->connector->send(
            request: new CreateSession(email: $email, password: $password, code: $code)
        );

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function delete(): StatusData
    {
        $response = $this->connector->send(request: new DeleteSession());

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function generateToken(?CarbonInterface $expiration = null): SessionTokenData
    {
        $response = $this->connector->send(
            request: new GenerateSessionToken(expiration: $expiration)
        );

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function revokeToken(string $token): StatusData
    {
        $response = $this->connector->send(request: new RevokeSessionToken(token: $token));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function getOpenIdAuthUrl(): string
    {
        $response = $this->connector->send(request: new GetOpenIdAuth());

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function handleOpenIdCallback(string $queryString): string
    {
        $response = $this->connector->send(request: new GetOpenIdCallback(queryString: $queryString));

        return $response->dtoOrFail();
    }
}
