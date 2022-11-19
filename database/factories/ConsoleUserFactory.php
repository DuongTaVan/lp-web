<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\ConsoleUser::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt(12345678),
        'remember_token' => null,
        'is_archived' => $faker->numberBetween(0, 1),
    ];
});
