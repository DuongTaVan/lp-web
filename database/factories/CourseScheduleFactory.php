<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\CourseSchedule::class, function (Faker $faker) {
    return [
        'course_id' => $faker->numberBetween(1, 20),
        'type' => $faker->numberBetween(1, 2),
        'parent_course_schedule_id' => $faker->numberBetween(1, 100),
        'status' => $faker->randomElement([0, 1, 2, 3, 9]),
        'title' => $faker->title(),
        'subtitle' => $faker->title(),
        'body' => $faker->text(1000),
        'flow' => $faker->text(1000),
        'cautions' => $faker->text(1000),
        'minutes_required' => $faker->numberBetween(1, 999),
        'price' => $faker->numerify('#####'),
        'fixed_num' => $faker->numberBetween(1, 999),
        'num_of_applicants' => $faker->numberBetween(1, 999),
        'purchase_deadline' => $faker->dateTime(),
        'start_datetime' => $faker->dateTimeThisMonth(),
        'end_datetime' => $faker->dateTimeThisMonth(),
        'agora_channel' => $faker->md5,
        'agora_token' => $faker->md5,
        'canceled_at' => $faker->dateTimeThisMonth(),
    ];
});
