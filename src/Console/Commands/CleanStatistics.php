<?php

namespace Hundredapps\Websockets\Console\Commands;

use BeyondCode\LaravelWebSockets\Console\Commands\CleanStatistics as Command;

class CleanStatistics extends Command
{
    /**
     * @var string
     */
    public $signature = 'websockets:clean {appId? : (optional) The app id that will be cleaned}
                        {--days= : Delete records older than this amount of days since now}';

    /**
     * @var string
     */
    public $description = 'Clean up old statistics from the WebSocket statistics storage';
}