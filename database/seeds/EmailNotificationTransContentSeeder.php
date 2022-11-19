<?php

use Illuminate\Database\Seeder;

class EmailNotificationTransContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('email_notification_trans_contents')->truncate();
        factory(App\Models\EmailNotificationTransContent::class, 100)->create();
    }
}
