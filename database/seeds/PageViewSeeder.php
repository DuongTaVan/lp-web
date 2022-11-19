<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PageViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('page_views')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\PageView::class, 1)->create([
                'user_id' => $faker->randomElement($users)
            ]);
        }
    }
}
