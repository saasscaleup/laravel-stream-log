<?php

Route::group(
    [
        'namespace' => 'Saasscaleup\LSL\Http\Controllers',
        'prefix' => 'lsl'
    ],
    static function () {

        Route::get('stream_log', 'LSLController@stream')->name('lsl-stream-log');
    }
);
