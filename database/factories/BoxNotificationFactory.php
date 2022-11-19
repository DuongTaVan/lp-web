<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\BoxNotification::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'box_notification_master_content_id' => $faker->numberBetween(1, 10),
        'box_notification_trans_content_id' => $faker->numberBetween(1, 10),
        'is_read' => $faker->numberBetween(0, 1),
        'read_at' => $faker->dateTimeThisMonth(),
    ];
});
