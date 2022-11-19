<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\EmailNotificationTransContent::class, function (Faker $faker) {
    $toUserIds = $faker->numberBetween(1, 100) . ',' . $faker->numberBetween(1, 100) . ',' . $faker->numberBetween(1, 100);

    return [
        'title' => $faker->title(),
        'body' => $faker->realText(),
        'to_user_ids' => $toUserIds,
        'scheduled_at' => $faker->dateTimeThisMonth(),
        'is_delivered' => $faker->numberBetween(0, 1),
        'delivered_at' => $faker->dateTimeThisMonth(),
    ];
});
