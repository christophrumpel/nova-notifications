<?php

use Christophrumpel\NovaNotifications\NovaNotification;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(NovaNotification::class, function (Faker $faker) {
    return [
        'notification' => $faker->name,
        'notifiable_type' => $faker->unique()->safeEmail,
        'notifiable_id' => $faker->numberBetween(1, 100),
        'channel' => collect(['twitter', 'email', 'Database'])->random(),
        'failed' => false,
    ];
});
