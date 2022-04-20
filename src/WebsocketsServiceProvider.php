<?php

namespace Hundredapps\Websockets;

use Hundredapps\Websockets\Console\Commands\ServeCommand;
use Hundredapps\Websockets\Console\Commands\ReloadCommand;
use Hundredapps\Websockets\Console\Commands\CleanStatistics;
use BeyondCode\LaravelWebSockets\WebSocketsServiceProvider as ServiceProvider;

class WebsocketsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerPublishers();
        $this->registerMigrators();
        $this->registerAsyncRedisQueueDriver();
        $this->registerRouter();
        $this->registerManagers();
        $this->registerStatistics();
        $this->registerDashboard();
        $this->registerCommands();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands(
            [
                ServeCommand::class,
                ReloadCommand::class,
                CleanStatistics::class,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/websockets.php', 'websockets');

        $this->publishes(
        [
            __DIR__ . '/../config/websockets.php' => config_path('websockets.php'),
        ],

        'hundredapps-websockets');
    }

    /**
     * @return void
     */
    protected function registerMigrators()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}