<?php

namespace Christophrumpel\NovaNotifications;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Christophrumpel\NovaNotifications\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/nova-notifications.php' => config_path('nova-notifications.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-notifications');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-notifications'),
        ], 'nova-notifications-lang');

        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/nova-notifications'));

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->app->booted(function () {
            $this->routes();
        });

        Event::listen('Illuminate\Notifications\Events\NotificationSent', function ($event) {
            NovaNotification::create([
                'notification' => get_class($event->notification),
                'notifiable_type' => get_class($event->notifiable),
                'notifiable_id' => $event->notifiable->id,
                'channel' => $event->channel,
                'failed' => false,
            ]);
        });

        Event::listen('Illuminate\Notifications\Events\NotificationFailed', function ($event) {
            NovaNotification::create([
                'notification' => get_class($event->notification),
                'notifiable_type' => get_class($event->notifiable),
                'notifiable_id' => $event->notifiable->id,
                'channel' => $event->channel,
                'failed' => true,
            ]);
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-notifications')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
