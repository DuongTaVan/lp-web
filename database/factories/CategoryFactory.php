<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    return [
        'type' => $faker->numberBetween(1, 3),
        'name' => $faker->name,
        'display_order' => $faker->numberBetween(1, 3),
    ];
});
