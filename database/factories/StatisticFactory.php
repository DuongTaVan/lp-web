<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Statistic::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 100),
        'target_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        '365_days_ago' => $faker->dateTimeThisYear()->format('Y-m-d'),
        'total_sales' => $faker->numerify('#####'),
        'total_sales_ly' => $faker->numerify('#####'),
        'course_sales' => $faker->numerify('#####'),
        'course_sales_ly' => $faker->numerify('#####'),
        'extension_sales' => $faker->numerify('#####'),
        'extension_sales_ly' => $faker->numerify('#####'),
        'option_sales' => $faker->numerify('#####'),
        'option_sales_ly' => $faker->numerify('#####'),
        'question_sales' => $faker->numerify('#####'),
        'question_sales_ly' => $faker->numerify('#####'),
        'gift_sales' => $faker->numerify('#####'),
        'gift_sales_ly' => $faker->numerify('#####'),
        'sales_commissions' => $faker->numerify('#####'),
        'sales_commissions_ly' => $faker->numerify('#####'),
        'system_commissions' => $faker->numerify('#####'),
        'system_commissions_ly' => $faker->numerify('#####'),
        'num_of_applicants' => $faker->numberBetween(1, 100),
        'num_of_applicants_ly' => $faker->numberBetween(1, 100),
        'num_of_courses' => $faker->numberBetween(1, 100),
        'num_of_courses_ly' => $faker->numberBetween(1, 100),
        'streaming_minutes' => $faker->numberBetween(1, 999),
        'streaming_minutes_ly' => $faker->numberBetween(1, 999),
        'teacher_profit_exc_tax' => $faker->numerify('#####'),
        'teacher_profit_exc_tax_ly' => $faker->numerify('#####'),
    ];
});
