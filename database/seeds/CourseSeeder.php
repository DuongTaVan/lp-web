<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('courses')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        $categories = \App\Models\Category::all()->pluck('category_id')->toArray();
        $status = [0, 1];
        $approvalStatus = [0, 1, 2];
        foreach (range(1,20) as $index) {
            factory(App\Models\Course::class, 1)->create([
                'user_id' => $faker->randomElement($users),
                'category_id' => $faker->randomElement($categories),
                'status' => $faker->randomElement($status),
                'approval_status' => $faker->randomElement($approvalStatus),
            ]);
        }
    }
}
