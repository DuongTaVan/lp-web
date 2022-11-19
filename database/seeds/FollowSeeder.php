<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('follows')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\Follow::class, 1)->create([
                'from_user_id' => $faker->unique()->randomElement($users),
                'to_user_id' => $faker->randomElement($users),
            ]);
        }
    }
}
