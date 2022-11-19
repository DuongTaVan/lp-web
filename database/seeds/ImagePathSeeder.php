<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ImagePathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('image_paths')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        $courses = \App\Models\Course::all()->pluck('course_id')->toArray();
        foreach (range(1, 50) as $index) {
            factory(App\Models\ImagePath::class, 1)->create([
                'user_id' => $faker->randomElement($users),
                'dir_path' => sprintf("users/%s/" . \App\Enums\Constant::DIRECTORY_PATH['user'] . "/", $faker->randomElement($users)),
                'course_id' => $faker->randomElement($courses),
            ]);
        }
    }
}
