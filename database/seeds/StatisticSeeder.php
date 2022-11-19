<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('statistics')->truncate();
        $categories = \App\Models\Category::all()->pluck('category_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\Statistic::class, 1)->create([
                'category_id' => $faker->randomElement($categories),
            ]);
        }
    }
}
