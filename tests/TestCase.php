<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            \TrackTelemetry\Traccar\TraccarServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Set Traccar test configuration
        $app['config']->set('traccar.base_url', 'http://localhost:8082/api');
        ;
        $app['config']->set('traccar.api_key', 'RjBEAiBPwAHAh0kzeb6qlD0RTnGhOnm6HmdcKMEdau5ZfMZ1LwI');
    }
}
