<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Purchase::class, function (Faker $faker) {
    $subTotal = $faker->numerify('######');
    $discount = $faker->numerify('######');
    $total = $subTotal - $discount;

    return [
        'order_no' => $faker->bothify('##?-##?-##?'),
        'user_id' => $faker->numberBetween(1, 100),
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'status' => $faker->numberBetween(0, 3),
        'subtotal_amount' => $subTotal,
        'discount_amount' => $discount,
        'total_amount' => $total,
        'purchased_at' => $faker->dateTimeThisMonth(),
        'canceled_at' => $faker->dateTimeThisMonth(),
    ];
});
