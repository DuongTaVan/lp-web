<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CourseScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('course_schedules')->truncate();
        $courses = \App\Models\Course::all()->pluck('course_id')->toArray();
        $status = [0, 1, 2, 3, 9];
        $type = [1, 2, 3];
        foreach (range(1, 100) as $index) {
            factory(App\Models\CourseSchedule::class, 1)->create([
                'course_id' => $faker->randomElement($courses),
                'status' => $faker->randomElement($status),
                'type' => $faker->randomElement($type),
            ]);
        }
    }
}
