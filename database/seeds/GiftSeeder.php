<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('gifts')->truncate();
        factory(App\Models\Gift::class, 100)->create();
    }
}
