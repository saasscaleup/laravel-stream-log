<?php

return [

    // enable or disable LSL
    'enabled' => env('LSL_ENABLED', true),

    // enable or disable laravel log listener 
    'log_enabled' => env('LSL_LOG_ENABLED', true),

    // log listener  for specific log type
    'log_type' => env('LSL_LOG_TYPE', 'info,error,warning,alert,critical,debug'), // Without space

    // log listener for specific word inside log messages
    'log_specific' => env('LSL_LOG_SPECIFIC', ''), // 'test' or 'foo' or 'bar' or leave empty '' to anyable any word

    // echo data loop in LSLController
    'interval' => env('LSL_INTERVAL', 1),

    // append logged user id in LSL response
    'append_user_id' => env('LSL_APPEND_USER_ID', true),

    // keep events log in database
    'keep_events_logs' => env('LSL_KEEP_EVENTS_LOGS', false),

    'server_event_retry' => env('LSL_SERVER_EVENT_RETRY', '4000'),

    // every 10 minutes cache expired, delete logs on next request
    'delete_log_interval' => env('LSL_DELETE_LOG_INTERVAL', 600), 

    /******* Frontend *******/

    // eanlbed console log on browser
    'js_console_log_enabled' => env('LSL_JS_CONSOLE_LOG_ENABLED', true),

     // js notification toast library
    'js_notification_library' => env('LSL_JS_NOTIFICATION_LIBRARY', 'noty'), // 'izitoast' or 'noty'

    // notification settings
    'js_position' => 'bottomRight', // topLeft, topCenter, topRight, center, bottomLeft, bottomCenter, bottomRight
    'js_timeout' => 5000, // false, 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms). Set 'false' for sticky notifications.
];
