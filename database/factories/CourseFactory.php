<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Course::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'type' => $faker->numberBetween(1, 3),
        'parent_course_id' => $faker->numberBetween(1, 100),
        'category_id' => $faker->numberBetween(1, 15),
        'status' => $faker->randomElement([0, 1]),
        'title' => $faker->title(),
        'subtitle' => $faker->title(),
        'body' => $faker->text(1000),
        'flow' => $faker->text(1000),
        'cautions' => $faker->text(1000),
        'minutes_required' => $faker->numberBetween(1, 999),
        'price' => $faker->randomDigit,
        'fixed_num' => $faker->numberBetween(1, 999),
        'dist_method' => $faker->numberBetween(1, 2),
        'rating' => $faker->numberBetween(1, 10),
        'num_of_ratings' => $faker->numberBetween(1, 0),
        'approval_status' => $faker->numberBetween(0, 2),
        'is_archived' => $faker->numberBetween(0,1)
    ];
});
