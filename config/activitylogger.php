<?php

declare(strict_types=1);

return [

    'table_name' => (string) env('ACTIVITY_ACTIVITY_LOGGER', 'activity_logs'),

    'model_events' => (array) [

        'created' => true,
        'updated' => true,
        'deleted' => true,

        'restored' => false,
        'forceDeleted' => false,

        'creating' => false,
        'updating' => false,
        'deleting' => false,

    ],

    'request_payload' => [
        'except' => [
            'password',
            'password_confirmation',
        ],
    ],

];
