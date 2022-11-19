<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Ranking::class, function (Faker $faker) {
    return [
        'category' => $faker->numberBetween(1, 3),
        'target_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'course_id' => $faker->numberBetween(1, 20),
        'num_of_applicants' => $faker->numberBetween(1, 999),
    ];
});
