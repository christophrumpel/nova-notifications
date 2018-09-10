# A Laravel Nova tool overview and handle Laravel Notifications

With this [Nova](https://nova.laravel.com) tool:
- You can overview all sent and failed notifications.
- You can send out notifications.
- All sent or failed notifications will be stores in the database.


![screenshot of nova notifications overview](/images/screenshot_overview.png)
![screenshot of nova notifications send](/images/screenshot_send.png)


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

After installing the tool you should see the new sidebar navigation item for `Notificaitons`.

## Overview

On the `Overview` page you can see all of the sent and failed notifications. This only works for notifications sent after installing this package. 

Normally only the notifications sent through the `database` channel will be stored in the database. This packages comes with a new `nova_notifications` table, where `all` of them get stored.

## Send

On the `Send` page you can see all of your created notification classes. This only works of you have selected the correct namespace for your stored notifications in the config file. Normally, they are stored under `App\Notifications`.

If you don't see a newly created notification class, try running `compoer dump-autoload`.

### Parameters

Since you notifications often depend on parameters, this package tries to help you with that. All found constructor parameters, will be shown when you try to send a notification. If one of the dependencies is an Eloquent Model, you will get a list with all of the items to choose from.

![screenshot of nova notifications send](/images/screenshot_send.png)

If you want to create a new notification with custom objects, then this approach will not work for now. If you have a custom use-case, let me know about it and we can think of a solution.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.