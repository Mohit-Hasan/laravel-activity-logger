<?php

return [
    'table_name' => 'activity_logs',

    'user_model' => 'App\\Models\\User',

    'capture_fields' => [
        'ip_address' => true,
        'user_agent' => true,
    ],

    'ignore_events' => [
        'retrieved',
    ],

    'log_events' => [
        'created',
        'updated',
        'deleted',
        'restored',
    ],
];
