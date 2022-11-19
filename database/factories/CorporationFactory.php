<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Corporation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'name_kana' => $faker->name,
        'address' => $faker->address,
        'establishment_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'last_name_kanji' => $faker->lastName,
        'first_name_kanji' => $faker->firstName,
        'last_name_kana' => $faker->lastName,
        'first_name_kana' => $faker->firstName,
        'is_archived' => $faker->numberBetween(1, 2),
    ];
});
