<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BoxNotificationMasterContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('box_notification_master_contents')->truncate();
        factory(App\Models\BoxNotificationMasterContent::class, 100)->create();
    }
}
