<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Support\Mount;

it(description: 'stores free and total values correctly', closure: function () {
    $mount = new Mount(free: 500, total: 1000);

    expect(value: $mount->free)->toBe(expected: 500)
        ->and(value: $mount->total)->toBe(expected: 1000);
});

it(
    description: 'returns correctly formatted free and total values',
    closure: function (int $free, int $total, string $expectedFree, string $expectedTotal) {
        $mount = new Mount(free: $free, total: $total);

        expect($mount->freeFormatted())->toBe($expectedFree)
            ->and($mount->totalFormatted())->toBe($expectedTotal);
    }
)->with([
    [500, 245723652, '500 B', '234.34 MB'],
    [2048, 245723652, '2 KB', '234.34 MB'],
    [1048576, 2147483648, '1 MB', '2 GB'],
]);

it(description: 'calculates the correct free percentage', closure: function () {
    $mount = new Mount(free: 50, total: 200);

    expect(value: $mount->freePercent())->toBe(expected: 25.0);
});
