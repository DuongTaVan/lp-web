<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OptionalExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('optional_extras')->truncate();
        $courses = \App\Models\Course::all()->pluck('course_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\OptionalExtra::class, 1)->create([
                'course_id' => $faker->randomElement($courses),
            ]);
        }
    }
}
