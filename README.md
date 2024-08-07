![Main Window two](https://github.com/saasscaleup/laravel-stream-log/blob/master/lsl-saasscaleup.png?raw=true)

<h3 align="center">Easily stream your Laravel application logs to the frontend in real-time using server-sent event (SSE)</h3>

<h4 align="center">
  <a href="https://youtube.com/@ScaleUpSaaS">Youtube</a>
  <span> · </span>
  <a href="https://twitter.com/ScaleUpSaaS">Twitter</a>
  <span> · </span>
  <a href="https://facebook.com/ScaleUpSaaS">Facebook</a>
  <span> · </span>
  <a href="https://buymeacoffee.com/scaleupsaas">Buy Me a Coffee</a>
</h4>

<p align="center">
   <a href="https://packagist.org/packages/saasscaleup/laravel-stream-log">
      <img src="https://img.shields.io/packagist/v/saasscaleup/laravel-stream-log.svg?style=flat-square" alt="Latest Stable Version">
  </a>

  <a href="https://packagist.org/packages/saasscaleup/laravel-stream-log">
      <img src="https://img.shields.io/packagist/dt/saasscaleup/laravel-stream-log.svg?style=flat-square" alt="Total Downloads">
  </a>

  <a href="https://packagist.org/packages/saasscaleup/laravel-stream-log">
    <img src="https://img.shields.io/packagist/l/saasscaleup/laravel-stream-log.svg?style=flat-square" alt="License">
  </a>
</p>

## ✨ Features

- **Easily stream your Backend events from your Controllers \ Events \ Models \ Etc... .** 
- **Easily stream your Logs (`storage/logs/laravel.log`).**
- **Print Backend logs and events to Frontend browser `console.log(data)`** 

<br>

![banner](https://github.com/saasscaleup/laravel-stream-log/blob/master/lsl-demo.gif?raw=true)
<br>


## Requirements

 - PHP >= 7
 - Laravel >= 5

## Installation

### Install composer package (dev)

Via Composer - Not recommended for production environment

``` bash
$ composer require --dev saasscaleup/laravel-stream-log
```

#### For Laravel < 5.5

Add Service Provider to `config/app.php` in `providers` section
```php
Saasscaleup\LSL\LSLServiceProvider::class,
```

Add Facade to `config/app.php` in `aliases` section
```php
'LSL' => Saasscaleup\LSL\Facades\LSLFacade::class,
```


---

### Publish package's config, migration and view files


Publish package's config, migration and view files by running below command:

```bash
$ php artisan vendor:publish --provider="Saasscaleup\LSL\LSLServiceProvider"
```

### Run migration command

Run `php artisan migrate` to create `stream_logs` table.

```bash
$ php artisan migrate
```

## Setup Laravel Stream Log -> LSL 

Aadd this in your main view/layout (usually `layout/app.blade.php`) file:

```php
@include('lsl::view')
```

## Configuration

Configuration is done via environment variables or directly in the configuration file (`config/lsl.php`).

```
<?php

return [

    // enable or disable LSL
    'enabled' => env('LSL_ENABLED', true),

    // enable or disable laravel log listener 
    'log_enabled' => env('LSL_LOG_ENABLED', true),

    // log listener  for specific log type
    'log_type' => env('LSL_LOG_TYPE', 'info,error,warning,alert,critical,debug'), // Without space

    // log listener for specific word inside log messages
    'log_specific' => env('LSL_LOG_SPECIFIC', ''), // 'test' or 'foo' or 'bar' or leave empty '' to disable this feature

    // echo data loop in LSLController
    'interval' => env('LSL_INTERVAL', 1),

    // append logged user id in LSL response
    'append_user_id' => env('LSL_APPEND_USER_ID', true),

    // keep events log in database
    'keep_events_logs' => env('LSL_KEEP_EVENTS_LOGS', false),

    // Frontend pull invoke interval
    'server_event_retry' => env('LSL_SERVER_EVENT_RETRY', '2000'),

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
```

## Usage

Syntax:

```php
/**
* @param string $message : notification message
* @param string $type : alert, success, error, warning, info, debug, critical, etc...
* @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
 */
LSLFacade::notify($message, $type = 'info', $event = 'stream')
```

To show popup notifications on the screen, in your controllers/event classes, you can  do:

```php
use Saasscaleup\LSL\Facades\LSLFacade;

public function myFunction()
{

    LSLFacade::notify('Invoke stream log via Facade 1');

    // Some code here

    LSLFacade::notify('Invoke stream log via Facade 2');

    // Some code here

    LSLFacade::notify('Invoke stream log via Facade 3');
    
    // or via helper
    stream_log('Invoke stream log via helper 1');
    stream_log('Invoke stream log via helper 2');     
    stream_log('Invoke stream log via helper 3');
}
```



## Customizing Notification Library

By default, package uses [noty](https://github.com/needim/noty) for showing notifications. 

You can switch to  [izitoast](https://izitoast.marcelodolza.com/) by updating config file `config/lsl.php`

```
 // js notification toast library
'js_notification_library' => env('LSL_JS_NOTIFICATION_LIBRARY', 'izitoast'), // 'izitoast' or 'noty'
```

You can also, customize this by modifying code in `resources/views/vendor/lsl/view.blade.php` file.

## Customizing LSL Events

By default, pacakge uses `stream` event type for streaming response:


```php
LSLFacade::notify($message, $type = 'info', $event = 'message')
```

Notice `$event = 'stream'`. You can customize this, let's say you want to use `UserPurchase` as SSE event type:

```php
use Saasscaleup\LSL\Facades\LSLFacade;

public function myMethod()
{
    SSEFacade::notify('User purchase plan - step 1', 'info', 'UserPurchase');
    
    // or via helper
    stream_log('User purchase plan - step 1', 'info', 'UserPurchase');
}
```

Then you need to handle this in your view yourself like this:

```javascript
<script>
var es = new EventSource("{{route('lsl-stream-log')}}");

es.addEventListener("UserPurchase", function (e) {
    var data = JSON.parse(e.data);
    alert(data.message);
}, false);

</script>
```

## License

Please see the [MIT](license.md) for more information.


## Support 🙏😃
  
 If you Like the tutorial and you want to support my channel so I will keep releasing amzing content that will turn you to a desirable Developer with Amazing Cloud skills... I will realy appricite if you:
 
 1. Subscribe to our [youtube](http://www.youtube.com/@ScaleUpSaaS?sub_confirmation=1)
 2. Buy me A [coffee ❤️](https://www.buymeacoffee.com/scaleupsaas)

Thanks for your support :)

<a href="https://www.buymeacoffee.com/scaleupsaas"><img src="https://img.buymeacoffee.com/button-api/?text=Buy me a coffee&emoji=&slug=scaleupsaas&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff" /></a>
