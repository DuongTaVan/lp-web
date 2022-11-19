<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Cash::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'deposit_amount' => $faker->numerify('#####'),
        'deposit_reason' => $faker->numberBetween(0, 1),
        'withdrawal_amount' => $faker->numerify('#######'),
        'withdrawal_reason' => $faker->numberBetween(0, 1),
        'balance' => $faker->numerify('#######'),
        'transacted_at' => $faker->dateTimeThisMonth(),
    ];
});
