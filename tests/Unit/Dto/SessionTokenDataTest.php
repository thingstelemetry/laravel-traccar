<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Dto\SessionTokenData;

it(description: 'creates SessionTokenData from string', closure: function () {
    $token = 'abc123xyz789token';
    $tokenData = SessionTokenData::fromString($token);

    expect($tokenData)
        ->toBeInstanceOf(SessionTokenData::class)
        ->and($tokenData->token)->toBe($token);
});

it(description: 'creates SessionTokenData via constructor', closure: function () {
    $token = 'my-secret-token-123';
    $tokenData = new SessionTokenData(token: $token);

    expect($tokenData)
        ->toBeInstanceOf(SessionTokenData::class)
        ->and($tokenData->token)->toBe($token);
});

it(description: 'serializes to array correctly', closure: function () {
    $token = 'token-value-456';
    $tokenData = SessionTokenData::fromString($token);

    $array = $tokenData->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKey('token')
        ->and($array['token'])->toBe($token);
});

it(description: 'handles long token strings', closure: function () {
    $longToken = str_repeat('a', 1000);
    $tokenData = SessionTokenData::fromString($longToken);

    expect($tokenData->token)->toBe($longToken);
});

it(description: 'handles special characters in token', closure: function () {
    $specialToken = 'token+with/special=chars&symbols!';
    $tokenData = SessionTokenData::fromString($specialToken);

    expect($tokenData->token)->toBe($specialToken);
});
