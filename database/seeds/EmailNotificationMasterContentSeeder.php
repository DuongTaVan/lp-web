<?php

use Illuminate\Database\Seeder;

class EmailNotificationMasterContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('email_notification_master_contents')->truncate();
        $sql = "
            START TRANSACTION;
            INSERT INTO `email_notification_master_contents` (`email_notification_master_content_id`, `timing_type`, `title`, `body`, `created_at`, `updated_at`) VALUES (1, 3, '【FunEngage】チケット当選のお知らせ', '先般ご応募いただきましたチケット抽選にてご当選したことをご連絡いたします。\nFunEngageアプリのイベント詳細ページよりご購入手続きをお願いいたします。\n\nご応募商品：　　　　{{tickets.name}}\nご応募者のお名前：　{{name}}　様\nお支払い予定金額：　{{tickets.price}} 円（消費税込み）\n\n\n※本メールアドレスは送信になりますので、本メールにご返信頂いてもお答えできませんのでご了承下さい。\n\nご不明な点や、お困りのことがございましたらお手数ですが以下のメールアドレスにお問い合わせください。\n\nFunEngage お問い合わせ窓口\ncontact@funengage.jp', '2020-12-24 21:10:00', '2020-12-24 21:10:00');
            INSERT INTO `email_notification_master_contents` (`email_notification_master_content_id`, `timing_type`, `title`, `body`, `created_at`, `updated_at`) VALUES (2, 5, '【FunEngage】購入完了', 'ご購入ありがとうございます。\n下記の内容で決済が完了いたしました。\n\nご購入商品：　　　　{{tickets.name}}\nご購入日：　　　　　{{ticket_purchase_histories.purchased_at}}\nご購入者のお名前：　{{name}}　様\nお支払い金額：　　　{{ticket_purchase_histories.payment_amount}} 円（消費税込み）\nお支払い方法：　　　クレジットカード\n\n\n※本メールアドレスは送信になりますので、本メールにご返信頂いてもお答えできませんのでご了承下さい。\n\nご不明な点や、お困りのことがございましたらお手数ですが以下のメールアドレスにお問い合わせください。\n\nFunEngage お問い合わせ窓口\ncontact@funengage.jp', '2020-12-24 21:10:00', '2020-12-24 21:10:00');
            COMMIT;
        ";

        DB::unprepared($sql);
    }
}
