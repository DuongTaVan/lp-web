<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class EmailNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('email_notifications')->truncate();
        factory(App\Models\EmailNotification::class, 100)->create();
    }
}
