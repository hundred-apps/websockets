<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Applications Repository
    |--------------------------------------------------------------------------
    |
    | You can apply multiple settings, like the maximum capacity, enable
    | client-to-client messages or statistics.
    |
    */

    'apps' => [

        [
            'host' => env('WEBSOCKETS_HOST'),
            'id' => env('APPWEBSOCKETS_ID'),
            'name' => env('APPWEBSOCKETS_NAME'),
            'key' => env('APPWEBSOCKETS_KEY'),
            'secret' => env('APPWEBSOCKETS_SECRET'),
            'path' => env('APPWEBSOCKETS_PATH'),
            'capacity' => null,
            'enable_client_messages' => false,
            'enable_statistics' => true,
            'allowed_origins' => [],
        ],
    ],





    /*
    |--------------------------------------------------------------------------
    | WebSockets Server Setting
    |--------------------------------------------------------------------------
    |
    | You can configure the WebSockets server setting from here.
    |
    */

    'server' => [

        'host' => env('WEBSOCKETS_HOST', '0.0.0.0'),
        'port' => env('WEBSOCKETS_PORT', 6001),
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Setting
    |--------------------------------------------------------------------------
    |
    | You can configure the dashboard setting from here.
    |
    */

    'dashboard' => [

        'domain' => env('WEBSOCKETS_DASHBOARD_DOMAIN'),
        'path' => env('WEBSOCKETS_DASHBOARD_PATH', 'websockets'),

        'port' => env('WEBSOCKETS_DASHBOARD_PORT', 6001),

        'middleware' => [

            'web',
            // 'api', //
            \BeyondCode\LaravelWebSockets\Dashboard\Http\Middleware\Authorize::class,
        ],
    ],





    /*
    |--------------------------------------------------------------------------
    | Application Manager
    |--------------------------------------------------------------------------
    |
    | An Application manager determines how your websocket server allows
    | the use of the TCP protocol based on, for example, a list of allowed
    | applications.
    |
    | By default, it uses the defined array in the config file, but you can
    | anytime implement the same interface as the class and add your own
    | custom method to retrieve the apps.
    |
    */

    'managers' => [

        'app' => \BeyondCode\LaravelWebSockets\Apps\ConfigAppManager::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting Replication PubSub
    |--------------------------------------------------------------------------
    |
    | You can enable replication to publish and subscribe to messages across the driver.
    |
    | By default, it is set to 'local', but you can configure it to use drivers
    | like Redis to ensure connection between multiple instances of
    | WebSocket servers. Just set the driver to 'redis' to enable the PubSub using Redis.
    |
    */

    'replication' => [

        'mode' => env('WEBSOCKETS_REPLICATION_MODE', 'local'),

        'modes' => [

            /*
            |--------------------------------------------------------------------------
            | Local Replication
            |--------------------------------------------------------------------------
            |
            | Local replication is actually a null replicator, meaning that it
            | is the default behaviour of storing the connections into an array.
            |
            */

            'local' => [

                /*
                |--------------------------------------------------------------------------
                | Channel Manager
                |--------------------------------------------------------------------------
                |
                | The channel manager is responsible for storing, tracking and retrieving
                | the channels as long as their members and connections.
                |
                */

                'channel_manager' => \BeyondCode\LaravelWebSockets\ChannelManagers\LocalChannelManager::class,

                /*
                |--------------------------------------------------------------------------
                | Statistics Collector
                |--------------------------------------------------------------------------
                |
                | The Statistics Collector will, by default, handle the incoming statistics,
                | storing them until they will become dumped into another database, usually
                | a MySQL database or a time-series database.
                |
                */

                'collector' => \BeyondCode\LaravelWebSockets\Statistics\Collectors\MemoryCollector::class,
            ],

            'redis' => [

                'connection' => env('WEBSOCKETS_REDIS_REPLICATION_CONNECTION', 'default'),

                /*
                |--------------------------------------------------------------------------
                | Channel Manager
                |--------------------------------------------------------------------------
                |
                | The channel manager is responsible for storing, tracking and retrieving
                | the channels as long as their members and connections.
                |
                */

                'channel_manager' => \BeyondCode\LaravelWebSockets\ChannelManagers\RedisChannelManager::class,

                /*
                |--------------------------------------------------------------------------
                | Statistics Collector
                |--------------------------------------------------------------------------
                |
                | The Statistics Collector will, by default, handle the incoming statistics,
                | storing them until they will become dumped into another database, usually
                | a MySQL database or a time-series database.
                |
                */

                'collector' => \BeyondCode\LaravelWebSockets\Statistics\Collectors\RedisCollector::class,
            ],
        ],
    ],

    'statistics' => [

        /*
        |--------------------------------------------------------------------------
        | Statistics Store
        |--------------------------------------------------------------------------
        |
        | The Statistics Store is the place where all the temporary stats will
        | be dumped. This is a much reliable store and will be used to display
        | graphs or handle it later on your app.
        |
        */

        'store' => \BeyondCode\LaravelWebSockets\Statistics\Stores\DatabaseStore::class,

        /*
        |--------------------------------------------------------------------------
        | Statistics Interval Period
        |--------------------------------------------------------------------------
        |
        | Here you can specify the interval in seconds at which
        | statistics should be logged.
        |
        */

        'interval_in_seconds' => 60,

        /*
        |--------------------------------------------------------------------------
        | Statistics Deletion Period
        |--------------------------------------------------------------------------
        |
        | When the clean-command is executed, all recorded statistics older than
        | the number of days specified here will be deleted.
        |
        */

        'delete_statistics_older_than_days' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Request Size
    |--------------------------------------------------------------------------
    |
    | The maximum request size in kilobytes that is allowed for
    | an incoming WebSocket request.
    |
    */

    'max_request_size_in_kb' => 250,

    /*
    |--------------------------------------------------------------------------
    | SSL Configuration
    |--------------------------------------------------------------------------
    |
    | By default, the configuration allows only on HTTP. For SSL, you need
    | to set up the the certificate, the key, and optionally, the passphrase
    | for the private key.
    | You will need to restart the server for the settings to take place.
    |
    */

    'ssl' => [

        'local_cert' => env('WEBSOCKETS_SSL_LOCAL_CERT', null),

        'capath' => env('WEBSOCKETS_SSL_CA', null),

        'local_pk' => env('WEBSOCKETS_SSL_LOCAL_PK', null),

        'passphrase' => env('WEBSOCKETS_SSL_PASSPHRASE', null),

        'verify_peer' => env('APP_ENV') === 'production',

        'allow_self_signed' => env('APP_ENV') !== 'production',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Handlers
    |--------------------------------------------------------------------------
    |
    | Here you can specify the route handlers that will take over
    | the incoming/outgoing websocket connections. You can extend the
    | original class and implement your own logic, alongside
    | with the existing logic.
    |
    */

    'handlers' => [

        'websocket' => \BeyondCode\LaravelWebSockets\Server\WebSocketHandler::class,

        'health' => \BeyondCode\LaravelWebSockets\Server\HealthHandler::class,

        'trigger_event' => \BeyondCode\LaravelWebSockets\API\TriggerEvent::class,

        'fetch_channels' => \BeyondCode\LaravelWebSockets\API\FetchChannels::class,

        'fetch_channel' => \BeyondCode\LaravelWebSockets\API\FetchChannel::class,

        'fetch_users' => \BeyondCode\LaravelWebSockets\API\FetchUsers::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Promise Resolver
    |--------------------------------------------------------------------------
    |
    | The promise resolver is a class that takes a input value and is
    | able to make sure the PHP code runs async by using ->then(). You can
    | use your own Promise Resolver. This is usually changed when you want to
    | intercept values by the promises throughout the app, like in testing
    | to switch from async to sync.
    |
    */

    'promise_resolver' => \React\Promise\FulfilledPromise::class,

];