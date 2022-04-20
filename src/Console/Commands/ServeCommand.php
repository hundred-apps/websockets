<?php

namespace Hundredapps\Websockets\Console\Commands;

use BeyondCode\LaravelWebSockets\ServerFactory;
use BeyondCode\LaravelWebSockets\Console\Commands\StartServer as Command;
use BeyondCode\LaravelWebSockets\Facades\WebSocketRouter;

class ServeCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'websockets:serve
                        {--host= : The IP address the WebSockets server should bind to}
                        {--port= : The port the WebSockets server should be available on}
                        {--statistics-interval= : The amount of seconds to tick between statistics saving}
                        {--disable-statistics : Disable the statistics tracking}
                        {--debug : Forces the loggers to be enabled and thereby overriding the APP_DEBUG setting}
                        {--loop : Programatically inject the loop}';

    /**
     * @var string
     */
    public $description = 'Serve the WebSockets server';

    /**
     * @return string
     */
    protected function host()
    {
        return $this->option('host') ?? config('websockets.server.host', 'localhost');
    }

    /**
     * @return int
     */
    protected function port()
    {
        return $this->option('port') ?? config('websockets.server.port', 6001);
    }

    /**
     * @return void
     */
    protected function buildServer()
    {
        $this->server = new ServerFactory($this->host(), $this->port());

        if ($loop = $this->option('loop')) {

            $this->loop = $loop;
        }

        $this->server = $this->server
        ->setLoop($this->loop)
        ->withRoutes(WebSocketRouter::getRoutes())
        ->setConsoleOutput($this->output)
        ->createServer();
    }

    /**
     * @return void
     */
    protected function startServer()
    {
        $this->info("WebSocket server running on : " . $this->host() . ':' . $this->port() . '.');

        $this->buildServer();

        $this->server->run();
    }
}