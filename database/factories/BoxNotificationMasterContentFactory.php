<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\BoxNotificationMasterContent::class, function (Faker $faker) {
    return [
        'timing_type' => $faker->numberBetween(1, 99),
        'title' => $faker->title(),
        'body' => $faker->realText(),
    ];
});
