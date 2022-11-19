<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\GiftTippingHistory::class, function (Faker $faker) {
    return [
        'from_user_id' => $faker->numberBetween(1, 100),
        'to_user_id' => $faker->numberBetween(1, 100),
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'points_equivalent' => $faker->numerify('#####'),
        'tipped_at' => $faker->dateTimeThisMonth(),
    ];
});
