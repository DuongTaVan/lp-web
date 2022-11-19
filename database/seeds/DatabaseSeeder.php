<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ConsoleUserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseScheduleSeeder::class);
        $this->call(ApplicantSeeder::class);
        $this->call(ImagePathSeeder::class);
        $this->call(BankAccountSeed::class);
        $this->call(CashSeeder::class);
        $this->call(TransferHistorySeed::class);
        $this->call(StatisticSeeder::class);
        $this->call(EmailNotificationMasterContentSeeder::class);
        $this->call(BoxNotificationTransContentSeeder::class);
        $this->call(BoxNotificationMasterContentSeeder::class);
        $this->call(BoxNotificationSeeder::class);
        $this->call(FollowSeeder::class);
        $this->call(RankingSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(StatisticSeeder::class);
        $this->call(UserPointSeeder::class);
        $this->call(GiftTippingHistorySeeder::class);
        $this->call(OptionalExtraSeeder::class);
        $this->call(OptionalExtraMappingSeeder::class);
        $this->call(CorporationSeeder::class);
        $this->call(EmailNotificationTransContentSeeder::class);
        $this->call(EmailNotificationSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(GiftSeeder::class);
        $this->call(PageViewSeeder::class);
        $this->call(PurchaseSeeder::class);
        $this->call(PurchaseDetailSeeder::class);
        $this->call(QuestionTicketSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(SettlementSeeder::class);
    }
}
