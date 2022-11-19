<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\PurchaseDetail::class, function (Faker $faker) {
    $unitPrice = $faker->numerify('######');
    $quantity = $faker->numberBetween(1, 10);
    $total = $unitPrice * $quantity;

    return [
        'purchase_id' => $faker->numberBetween(1, 100),
        'item' => $faker->numberBetween(1, 5),
        'course_schedule_id' => $faker->numberBetween(1, 100),
        'optional_extra_id' => $faker->numberBetween(1, 100),
        'question_ticket_id' => $faker->numberBetween(1, 100),
        'gift_id' => $faker->numberBetween(1, 100),
        'unit_price' => $unitPrice,
        'quantity' => $quantity,
        'total_amount' => $total,
        'canceled_at' => $faker->dateTimeThisMonth(),
    ];
});
