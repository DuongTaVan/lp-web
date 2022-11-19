<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(App\Models\ImagePath::class, function (Faker $faker) {
    $userId = $faker->numberBetween(1, 100);

    return [
        'type' => $faker->numberBetween(1, 3),
        'user_id' => $faker->numberBetween(1, 3),
        'course_id' => $faker->numberBetween(1, 10),
        'file_name' => '20170213_011209.jpg',
        'dir_path' => 'test/',
        'image_url' => 'https://s3-appname-jp.s3.ap-northeast-1.amazonaws.com/courses/6/000000000061568564639.png',
        'status' => $faker->numberBetween(0, 2),
        'display_order' => $faker->numberBetween(1, 50),
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
    ];
});
