<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\UserPoint::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'deposit_points' => $faker->numerify('#####'),
        'deposit_reason' => $faker->numberBetween(1, 2),
        'withdrawal_points' => $faker->numerify('#####'),
        'withdrawal_reason' => $faker->numberBetween(1, 2),
        'points_balance' => $faker->numerify('#####'),
        'transacted_at' => $faker->dateTimeThisMonth(),
        'consumed_points' => $faker->numerify('#####'),
        'is_consumed' => $faker->numberBetween(0, 1),
        'expiration_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'is_processed' => $faker->numberBetween(0, 1),
        'expired_user_point_id' => $faker->numberBetween(0, 100),
    ];
});
