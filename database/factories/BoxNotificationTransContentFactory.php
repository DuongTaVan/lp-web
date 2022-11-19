<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\BoxNotificationTransContent::class, function (Faker $faker) {
    return [
        'title' => $faker->title(),
        'body' => $faker->realText(),
        'to_type' => $faker->numberBetween(1, 2),
        'scheduled_at' => $faker->dateTimeThisMonth(),
        'is_delivered' => $faker->numberBetween(0, 1),
        'delivered_at' => $faker->dateTimeThisMonth(),
    ];
});
