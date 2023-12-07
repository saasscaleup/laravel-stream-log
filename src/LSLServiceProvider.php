<?php

namespace Saasscaleup\LSL;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Log\Events\MessageLogged;

class LSLServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
     
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/Views', 'lsl');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // Publish the configuration file.
            $this->publishes([
                __DIR__ . '/Config/lsl.php' => config_path('lsl.php'),
            ], 'lsl.config');

            // Publish the views.
            $this->publishes([
                __DIR__ . '/Views' => base_path('resources/views/vendor/lsl'),
            ], 'lsl.views');

            // Publish the migrations.
            $this->publishes([
                __DIR__ . '/Migrations' => database_path('migrations')
            ]);
        }

        // If Log listener enabled
        if (config('lsl.log_enabled')){

            // register event handler
            Event::listen(MessageLogged::class, function (MessageLogged $e) {

                // If log type in array
                if (in_array($e->level,explode(',',config('lsl.log_type')))){

                    
                    $message = empty($e->context) ? $e->message : $e->message.' : '.json_encode($e->context);
                    
                    if (config('lsl.log_specific')!==''){
                        if (str_contains($message,config('lsl.log_specific')) ){
                            stream_log($message,$e->level,'stream');
                        }
                    }else{
                        stream_log($message,$e->level,'stream');
                    }
                }
            }); 

        }
    }

    /**
     * Register package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/lsl.php', 'lsl');

        // Register the service package provides.
        $this->app->singleton('LSL', function () {
            return $this->app->make(LSL::class);
        });
    }
}
