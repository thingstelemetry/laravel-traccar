<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Exception;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\OidcTokenData;
use ThingsTelemetry\Traccar\Dto\JwksResponseDto;
use ThingsTelemetry\Traccar\Dto\OidcUserInfoData;
use ThingsTelemetry\Traccar\Requests\Oidc\GetJwks;
use ThingsTelemetry\Traccar\Requests\Oidc\GetToken;
use Saloon\Exceptions\Request\FatalRequestException;
use ThingsTelemetry\Traccar\Requests\Oidc\Authorize;
use ThingsTelemetry\Traccar\Requests\Oidc\GetUserInfo;

class Oidc extends Traccar
{
    public function authorize(
        string $clientId,
        string $redirectUri,
        ?string $state = null,
        ?string $scope = null,
        ?string $responseType = null,
        ?string $codeChallenge = null,
        ?string $codeChallengeMethod = null,
        ?string $nonce = null,
    ): string {
        $response = $this->connector->send(request: new Authorize(
            clientId: $clientId,
            redirectUri: $redirectUri,
            state: $state,
            scope: $scope,
            responseType: $responseType,
            codeChallenge: $codeChallenge,
            codeChallengeMethod: $codeChallengeMethod,
            nonce: $nonce,
        ));

        $location = $response->header(header: 'Location');

        if (is_null($location) || $location === '') {
            throw new FatalRequestException(
                new Exception('OIDC authorize failed: Location header is missing from the response.'),
                $response->getPendingRequest()
            );
        }

        return $location;
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function getToken(
        string $grantType,
        string $code,
        ?string $redirectUri = null,
        ?string $clientId = null,
        ?string $clientSecret = null,
        ?string $codeVerifier = null,
    ): OidcTokenData {
        return $this->connector->send(request: new GetToken(
            grantType: $grantType,
            code: $code,
            redirectUri: $redirectUri,
            clientId: $clientId,
            clientSecret: $clientSecret,
            codeVerifier: $codeVerifier,
        ))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function getUserInfo(): OidcUserInfoData
    {
        return $this->connector->send(request: new GetUserInfo())->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function getJwks(): JwksResponseDto
    {
        return $this->connector->send(request: new GetJwks())->dtoOrFail();
    }
}
