<br />
<br />
<p align="center">
  <!-- XMAS: https://user-images.githubusercontent.com/7728097/146406114-a5f5e13a-e2ee-47a2-9bf9-ad43cdbdf200.png-->
![alt text](https://github.com/saasscaleup/laravel-stream-log/blob/master/lsl-saasscaleup.png?raw=true)
</p>
<br />


<h3 align="center">Easily stream your Laravel application logs to the frontend in real-time using server-sent event (SSE)</h3>

<h4 align="center">
  <a href="https://youtube.com/@ScaleUpSaaS">Youtube Channel 🎥</a>
  <span> · </span>
  <a href="https://twitter.com/ScaleUpSaaS">Twitter</a>

</h4>

<p align="center">
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
</p>

## ✨ Features

- **Easily export collections to Excel.** Supercharge your Laravel collections and export them directly to an Excel or CSV document. Exporting has never been so easy.

- **Supercharged exports.** Export queries with automatic chunking for better performance. You provide us the query, we handle the performance. Exporting even larger datasets? No worries, Laravel Excel has your back. You can queue your exports so all of this happens in the background.

- **Supercharged imports.** Import workbooks and worksheets to Eloquent models with chunk reading and batch inserts! Have large files? You can queue every chunk of a file! Your entire import will happen in the background.

- **Export Blade views.** Want to have a custom layout in your spreadsheet? Use a HTML table in a Blade view and export that to Excel.

![banner]()
<br>
# laravel-stream-log => LSL
Easily stream your Laravel application logs to the frontend in real-time using server-sent event (SSE). Stay on top of your application's activity, monitor errors, and debug efficiently without the need moving between screens or page refresh.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


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

Setup config options in `config/lsl.php` file and then add this in your view/layout (usally `layout/app.blade.php`) file:

```php
@include('lsl::view')
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
    streamLogNotify('Invoke stream log via helper 1');
    streamLogNotify('Invoke stream log via helper 2');     
    streamLogNotify('Invoke stream log via helper 3');
}
```


## Configuration

Configuration is done via environment variables or directly in the configuration file (`config/lsl.php`).

## Customizing Notification Library

By default, package uses [noty](https://github.com/needim/noty) for showing notifications. You can customize this by modifying code in `resources/views/vendor/lsl/view.blade.php` file.

## Customizing LSL Events

By default, pacakge uses `stream` event type for streaming response:


```php
LSLFacade::notify($message, $type = 'info', $event = 'message')
```

Notice `$event = 'stream'`. You can customize this, let's say you want to use `UserPurchase` as SSE event type:

```php
use Sarfraznawaz2005\SSE\Facades\SSEFacade;

public function myMethod()
{
    SSEFacade::notify('User purchase plan - step 1', 'info', 'UserPurchase');
    
    // or via helper
    streamLogNotify('User purchase plan - step 1', 'info', 'UserPurchase');
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
