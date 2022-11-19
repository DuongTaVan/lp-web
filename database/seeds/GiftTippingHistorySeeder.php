<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class GiftTippingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('gift_tipping_histories')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        $courseSchedule = \App\Models\CourseSchedule::all()->pluck('course_schedule_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\GiftTippingHistory::class, 1)->create([
                'from_user_id' => $faker->randomElement($users),
                'to_user_id' => $faker->randomElement($users),
                'course_schedule_id' => $faker->randomElement($courseSchedule),
            ]);
        }
    }
}
