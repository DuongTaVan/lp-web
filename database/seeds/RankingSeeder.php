<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class RankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('rankings')->truncate();
        $courses = \App\Models\Course::all()->pluck('course_id')->toArray();
        $category = [1, 2, 3];
        foreach (range(1, 100) as $index) {
            factory(App\Models\Ranking::class, 1)->create([
                'course_id' => $faker->randomElement($courses),
                'category' => $faker->randomElement($category)
            ]);
        }
    }
}
