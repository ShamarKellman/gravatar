<?php

namespace ShamarKellman\Gravatar\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use ShamarKellman\Gravatar\Gravatar;
use ShamarKellman\Gravatar\GravatarServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            GravatarServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Gravatar' => Gravatar::class,
        ];
    }
}
