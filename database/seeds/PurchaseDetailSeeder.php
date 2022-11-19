<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PurchaseDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table('purchase_details')->truncate();
        $purchases = \App\Models\Purchase::all()->pluck('purchase_id')->toArray();
        $courseSchedules = \App\Models\CourseSchedule::all()->pluck('course_schedule_id')->toArray();
        $optionalExtras = \App\Models\OptionalExtra::all()->pluck('optional_extra_id')->toArray();
        $questionTickets = \App\Models\QuestionTicket::all()->pluck('question_ticket_id')->toArray();
        $gifts = \App\Models\Gift::all()->pluck('gift_id')->toArray();
        foreach (range(1,100) as $index) {
            factory(App\Models\PurchaseDetail::class, 1)->create([
                'purchase_id' => $faker->randomElement($purchases),
                'course_schedule_id' => $faker->randomElement($courseSchedules),
                'optional_extra_id' => $faker->randomElement($optionalExtras),
                'question_ticket_id' => $faker->randomElement($questionTickets),
                'gift_id' => $faker->randomElement($gifts),
            ]);
        }
    }
}
