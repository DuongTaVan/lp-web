<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BoxNotificationTransContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('box_notification_trans_contents')->truncate();
        factory(App\Models\BoxNotificationTransContent::class, 100)->create();
    }
}
