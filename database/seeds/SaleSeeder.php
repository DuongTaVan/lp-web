<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('sales')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        $courseSchedules = \App\Models\CourseSchedule::all()->pluck('course_schedule_id')->toArray();
        $cashes = \App\Models\Cash::all()->pluck('cash_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\Sale::class, 1)->create([
                'user_id' => $faker->randomElement($users),
                'course_schedule_id' => $faker->randomElement($courseSchedules),
                'cash_id' => $faker->randomElement($cashes),
            ]);
        }
    }
}
