<?php

namespace App\Http\Controllers\Client\Common;

use App\Enums\DBConstant;
use App\Mail\SendMailLappiReportTransferHistory;
use App\Services\Common\SettlementService;
use App\Services\Common\StripeLogService;
use App\Services\Common\TransferHistoryService;
use App\Services\Common\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class StripeController extends Controller
{
    private $settlementService;
    private $transferHistoryService;
    private $stripeLogService;
    private $userService;

    public function __construct()
    {
        $this->stripeLogService = app(StripeLogService::class);
        $this->settlementService = app(SettlementService::class);
        $this->transferHistoryService = app(TransferHistoryService::class);
        $this->userService = app(UserService::class);
    }

    /**
     * Handle a Stripe webhook call.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');
        $endpoint_secret = config('app.stripe_endpoint_secret');
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            // Handle the event
            sleep(5);
            switch ($event->type) {
                case 'charge.refunded':
                    $chargeRefunded = $event->data->object->refunds;
                    $chargeRefunded = $chargeRefunded->object === 'list' ? $chargeRefunded->data[0] : $chargeRefunded;
                    $this->handleChargeRefunded($chargeRefunded);

                    break;
                case 'payment_intent.succeeded':
                    $payment = $event->data->object;
                    $this->handleChargeSuccess($payment);

                    break;
                case 'charge.refund.updated':
                    $chargeRefunded = $event->data->object;
                    $this->handleChargeRefunded($chargeRefunded);

                    break;
                case 'transfer.paid':
                    $transfer = $event->data->object;
                    $this->handleTranfer($transfer);

                    break;
                case 'payout.paid':
                    $payload = $event->data->object;
                    $this->handlePayoutLappiSuccess($payload);

                    break;
                case 'payment_intent.canceled':
                    $paymentIntent = $event->data->object;
                    $this->handlePaymentCancel($paymentIntent);

                    break;
                // ... handle other event types
                default:
                    echo 'Received unknown event type ' . $event->type;
            }

            http_response_code(200);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
    }

    /**
     * Handle a Stripe webhook call.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handleConnectWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');
        $endpoint_secret = config('app.connect_endpoint_secret');
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            // Handle the event
            sleep(5);
            switch ($event->type) {
                case 'payout.paid':
                    $payload = $event->data->object;
                    $this->handlePayoutSuccess($payload);

                    break;
                case 'person.updated':
                    $payload = $event->data->object;
                    $this->handlePersonUpdate($payload);

                    break;
//                case 'payout.failed':
//                    $payload = $event->data->object;
//                    $this->handlePayoutFail($payload);
//
//                    break;
                // ... handle other event types
                default:
                    echo 'Received unknown event type ' . $event->type;
            }

            http_response_code(200);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleChargeRefunded($payload)
    {
        $this->settlementService->updateStatus($payload);

        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleChargeSuccess($payload)
    {
        $this->stripeLogService->addAmount($payload);

        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleTranfer($payload)
    {
//        $this->settlementService->updateStatus($payload);

        return new Response('Webhook Handled', 200);
    }

    /**
     * @param $payload
     * @return Response
     */
    protected function handlePaymentCancel($payload)
    {
        if ($payload['status'] === 'canceled') {
            $this->settlementService->paymentCancel($payload);
        }

        return new Response('Webhook Handled', 200);
    }

    /**
     * @param $payload
     * @return Response
     */
    public function handlePayoutLappiSuccess($payload)
    {
        if ($payload->status === 'paid') {
            $this->stripeLogService->payout($payload);
        }

        return new Response('Webhook Handled', 200);
    }

    /**
     * @param $payload
     * @return Response
     */
    public function handlePayoutSuccess($payload)
    {
        $this->transferHistoryService->updateStatusPayout($payload);

        return new Response('Webhook Handled', 200);
    }

    /**
     * @param $payload
     * @return Response
     */
    public function handlePersonUpdate($payload)
    {
        \Log::debug($payload);
        if ($payload['verification']['document']['front'] && $payload['verification']['status'] !== 'pending') {
            $this->userService->verifyIdentity($payload['id'], $payload['verification']['status']);
        }

        return new Response('Webhook Handled', 200);
    }

    /**
     * @param $payload
     * @return Response
     */
    public function handlePayoutFail($payload)
    {
//        $this->transferHistoryService->updateStatusPayout($payload->id, DBConstant::TRANSFER_HISTORIES_STATUS_FAIL);

        return new Response('Webhook Handled', 200);
    }
}
