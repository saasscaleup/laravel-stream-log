![Main Window two](https://github.com/saasscaleup/laravel-stream-log/blob/master/lsl-saasscaleup.png?raw=true)

<h3 align="center">Easily stream your Laravel application logs to the frontend in real-time using server-sent event (SSE)</h3>

<h4 align="center">
  <a href="https://youtube.com/@ScaleUpSaaS">Youtube</a>
  <span> · </span>
  <a href="https://twitter.com/ScaleUpSaaS">Twitter</a>
  <span> · </span>
  <a href="https://facebook.com/ScaleUpSaaS">Facebook</a>
  <span> · </span>
  <a href="https://buymeacoffee.com/scaleupsaas">By Me a Coffee</a>
</h4>

<p align="center">
   <a href="https://packagist.org/packages/saasscaleup/laravel-stream-log">
      <img src="https://poser.pugx.org/saasscaleup/laravel-stream-log/v/stable.png" alt="Latest Stable Version">
  </a>

  <a href="https://packagist.org/packages/maatwebsite/excel">
      <img src="https://poser.pugx.org/saasscaleup/laravel-stream-log/downloads.png" alt="Total Downloads">
  </a>

  <a href="https://packagist.org/packages/maatwebsite/excel">
    <img src="https://poser.pugx.org/saasscaleup/laravel-stream-log/license.png" alt="License">
  </a>
</p>

## ✨ Features

- **Easily stream your Backend log.** 
- **Easily stream your Storage/Logs/Laravel log.** 
<br>

![banner](https://github.com/saasscaleup/laravel-stream-log/blob/master/lsl-demo.gif?raw=true)
<br>


## Requirements

 - PHP >= 7
 - Laravel >= 5

## Installation

Via Composer

``` bash
$ composer require saasscaleup/laravel-stream-log
```

For Laravel < 5.5:

Add Service Provider to `config/app.php` in `providers` section
```php
Saasscaleup\LSL\LSLServiceProvider::class,
```

Add Facade to `config/app.php` in `aliases` section
```php
'LSL' => Saasscaleup\LSL\Facades\LSLFacade::class,
```


---

Publish package's config, migration and view files by running below command:

```bash
$ php artisan vendor:publish --provider="Saasscaleup\LSL\LSLServiceProvider"
```

Run `php artisan migrate` to create `stream_logs` table.

## Setup LSL

Aadd this in your view/layout (usually `layout/app.blade.php`) file:

```php
@include('lsl::view')
```

## Configuration

Configuration is done via environment variables or directly in the configuration file (`config/lsl.php`).

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

By default, package uses [noty](https://github.com/needim/noty) for showing notifications. You can customize this by modifying code in `resources/views/vendor/lsl/view.blade.php` file.

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

## Inspired By

[open-source](https://github.com/arfraznawaz2005/laravel-sse)

## License

Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/saasscaleup/laravel-stream-log.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/saasscaleup/laravel-stream-log.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/saasscaleup/laravel-stream-log
[link-downloads]: https://packagist.org/packages/saasscaleup/laravel-stream-log
[link-author]: https://github.com/saasscaleup
[link-contributors]: https://github.com/saasscaleup/laravel-stream-log/graphs/contributors
