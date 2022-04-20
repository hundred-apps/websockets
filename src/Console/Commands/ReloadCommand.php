<?php

namespace Hundredapps\Websockets\Console\Commands;

use BeyondCode\LaravelWebSockets\Console\Commands\RestartServer as Command;

class ReloadCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'websockets:reload';

    /**
     * @var string
     */
    public $description = 'Signal the WebSockets server to reload and restart';
}