<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        \DB::table('user_points')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\UserPoint::class, 1)->create([
                'user_id' => $faker->randomElement($users)
            ]);
        }
    }
}
