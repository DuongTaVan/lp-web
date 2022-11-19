<?php

namespace App\Traits;


use App\Enums\DBConstant;
use App\Mail\SendMailLappiLackMoneyStripe;
use App\Mail\TransferHistoryMail;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

/**
 * Trait StripeTrait
 * @package App\Traits
 */
trait StripeTrait
{
    private $stripeClient;

    /**
     * @param $payout
     * @return \Stripe\Payout
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function tranferOut($payout)
    {
        if (!$payout->transfer_amount || !$payout->str_connect_id) {
            return null;
        }

        if (!$this->stripeClient) {
            $this->stripeClient = new StripeClient(config('app.stripe_secret'));
        }

//        Mail::to($payout->email)->queue(new TransferHistoryMail($payout, $payout->user->full_name));

        return $this->stripeClient->payouts->create([
            'amount' => $payout->transfer_amount,
            'currency' => 'jpy',
            'description' => 'Payout from LAPPI'
        ], [
            'stripe_account' => $payout->str_connect_id
        ]);
    }

    private function errorPayoutLappi(\Exception $error, TransferHistory $tf)
    {
        try {
            \Log::debug($error);
            $tf->update([
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                'failure_code' => $error->getJsonBody()['error']['code'] ?? 'other',
                'failed_at' => now()
            ]);

            $this->sendEvent('realtime', [
                'url' => '/portal/transfer-histories',
                'screen' => 'TRANSFER',
                'id' => $tf->id
            ]);

            Mail::to(config('app.to_mail_report'))->queue(new SendMailLappiLackMoneyStripe());
        } catch (\Exception $e) {}
    }
}
