<?php

namespace Christophrumpel\NovaNotifications\Tests;

use Exception;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\Exceptions\Handler;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Christophrumpel\NovaNotifications\ToolServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
        Route::middlewareGroup('nova', []);
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../tests/');
        $this->withFactories(__DIR__.'/../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            ToolServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('nova-notifications.modelNamespace', 'Christophrumpel\NovaNotifications\Tests\Models');

        $app['config']->set('nova-notifications.notificationNamespace', 'Christophrumpel\NovaNotifications\Tests\Notifications');
    }

    // Framework-supplied test case methods snipped for brevity
    // Use this version if you're on PHP 7
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }
}
