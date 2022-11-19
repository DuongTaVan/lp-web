<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Settlement::class, function (Faker $faker) {
    return [
        'purchase_id' => $faker->numberBetween(1, 100),
        'str_payment_id' => $faker->uuid,
        'currency' => $faker->currencyCode,
        'payment_method' => $faker->numberBetween(1, 3),
        'card_brand' => $faker->creditCardType,
        'payment_amount' => $faker->numerify('######'),
        'status' => $faker->numberBetween(1, 6),
        'approval_failed_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'approval_error_reason' => $faker->randomElement(['card_error', null]),
        'approved_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'approved_amount' => $faker->numerify('######'),
        'capture_failed_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'capture_error_reason' => $faker->randomElement(['card_error', null]),
        'captured_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'captured_amount' => $faker->numerify('######'),
        'cancellation_failed_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'cancellation_error_reason' => $faker->randomElement(['card_error', null]),
        'canceled_at' => $faker->randomElement([$faker->dateTimeThisMonth(), null]),
        'canceled_amount' => $faker->numerify('######'),
    ];
});
