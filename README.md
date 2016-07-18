# Add Correlational ID capability to Laravel

[![Latest Stable Version](https://poser.pugx.org/devitek/laravel-correlational-id/v/stable)](https://packagist.org/packages/devitek/laravel-correlational-id)
[![Total Downloads](https://poser.pugx.org/devitek/laravel-correlational-id/downloads)](https://packagist.org/packages/devitek/laravel-correlational-id)
[![Latest Unstable Version](https://poser.pugx.org/devitek/laravel-correlational-id/v/unstable)](https://packagist.org/packages/devitek/laravel-correlational-id)
[![License](https://poser.pugx.org/devitek/laravel-correlational-id/license)](https://packagist.org/packages/devitek/laravel-correlational-id)

## Installing

```
composer require devitek/laravel-correlational-id
```

## Add support to HTTP messages

Add this line to your `app/Kernel.php` file :

```php
<?php

// ...

    protected $middleware = [
        CheckForMaintenanceMode::class,
        CorrelationalId::class,
        // ...
    ];

// ...
```

## Add processor to Monolog

Add this line to your `app/Kernel.php` file :

```php
<?php

// ...

    protected $middleware = [
        CheckForMaintenanceMode::class,
        CorrelationalId::class,
        CorrelationalIdMonolog::class,
        // ...
    ];

// ...
```

## Add tag context to Sentry

Add this line to your `app/Kernel.php` file :

```php
<?php

// ...

    protected $middleware = [
        CheckForMaintenanceMode::class,
        CorrelationalId::class,
        CorrelationalIdSentry::class,
        // ...
    ];

// ...
```

## How it works ?

### HTTP message

When your app receive an HTTP message it will try to read the `X-Correlational-Id` header from the request or generate a new one
and add the same one to the response. It will also attach it as a request attribute.

### Monolog

It will try to get the correlational ID from the request attributes and push a processor into monolog.

### Sentry

It will try to get the correlational ID from the request attributes and add a tag context to the sentry client.

Enjoy it ! Feel free to fork :) !
