<?php

declare(strict_types=1);

use App\Enums\DBConstant;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'login_type' => $faker->randomElement([DBConstant::LOGIN_TYPE_EMAIL]),
        'user_type' => $faker->numberBetween(1, 2),
        'teacher_type' => $faker->numberBetween(1, 3),
        'teacher_category_skills' => $faker->numberBetween(0, 1),
        'teacher_category_consultation' => $faker->numberBetween(0, 1),
        'teacher_category_fortunetelling' => $faker->numberBetween(0, 1),
        'corporation_id' => $faker->numberBetween(1, 100),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt(12345678),
        'nickname' => Str::random(10),
        'last_name_kanji' => $faker->name,
        'first_name_kanji' => $faker->name,
        'last_name_kana' => $faker->lastKanaName,
        'first_name_kana' => $faker->firstKanaName,
        'date_of_birth' => $faker->dateTimeThisYear()->format('Y-m-d'),
        'sex' => $faker->numberBetween(1, 2),
        'cash_balance' => $faker->numerify('######'),
        'points_balance' => $faker->numerify('######'),
        'identity_verification_status' => $faker->numberBetween(1, 2),
        'business_card_verification_status' => $faker->numberBetween(1, 2),
        'nda_status' => $faker->numberBetween(1, 2),
        'registration_status' => $faker->numberBetween(1, 2),
        'last_login' => $faker->dateTime,
        'is_archived' => $faker->numberBetween(0, 1),
        'name_use' => $faker->numberBetween(0, 1),
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
    ];
});
