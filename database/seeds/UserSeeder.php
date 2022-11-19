<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->truncate();
        factory(App\Models\User::class, 100)->create()->each(function ($user): void {
            factory(App\Models\BankAccount::class, 3)->create(['user_id' => $user->user_id]);
            factory(App\Models\ImagePath::class, 3)->create(['user_id' => $user->user_id]);
        });
    }
}
