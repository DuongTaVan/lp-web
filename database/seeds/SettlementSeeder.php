<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SettlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('settlements')->truncate();
        $purchases = \App\Models\Purchase::all()->pluck('purchase_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\Settlement::class, 1)->create([
                'purchase_id' => $faker->randomElement($purchases),
            ]);
        }
    }
}
