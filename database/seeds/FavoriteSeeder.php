<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('favorites')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        $courseSchedules = \App\Models\CourseSchedule::all()->pluck('course_schedule_id')->toArray();
        $faker->unique(true);
        foreach (range(1,100) as $index) {
            factory(App\Models\Favorite::class, 1)->create([
                'from_user_id' => $faker->unique()->randomElement($users),
                'course_schedule_id' => $faker->randomElement($courseSchedules),
            ]);
        }
    }
}
