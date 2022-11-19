<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\OptionalExtra::class, function (Faker $faker) {
    return [
        'course_id' => $faker->numberBetween(1, 100),
        'title' => $faker->title(),
        'price' => $faker->numerify('#####'),
    ];
});
