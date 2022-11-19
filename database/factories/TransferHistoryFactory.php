<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\TransferHistory::class, function (Faker $faker) {
    $withdrawalAmount = $faker->numerify('#####');
    $transferFee = $faker->numerify('####');

    return [
        'cash_id' => $faker->numberBetween(0, 100),
        'status' => $faker->numberBetween(0, 1),
        'withdrawal_amount' => $withdrawalAmount,
        'transfer_fee' => $transferFee,
        'transfer_amount' => $withdrawalAmount - $transferFee,
        'scheduled_date' => $faker->date(),
        'transferred_at' => $faker->dateTimeBetween($startDate = '-10days', $endDate = 'now', $timezone = null),
    ];
});
