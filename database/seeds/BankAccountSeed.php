<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BankAccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('bank_accounts')->truncate();
        $users = \App\Models\User::all()->pluck('user_id')->toArray();
        foreach (range(1,50) as $index) {
            factory(App\Models\BankAccount::class, 1)->create([
                'user_id' => $faker->randomElement($users)
            ]);
        }
    }
}
