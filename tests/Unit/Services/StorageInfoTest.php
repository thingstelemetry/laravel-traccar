<?php

declare(strict_types=1);

use TrackTelemetry\Traccar\Support\Mount;
use TrackTelemetry\Traccar\Support\StorageInfo;

it(description: 'creates mounts correctly from numeric array', closure: function () {
    $data = [100, 200, 300, 600];

    $info = new StorageInfo(storageSpace: $data);

    expect(value: $info->all())->toHaveCount(count: 2)
        ->and(value: $info->all()[0])->toBeInstanceOf(class: Mount::class)
        ->and(value: $info->all()[0]->free)->toBe(expected: 100)
        ->and(value: $info->all()[0]->total)->toBe(expected: 200);
});

it(description: 'returns formatted mount information', closure: function () {
    $data = [
        1073741824, 2147483648, // 1 GB free, 2 GB total
    ];

    $info = new StorageInfo(storageSpace: $data);
    $formatted = $info->formatted();

    expect(value: $formatted)->toBeArray()
        ->and(value: $formatted[0]['free'])->toBe(expected: '1 GB')
        ->and(value: $formatted[0]['total'])->toBe(expected: '2 GB')
        ->and(value: $formatted[0]['used'])->toBe(expected: '1 GB')
        ->and(value: $formatted[0]['free_percent'])->toBe(expected: '50%');
});

it(description: 'reverts to original numeric array', closure: function () {
    $original = [
        9915609088, 63277150208,
        2576760832, 2576982016,
    ];

    $info = new StorageInfo(storageSpace: $original);

    expect(value: $info->toArray())->toBe(expected: $original);
});
