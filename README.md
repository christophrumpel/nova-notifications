# A Laravel Nova Tool for Handling Laravel Notifications

With this [Nova](https://nova.laravel.com) tool:
- You can overview all sent and failed notifications.
- You can send out notifications.
- All sent or failed notifications will be stored in the database.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/christophrumpel/nova-notifications.svg?style=flat-square)](https://packagist.org/packages/christophrumpel/nova-notifications)

![screenshot of nova notifications overview](/images/screenshot_overview.png)
![screenshot of nova notifications send](/images/screenshot_send.png)

## Requirements

In order to use this package, you need to have an installation of Laravel with Laravel nova setup.

## Installation

First install the  [Nova](https://nova.laravel.com) package via composer:

```bash
composer require christophrumpel/nova-notifications
```

Next up, you must register the tool via the `tools` method of the `NovaServiceProvider`.

```php
// inside app/Providers/NovaServiceProvder.php

// ...

public function tools()
{
    return [
        // ...
        new \Christophrumpel\NovaNotifications\NovaNotifications()
    ];
}
```

Then publish the config file:

``` bash
php artisan vendor:publish --provider="Christophrumpel\NovaNotifications\ToolServiceProvider"
```

In there, you can define the namespaces of you Eloquent Models and your Notifications. The models will be used to provide you with a list of notifiable models. The notifications will be shown as a list when you want to send one.

```php
<?php

return [

    /*
     * The namespace of your Eloquent models.
     * They will be used to check for notifiable models.
     */
    'modelNamespace' => 'App',

    /*
     * The namespace of your Laravel notifications.
     * They will be used to send out notifications.
     */
    'notificationNamespace' => 'App\Notifications',

];

```

# Usage

After installing the tool, you should see the new sidebar navigation item for `Notifications`.

## Overview

On the `Overview` page you can see all of the sent and failed notifications. This only works for notifications sent after installing this package. 

Usually, only the notifications sent through the `database` channel will be stored in the database. This package comes with a new `nova_notifications` table, where `all` of them get stored.

## Send

On the `Send` page you can see all of your created notification classes. This only works if you have selected the correct namespace for your stored notifications in the config file. Normally, they are stored under `App\Notifications`.

If you don't see a newly created notification class, try running `composer dump-autoload`.

### Parameters

Since you notifications often depend on parameters, this package tries to help you with that. All found constructor parameters will be shown when you try to send a notification. If one of the dependencies is an Eloquent Model, you will get a list with all of the items to choose from.

![screenshot of nova notifications send](/images/screenshot_parameters.png)

If you want to create a new notification with custom objects, then this approach will not work for now. If you have a custom use-case, let me know about it, and we can think of a solution.

### Testing

``` bash
phpunit tests
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Security

If you discover any security-related issues, please email me at c.rumpel@kabsi.at instead of using the issue tracker.

## License

The MIT License (MIT).