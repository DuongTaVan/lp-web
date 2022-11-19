<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\BankAccount::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 1000),
        'bank_name' => Str::random(10),
        'branch_name' => Str::random(10),
        'account_type' => $faker->numberBetween(1, 3),
        'account_number' => Str::random(7),
        'account_name' => Str::random(10),
    ];
});
