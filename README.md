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
Then publish the config file(optional):
 ``` bash
php artisan vendor:publish --provider="Christophrumpel\NovaNotifications\ToolServiceProvider"
```
 In there, you can define where to look for the Notification classes, as well as the notifiable models.
 ```php
 <?php
 return [
     /*
      * The namespaces you want to check for Notification classes.
      */
     'notifiableNamespaces' => [
         'App',
     ],
     /*
      * The namespaces you want to check for Notifiable classes.
      */
     'notificationNamespaces' => [
         'App\Notifications',
         'Illuminate',
     ],
 ];
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

You also need to run `php artisan migrate` on your Laravel application so that the new notifications table will be created.

# Usage

After installing the tool, you should see the new sidebar navigation item for `Notifications`.

## Overview

On the `Overview` page you can see all of the sent and failed notifications. This only works for notifications sent after installing this package. 

Usually, only the notifications sent through the `database` channel will be stored in the database. This package comes with a new `nova_notifications` table, where `all` of them get stored.

## Send

On the `Send` page you can see all of your created notification classes.

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
