<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Follow::class, function (Faker $faker) {
    return [
        'from_user_id' => $faker->numberBetween(1, 100),
        'to_user_id' => $faker->numberBetween(1, 100),
        'teacher_repeat_count' => $faker->numberBetween(1, 50),
        'last_purchased_at' => $faker->dateTimeThisMonth(),
    ];
});
