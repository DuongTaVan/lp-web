<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Favorite::class, function (Faker $faker) {
    return [
        'from_user_id' => $faker->numberBetween(1, 100),
        'course_schedule_id' => $faker->numberBetween(1, 100),
    ];
});
