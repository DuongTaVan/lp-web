<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('corporations')->truncate();
        factory(App\Models\Corporation::class, 100)->create();
    }
}
