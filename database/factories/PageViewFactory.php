<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\PageView::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'view_count' => $faker->numberBetween(0, 9),
        'is_top_page' => $faker->numberBetween(0, 1),
        'is_skills' => $faker->numberBetween(0, 1),
        'is_consultation' => $faker->numberBetween(0, 1),
        'is_fortunetelling' => $faker->numberBetween(0, 1),
        'to_user_id' => $faker->numberBetween(1, 100),
        'to_course_schedule_id' => $faker->numberBetween(1, 100),
        'viewed_at' => $faker->dateTimeThisMonth(),
    ];
});
