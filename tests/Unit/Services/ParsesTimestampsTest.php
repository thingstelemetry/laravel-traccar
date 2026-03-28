<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Dto\AuditData;

it(description: 'parses valid timestamp string', closure: function () {
    $dto = AuditData::fromArray(data: ['actionTime' => '2024-01-15T10:30:00Z']);

    expect($dto->actionTime)->toBeInstanceOf(CarbonImmutable::class)
        ->and($dto->actionTime->toIso8601String())->toBe('2024-01-15T10:30:00+00:00');
});

it(description: 'returns null for missing timestamp', closure: function () {
    $dto = AuditData::fromArray(data: []);

    expect($dto->actionTime)->toBeNull();
});

it(description: 'returns null for empty timestamp string', closure: function () {
    $dto = AuditData::fromArray(data: ['actionTime' => '']);

    expect($dto->actionTime)->toBeNull();
});

it(description: 'returns null for invalid timestamp', closure: function () {
    $dto = AuditData::fromArray(data: ['actionTime' => 'not-a-date']);

    expect($dto->actionTime)->toBeNull();
});
