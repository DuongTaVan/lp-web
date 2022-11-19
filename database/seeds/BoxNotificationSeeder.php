<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BoxNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('box_notifications')->truncate();
        $masterId = \App\Models\BoxNotificationMasterContent::all()->pluck('box_notification_trans_content_id')->toArray();
        $transId = \App\Models\BoxNotificationTransContent::all()->pluck('box_notification_master_content_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\BoxNotification::class, 1)->create([
                'box_notification_master_content_id' => $faker->randomElement($masterId),
                'box_notification_trans_content_id' => $faker->randomElement($transId),
            ]);
        }
    }
}
