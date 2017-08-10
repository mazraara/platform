<?php

namespace Orchid\Platform\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Orchid\Alert\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Watson\Active\Facades\Active;

abstract class TestCase extends Orchestra
{

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'test',
        ]);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // set up database configuration
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FoundationServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Dashboard' => Dashboard::class,
            'Alert'     => Alert::class,
            'Active'    => Active::class,
        ];
    }


}