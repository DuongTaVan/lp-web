<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OptionalExtraMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('optional_extra_mappings')->truncate();
        $courseSchedules = \App\Models\CourseSchedule::all()->pluck('course_schedule_id')->toArray();
        $optionalExtras = \App\Models\OptionalExtra::all()->pluck('optional_extra_id')->toArray();
        $faker->unique(true);
        foreach (range(1,100) as $index) {
            factory(App\Models\OptionalExtraMapping::class, 1)->create([
                'course_schedule_id' => $faker->unique()->randomElement($courseSchedules),
                'optional_extra_id' => $faker->randomElement($optionalExtras),
            ]);
        }
    }
}
