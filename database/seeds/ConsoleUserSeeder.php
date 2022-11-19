<?php

use Illuminate\Database\Seeder;

class ConsoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('console_users')->truncate();
        factory(App\Models\ConsoleUser::class, 1)->create([
            'email' => 'admin@fabbi.com.vn',
            'password' => bcrypt(12345678),
            'is_archived' => 0
        ]);
    }
}
