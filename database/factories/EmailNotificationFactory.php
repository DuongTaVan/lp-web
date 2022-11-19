<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\EmailNotification::class, function (Faker $faker) {
    return [
        'to_email' => $faker->email,
        'title' => $faker->title(),
        'body' => $faker->text(1000),
        'scheduled_at' => $faker->dateTimeThisMonth(),
        'status' => $faker->numberBetween(0, 2),
        'sent_at' => now()
    ];
});
