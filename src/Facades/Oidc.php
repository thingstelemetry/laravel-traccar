<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\OidcTokenData;
use ThingsTelemetry\Traccar\Dto\OidcUserInfoData;

/**
 * @method static string authorize(string $clientId, string $redirectUri, ?string $state = null, ?string $scope = null, ?string $responseType = null, ?string $codeChallenge = null, ?string $codeChallengeMethod = null, ?string $nonce = null)
 * @method static OidcTokenData getToken(string $grantType, string $code, ?string $redirectUri = null, ?string $clientId = null, ?string $clientSecret = null, ?string $codeVerifier = null)
 * @method static OidcUserInfoData getUserInfo()
 * @method static array getJwks()
 */
class Oidc extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Oidc::class;
    }
}
