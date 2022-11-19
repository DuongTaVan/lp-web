<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\OptionalExtraMapping::class, function (Faker $faker) {
    return [
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'optional_extra_id' => $faker->numberBetween(1, 100),
    ];
});
