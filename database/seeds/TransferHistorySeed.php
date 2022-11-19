<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TransferHistorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('transfer_histories')->truncate();
        $cashes = \App\Models\Cash::all()->pluck('cash_id')->toArray();
        foreach (range(1,15) as $index) {
            factory(App\Models\TransferHistory::class, 1)->create([
                'cash_id' => $faker->randomElement($cashes)
            ]);
        }
    }
}
