<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Applicant::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'is_lappi_new' => $faker->numberBetween(0, 1),
        'is_lappi_repeater' => $faker->numberBetween(0, 1),
        'lappi_repeat_count' => $faker->numberBetween(0, 50),
        'is_teacher_new' => $faker->numberBetween(0, 1),
        'is_teacher_repeater' => $faker->numberBetween(0, 1),
        'teacher_repeat_count' => $faker->numberBetween(0, 50),
        'canceled_at' => $faker->dateTime,
        'is_reviewed' => $faker->numberBetween(0, 1),
    ];
});
