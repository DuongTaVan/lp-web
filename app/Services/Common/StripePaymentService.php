<?php


namespace App\Services\Common;

use App\Models\User;
use App\Repositories\BankMasterRepository;
use App\Repositories\CourseRepository;
use App\Repositories\PromotionalMessageRepository;
use App\Repositories\StripeLogRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\ApiErrorException;
use Stripe\Refund;
use Stripe\Stripe;
use Stripe\StripeClient;
use App\Enums\ErrorType;
use Stripe\Exception\CardException;

class StripePaymentService extends BaseService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    protected $stripeClient;
    protected $courseRepository;
    protected $bankMasterRepository;
    protected $stripeLogRepository;


    /**
     * @return string
     */
    public function repository()
    {
        return PromotionalMessageRepository::class;
    }

    /**
     * RepeaterCheckService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        Stripe::setApiKey(config('app.stripe_secret'));
        $this->stripeClient = new StripeClient(config('app.stripe_secret'));
        $this->userRepository = app(UserRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->bankMasterRepository = app(BankMasterRepository::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
    }

    /**
     * @param $user
     * @return mixed
     * @throws ApiErrorException
     */
    public function createCustomer($user)
    {
        $stripeCustomer = \Stripe\Customer::create([
            'email' => $user->email,
        ]);
        return $this->userRepository->update([
            'str_customer_id' => $stripeCustomer->id,
        ], $user->user_id);
    }

    public function checkStripeCustomer($strCustomerId)
    {
        return $this->stripeClient->customers->retrieve($strCustomerId);
    }

    /**
     * @param bool $all
     * @param int|null $userId
     * @return array
     * @throws ApiErrorException
     */
    public function getCreditCard(bool $all = false, int $userId = null)
    {
        if ($userId) {
            $userLogged = $this->userRepository->find($userId);
        } else {
            $userLogged = auth('client')->user();
        }

        if (!$userLogged->str_customer_id) {
            return [
                'success' => true,
                'data' => null,
            ];
        }
        if ($this->checkStripeCustomer($userLogged->str_customer_id) && $this->checkStripeCustomer($userLogged->str_customer_id)->deleted) {
            return [
                'success' => true,
                'data' => null,
            ];
        }

        $paymentMethodStripe = \Stripe\PaymentMethod::all([
            'customer' => $userLogged->str_customer_id,
            'type' => 'card',
        ]);

        if (empty($paymentMethodStripe['data'])) {
            return [
                'success' => true,
                'data' => null,
            ];
        }
        $billingDetails = $paymentMethodStripe['data'][0]['billing_details'];
        $cardFirst = $paymentMethodStripe['data'][0]['card'];
        if ($all && is_array($paymentMethodStripe['data'])) {
            return collect($paymentMethodStripe['data'])->pluck('id')->toArray();
        }

        return [
            'success' => true,
            'data' => [
                'last4' => $cardFirst['last4'],
                'exp_month' => $cardFirst['exp_month'],
                'exp_year' => substr($cardFirst['exp_year'], -2),
                'account_name' => $billingDetails['name'],
                'card_brand' => $cardFirst['brand'],
                'card_id' => $paymentMethodStripe['data'][0]['id']
            ],
        ];
    }

    /**
     * @param array $data
     * @return array|bool[]
     * @throws ApiErrorException
     */
    public function addCard(array $data)
    {
        \Log::info('Function add Card');
        DB::connection()->enableQueryLog();
        DB::beginTransaction();
        try {
            $userLogged = $this->userRepository->getUserLoggedIn();

            if (!$userLogged->str_customer_id || $this->checkStripeCustomer($userLogged->str_customer_id)->deleted) {
                $userLogged = $this->createCustomer($userLogged);
            }

            $paymentMethod = $this->stripeClient->paymentMethods->create([
                'type' => 'card',
                'billing_details' => [
                    'address' => [
                        'country' => 'JP',
                    ],
                    'email' => $userLogged->email,
                    'name' => $data['owner_bank'] ?? $userLogged->email
                ],
                'card' => [
                    'number' => $data['number'],
                    'exp_month' => $data['exp_month'],
                    'exp_year' => $data['exp_year'],
                    'cvc' => $data['cvc'],
                ],
            ]);
            $this->stripeClient->paymentMethods->attach(
                $paymentMethod['id'],
                [
                    'customer' => $userLogged->str_customer_id
                ]
            );
            DB::commit();
            $queries = DB::getQueryLog();
            \Log::info('Log sql query', $queries);
            return [
                'success' => true,
                'paymentMethodId' => $paymentMethod->id
            ];

        } catch (CardException $e) {
            DB::rollback();
            return [
                'success' => false,
                'code' => ErrorType::CODE_5039,
                'status' => ErrorType::STATUS_5039,
                'message' => trans('errors.MSG_5038'),
                'error' => $e->getError()->param
            ];

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Delete stripe payment method by id
     * @param $paymentMethodStripeId
     * @return bool[]
     * @throws ApiErrorException
     */
    public function deletePaymentMethodById($paymentMethodStripeId)
    {
        $userLogged = $this->userRepository->getUserLoggedIn();
        if (!$userLogged->str_customer_id) {
            return [
                'success' => true,
            ];
        }

        $this->stripeClient->paymentMethods->detach($paymentMethodStripeId);

        return [
            'success' => true,
        ];
    }

    /**
     * @return bool[]
     * @throws ApiErrorException
     */
    public function deleteCard()
    {
        $userLogged = $this->userRepository->getUserLoggedIn();
        if (!$userLogged->str_customer_id) {
            return [
                'success' => true,
            ];
        }

        $paymentMethodStripe = \Stripe\PaymentMethod::all([
            'customer' => $userLogged->str_customer_id,
            'type' => 'card',
        ]);

        if (empty($paymentMethodStripe['data'])) {
            return [
                'success' => true,
            ];
        }
        $paymentMethodStripeIds = collect($paymentMethodStripe['data'])->pluck('id');

        foreach ($paymentMethodStripeIds as $paymentMethodStripeId) {
            $this->stripeClient->paymentMethods->detach($paymentMethodStripeId);
        }

        return [
            'success' => true,
        ];
    }

    /**
     * Create Checkout Session Stripe
     *
     * @param array $data
     * @return array
     */
    public function createCheckout(array $data)
    {
        DB::beginTransaction();

        try {
            $userLogged = $this->userRepository->getUserLoggedIn();

            if (!$userLogged->str_customer_id) {
                $userLogged = $this->createCustomer($userLogged);
            }

            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'jpy',
                            'product_data' => [
                                'name' => $data['name'],
                            ],
                            'unit_amount' => $data['price'],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'customer' => $userLogged->str_customer_id,
                'payment_intent_data' => [
                    'setup_future_usage' => 'on_session',
                ],
                'metadata' => [
                    'points_package_id' => $data['points_package_id'],
                    'card_brand' => $data['card_brand']
                ],
                'success_url' => url(config('app.buy_point_endpoint_client')) . '?checkout_status=success' . $data['endpoint'],
                'cancel_url' => url(config('app.buy_point_endpoint_client')) . '?checkout_status=cancel' . $data['endpoint'],
            ]);

            DB::commit();

            return [
                'success' => true,
                'data' => $checkoutSession,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'success' => false
            ];
        }
    }

    /**
     * Get list payment with created
     *
     * @param $createdAt
     * @return \Stripe\Collection
     * @throws ApiErrorException
     */
    public function getListPaymentIntents($createdAt)
    {
        return \Stripe\PaymentIntent::all([
            'created' => [
                'gte' => $createdAt
            ]
        ]);
    }

    /**
     * Get detail payment intents.
     *
     * @param $str_payment_id
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */

    public function getDetailPaymentIntents($strPaymentId)
    {
        return $this->stripeClient->paymentIntents->retrieve(
            $strPaymentId,
            ['expand' => ['customer', 'invoice.subscription']]
        );
    }

    /**
     * @param $stripePaymentId
     * @return Refund
     * @throws ApiErrorException
     */
    public function refundCapturedSettlement($stripePaymentId)
    {
        return Refund::create([
            'payment_intent' => $stripePaymentId
//            'reverse_transfer' => true
//            'refund_application_fee' => true
        ]);
    }

    /**
     * @param $stripePaymentId
     * @return \Stripe\Collection
     * @throws ApiErrorException
     */
    public function getRefundByPaymentIntent($stripePaymentId)
    {
        return Refund::all([
            'payment_intent' => $stripePaymentId
        ]);
    }

    /**
     * Get refund detail
     * @param $refundId
     * @return Refund
     * @throws ApiErrorException
     */
    public function getDetailRefund($refundId)
    {
        return Refund::retrieve($refundId);
    }

    /**
     * Cancel payment intent
     *
     * @param $paymentId
     * @return array
     */
    public function cancelPaymentIntent($paymentId)
    {
        try {
            $payment = $this->stripeClient->paymentIntents->retrieve($paymentId);
//            // TODO DELETE CODE (FAKE data to test)
//            $paymentMethod = $stripeObj->paymentMethods->retrieve($payment['payment_method']);
//            if ($paymentMethod) {
//                $card = $paymentMethod['card'];
//                if ($card['brand'] === 'amex' && $card['last4'] === '0005') {
//                    return [
//                        'success' => false,
//                        'message' => 'Credit card cancel error'
//                    ];
//                }
//            }
//            // END TODO
            if ($payment && $payment['status'] === 'canceled') {
                return [
                    'success' => true,
                    'data' => $payment
                ];
            }
            $cancelResponse = $this->stripeClient->paymentIntents->cancel($paymentId);

            return [
                'success' => true,
                'data' => $cancelResponse
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * updateOrCreate custom connect
     */
    public function updateOrCreateCustomConnectAccount($user, $path)
    {
        if ($user->str_person_id) {
            return;
        }
//        $create = true;
//        if ($user->str_connect_id) {
//            $account = $this->stripeClient->accounts->retrieve($user->str_connect_id);
//            if ($account) {
//                $create = false;
//            }
//        }

//        if ($create) {
        return $this->createCustomConnectAccount($user, $path);
//        }
        // disable update info teacher on stripe
//        else if ($user && !$user->str_verification_session) {
//            $this->updateCustomConnectAccount($data);
//        }
    }

    /**
     * create connect account
     */
    private function createCustomConnectAccount($data, $path)
    {
        $dob = now()->parse($data['date_of_birth']);

        $account = $this->stripeClient->accounts->create(
            [
                'country' => 'JP',
                'type' => 'custom',
                'business_type' => 'individual',
                'business_profile' => [
                    'mcc' => config('app.custom_account_default.business_profile'),
                    'url' => config('app.url'),
                    'product_description' => config('app.custom_account_default.product_description'),
                ],
                'company' => [
                    'address_kana' => [
                        'city' => 'ｵｵｻｶｼ ｷﾀｸ',
                        'country' => 'JP',
                        'line1' => '15-5',
                        'line2' => null,
                        'postal_code' => '5310072',
                        'state' => 'ｵｵｻｶﾌ',
                        'town' => 'ﾄﾖｻｷ 3-'
                    ],
                    'address_kanji' => [
                        'city' => '大阪市　北区',
                        'country' => 'JP',
                        'line1' => '15-5',
                        'line2' => null,
                        'postal_code' => '５３１００７２',
                        'state' => '大阪府',
                        'town' => '豊崎　３丁目'
                    ],
                ],
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                'individual' => [
                    'address_kana' => [
                        'city' => 'ｵｵｻｶｼ ｷﾀｸ',
                        'country' => 'JP',
                        'line1' => '15-6',
                        'line2' => null,
                        'postal_code' => '5310072',
                        'state' => 'ｵｵｻｶﾌ',
                        'town' => 'ﾄﾖｻｷ 3-'
                    ],
                    'address_kanji' => [
                        'city' => '大阪市　北区',
                        'country' => 'JP',
                        'line1' => '15-6',
                        'line2' => null,
                        'postal_code' => '５３１００７２',
                        'state' => '大阪府',
                        'town' => '豊崎　３丁目'
                    ],
                    'email' => $data['email'],
                    'dob' => [
                        'day' => $dob->day,
                        'month' => $dob->month,
                        'year' => $dob->year
                    ],
                    'first_name_kana' => $data['first_name_kana'],
                    'last_name_kana' => $data['last_name_kana'],
                    'first_name_kanji' => $data['first_name_kanji'],
                    'last_name_kanji' => $data['last_name_kanji'],
                    'phone' => config('app.custom_account_default.phone_number')
                ]
            ]
        );

        $person = $this->stripeClient->accounts->allPersons(
            $account->id,
            ['limit' => 1]
        );

        $data->str_connect_id = $account->id;
        $data->str_person_id = $person->data[0]->id ?? null;
        $data->save();

        return $this->identityDocuments($data, $path);
    }

    /**
     * create connect account
     */
    private function updateCustomConnectAccount($data)
    {
        $this->stripeClient->accounts->update(
            $data['str_connect_id'],
            [
                'individual' => [
                    'email' => $data['email'],
                    'first_name_kana' => $data['first_name_kana'],
                    'last_name_kana' => $data['last_name_kana'],
                    'first_name_kanji' => $data['first_name_kanji'],
                    'last_name_kanji' => $data['last_name_kanji'],
                ]
            ]
        );
    }

    /**
     * agree term stripe
     */
    public function agreeTerm(User $user)
    {
        if ($user && $user->str_connect_id) {
            $ip = getenv('HTTP_CLIENT_IP') ?:
                getenv('HTTP_X_FORWARDED_FOR') ?:
                    getenv('HTTP_X_FORWARDED') ?:
                        getenv('HTTP_FORWARDED_FOR') ?:
                            getenv('HTTP_FORWARDED') ?:
                                getenv('REMOTE_ADDR');

            $this->stripeClient->accounts->update(
                $user->str_connect_id,
                [
                    'tos_acceptance' => ['date' => now()->getTimestamp(), 'ip' => $ip],
                    'settings' => ['payouts' => ['schedule' => ['interval' => 'manual']]]
                ]
            );
        }
    }

    /**
     * agree term stripe
     */
    public function updateBankCustomAccount(User $user = null)
    {
        if (!$user) {
            $user = auth('client')->user();
        }
        $bank = $user->bankAccount;
        $bankM = $this->bankMasterRepository->where([
            'name' => $bank['bank_name'],
            'type' => 0
        ])->first();
        if (!$bank) {
            return false;
        }

        $branchM = $this->bankMasterRepository->where([
            'name' => $bank['branch_name'],
            'parent_id' => $bankM->code,
            'type' => 1
        ])->first();
        if (!$branchM) {
            return false;
        }
        $routingNumber = $bankM->code_number . $branchM->code_number;
        if ($user && $user->str_connect_id) {
            $bankDefault = $this->stripeClient->accounts->allExternalAccounts(
                $user->str_connect_id,
                ['object' => 'bank_account', 'limit' => 1]
            );
            $ba = $bankDefault->data[0]->id ?? null;

            $this->stripeClient->accounts->createExternalAccount(
                $user->str_connect_id,
                [
                    'external_account' => [
                        'object' => 'bank_account',
                        'country' => 'JP',
                        'currency' => 'jpy',
                        'default_for_currency' => true,
                        'routing_number' => $routingNumber,
                        'account_holder_name' => $bank['account_name'],
                        'account_number' => $bank['account_number']
                    ]
                ]
            );
            if ($ba) {
                $this->stripeClient->accounts->deleteExternalAccount(
                    $user->str_connect_id,
                    $ba,
                    []
                );
            }
        }
    }

    /**
     * create charge
     *
     * @param $data
     * @return array|false[]
     */
    public function charges($data)
    {
        $teacherId = $data['teacherId'] ?? null;
        $studentId = $data['studentId'] ?? null;
        $strCustomerId = $data['strCustomerId'] ?? null;
        $amount = $data['amount'] ?? 0;
        $amountOption = $data['amountOption'] ?? 0;
        $capture = $data['capture'] ?? 'manual';
        $courseScheduleId = $data['course_schedule_id'] ?? null;
//        $courseId = $data['course_id'] ?? null;
//        $stripeFee = 0.036;
//        $saleCommission = 0;
//        $systemCommission = 0;
//        $otherCommission = 0;
//        $inPromotion = false;

        // required
        if (!$teacherId || !($amount + $amountOption) || !$courseScheduleId) {
            return [
                'success' => false
            ];
        }

        $userLogged = auth('client')->user();

        if (!$userLogged) {
            return [
                'success' => false
            ];
        }

//        $firstCourse = $this->courseRepository->where([
//            'user_id' => $teacherId,
//            'status' => DBConstant::APPROVAL_STATUS_COURSE
//        ])->orderBy('courses.updated_at', 'ASC')->pluck('updated_at')->first();
//        $distanceBetweenTime = $firstCourse->diffInDays(now());
//        if ((int)$distanceBetweenTime < Constant::TEACHER_PROMOTION_DAY) {
//            $inPromotion = true;
//        }
//        $teacher = $this->userRepository->find($teacherId);
//
//        switch ($data['type']) {
//            case 'COURSE':
//            case 'EXTEND':
//                $saleCommission = $inPromotion ? Constant::SALES_COMMISSION_RATE_PROMOTION : Constant::SALES_COMMISSION_RATE;
//                $systemCommission = $inPromotion ? Constant::SYSTEM_COMMISSION_RATE_PROMOTION : Constant::SYSTEM_COMMISSION_RATE;
//                break;
//            case 'GIFT':
//                $otherCommission = ($inPromotion ? Constant::COMMISSION_RATE : ($teacher->rank->commission_rate ?? Constant::COMMISSION_RATE_DEFAULT)) * 110;
//                break;
//            default:
//                break;
//        }
//        $saleOptionFee = 0;
//        if ($amountOption) {
//            $saleOptionFee = $amountOption *
//                ($inPromotion ? Constant::SALES_COMMISSION_RATE_PROMOTION : Constant::SALES_COMMISSION_RATE) *
//                (1 + Constant::TAX / 100) / 100;
//        }
//
//        $fee = $amount ?
//            ($amount * (($saleCommission + $systemCommission / $amount * 100) * (1 + Constant::TAX / 100) + $otherCommission) / 100) : 0;

        try {
            if (!$strCustomerId) {

                if (!$userLogged->str_customer_id) {
                    $userLogged = $this->createCustomer($userLogged);
                }

                $strCustomerId = $userLogged->str_customer_id;
            }
            $card = $this->getCreditCard(false, $studentId);
//            $strConnectId = $teacher->str_connect_id;

//            if (is_null($card['data']) || is_null($strConnectId)) {
            if (is_null($card['data'])) {
                return [
                    'success' => false
                ];
            }
//            $group = $courseId ? '{COURSE_' . $courseId . '}' : '{COURSE_SCHEDULE_' . $courseScheduleId . '}';
            $checkoutSession = \Stripe\PaymentIntent::create([
                'payment_method_types' => ['card'],
                'payment_method' => $card['data']['card_id'],
                'amount' => $amount + $amountOption,
                'currency' => 'jpy',
//                'application_fee_amount' => (int)($fee + $saleOptionFee),
                'customer' => $strCustomerId,
                'confirm' => 'true',
                'capture_method' => $capture,
                'transfer_group' => '{COURSE_SCHEDULE_' . $courseScheduleId . '}',
//                'transfer_data' => [
//                    'destination' => $strConnectId,
//                ],
                'metadata' => [
                    'card_brand' => $card['data']['card_brand'],
                    'card_number' => $card['data']['last4']
                ]
            ]);

            return [
                'success' => true,
                'data' => $checkoutSession,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false
            ];
        }
    }

    public function chargeConnectedAccount($data)
    {
//        if ($data['cancellation_fee']) {
//            $this->stripeLogRepository->addRecord($data['cancellation_fee']);
//        }
//        if (!$data['cancellation_fee'] && !$data['connect_id']) {
//            return false;
//        }
//        return \Stripe\Charge::create([
//            'amount'   => $data['cancellation_fee'],
//            'currency' => 'jpy',
//            'source' => $data['connect_id']
//        ]);
    }

//    public function updatePaymentIntent($paymentId, $applicationFee)
//    {
//        return $this->stripeClient->paymentIntents->update(
//            $paymentId,
//            ['application_fee_amount' => $applicationFee]
//        );
//    }

    /**
     * @param $user
     * @param $path
     * @throws ApiErrorException
     */
    public function identityDocuments($user, $path)
    {
        $strConnectId = $user->str_connect_id;
        $file = $this->uploadImage($path->getPathName(), $strConnectId);

        if ($file) {
            $this->stripeClient->accounts->updatePerson(
                $strConnectId,
                $user->str_person_id,
                ['verification' => ['document' => ['front' => $file->id]]]
            );
            $user->save();
        }

        return $user;
    }

    /**
     * @param $path
     * @param string $strConnectId
     * @return \Stripe\File
     * @throws ApiErrorException
     */
    public function uploadImage($path, string $strConnectId)
    {
        return \Stripe\File::create([
            'purpose' => 'identity_document',
            'file' => fopen($path, 'r'),
        ], [
            'stripe_account' => $strConnectId
        ]);
    }
}
