<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Gift::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'price' => $faker->numerify('#####'),
        'points_equivalent' => $faker->numerify('####'),
        'image_url' => 'https://s3-appname-jp.s3.ap-northeast-1.amazonaws.com/courses/6/000000000061568564639.png',
        'display_order' => $faker->numberBetween(1, 3),
    ];
});
