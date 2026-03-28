<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\AuditData;
use ThingsTelemetry\Traccar\Facades\Audit;
use ThingsTelemetry\Traccar\Requests\Audit\GetAuditLogs;

describe(description: 'get', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $from = CarbonImmutable::parse('2025-01-01T00:00:00Z');
        $to = CarbonImmutable::parse('2025-01-01T23:59:59Z');
        $request = new GetAuditLogs(from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/audit')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);

        $query = $request->query()->all();
        expect(value: $query['from'])->toBe(expected: '2025-01-01T00:00:00+00:00')
            ->and(value: $query['to'])->toBe(expected: '2025-01-01T23:59:59+00:00');
    });

    test(description: 'returns audit logs via facade', closure: function () {
        $payload = [
            [
                'id'         => 1,
                'userId'     => 10,
                'userEmail'  => 'admin@example.com',
                'type'       => 'login',
                'actionTime' => '2025-01-01T12:00:00Z',
                'attributes' => [],
            ],
            [
                'id'         => 2,
                'userId'     => 11,
                'userEmail'  => 'user@example.com',
                'type'       => 'deviceUpdate',
                'actionTime' => '2025-01-01T13:00:00Z',
                'attributes' => ['deviceId' => 5],
            ],
        ];

        MockClient::global(mockData: [
            GetAuditLogs::class => MockResponse::make(body: $payload),
        ]);

        $auditLogs = Audit::get();

        expect(value: $auditLogs)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $auditLogs->count())->toBe(expected: 2)
            ->and(value: $auditLogs->first())->toBeInstanceOf(class: AuditData::class)
            ->and(value: $auditLogs->first()->userEmail)->toBe(expected: 'admin@example.com');
    });
});
