<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\QuestionTicket::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'points_equivalent' => $faker->numerify('#####'),
        'status' => $faker->numberBetween(0, 1),
    ];
});
