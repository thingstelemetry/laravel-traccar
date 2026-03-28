<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Support\DataHelper;

it(description: 'returns null for missing key', closure: function () {
    expect(DataHelper::nullableInt(data: [], key: 'id'))->toBeNull();
});

it(description: 'returns null for null value', closure: function () {
    expect(DataHelper::nullableInt(data: ['id' => null], key: 'id'))->toBeNull();
});

it(description: 'casts present integer value', closure: function () {
    expect(DataHelper::nullableInt(data: ['id' => 42], key: 'id'))->toBe(42);
});

it(description: 'casts string integer to int', closure: function () {
    expect(DataHelper::nullableInt(data: ['id' => '7'], key: 'id'))->toBe(7);
});

it(description: 'returns empty array for missing key', closure: function () {
    expect(DataHelper::arrayField(data: [], key: 'attributes'))->toBe([]);
});

it(description: 'returns empty array for non-array value', closure: function () {
    expect(DataHelper::arrayField(data: ['attributes' => 'invalid'], key: 'attributes'))->toBe([]);
});

it(description: 'returns array value when present', closure: function () {
    $attrs = ['key' => 'value'];
    expect(DataHelper::arrayField(data: ['attributes' => $attrs], key: 'attributes'))->toBe($attrs);
});
