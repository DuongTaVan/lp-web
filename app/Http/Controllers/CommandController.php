<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\TransferHistoryRepository;
use App\Services\Batch\StatisticsService;
use App\Traits\RealtimeTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use App\Services\Client\Student\CourseScheduleService;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BankMasterRepository;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class CommandController extends Controller
{
    use RealtimeTrait;
    private $bankMaster;
    private $course;
    private $courseSchedule;
    private $image;
    private $transferHistory;
    protected $stripeClient;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        $this->bankMaster = app(BankMasterRepository::class);
        $this->course = app(CourseRepository::class);
        $this->courseSchedule = app(CourseScheduleRepository::class);
        $this->image = app(ImagePathRepository::class);
        $this->transferHistory = app(TransferHistoryRepository::class);
        $this->statisticService = app(StatisticsService::class);
        $this->stripeClient = new StripeClient(config('app.stripe_secret'));
    }

    public function test()
    {
        // DEV_LAPPI 4190
        $this->statisticService->updateStatistics();

        dd('Run batch update table statistic donw');
//        $this->sendEvent('realtime', [
//            'url' => '/portal/business/business-verification-image',
//            'screen' => 'BUSINESS',
//            'id' => 26148
//        ]);
//        $tf = $this->transferHistory->where([
//            'transferred_at' => null
//        ])->get();
//        foreach ($tf as $item) {
//            $item->transferred_at = holiday($item->scheduled_date);
//            $item->save();
//        }
//        for ($i = 0; $i < 10; $i++) {
//            $account = $this->stripeClient->accounts->create(
//                [
//                    'country' => 'JP',
//                    'type' => 'custom',
//                    'business_type' => 'individual',
//                    'business_profile' => [
//                        'mcc' => config('app.custom_account_default.business_profile'),
//                        'url' => config('app.url'),
//                        'product_description' => config('app.custom_account_default.product_description'),
//                    ],
//                    'company' => [
//                        'address_kana' => [
//                            'city' => 'ｵｵｻｶｼ ｷﾀｸ',
//                            'country' => 'JP',
//                            'line1' => '15-5',
//                            'line2' => null,
//                            'postal_code' => '5310072',
//                            'state' => 'ｵｵｻｶﾌ',
//                            'town' => 'ﾄﾖｻｷ 3-'
//                        ],
//                        'address_kanji' => [
//                            'city' => '大阪市　北区',
//                            'country' => 'JP',
//                            'line1' => '15-5',
//                            'line2' => null,
//                            'postal_code' => '５３１００７２',
//                            'state' => '大阪府',
//                            'town' => '豊崎　３丁目'
//                        ],
//                    ],
//                    'capabilities' => [
//                        'card_payments' => ['requested' => true],
//                        'transfers' => ['requested' => true],
//                    ],
//                    'individual' => [
//                        'address_kana' => [
//                            'city' => 'ｵｵｻｶｼ ｷﾀｸ',
//                            'country' => 'JP',
//                            'line1' => '15-6',
//                            'line2' => null,
//                            'postal_code' => '5310072',
//                            'state' => 'ｵｵｻｶﾌ',
//                            'town' => 'ﾄﾖｻｷ 3-'
//                        ],
//                        'address_kanji' => [
//                            'city' => '大阪市　北区',
//                            'country' => 'JP',
//                            'line1' => '15-6',
//                            'line2' => null,
//                            'postal_code' => '５３１００７２',
//                            'state' => '大阪府',
//                            'town' => '豊崎　３丁目'
//                        ],
//                        'email' => 'email' . $i . '@gmail.com',
//                        'dob' => [
//                            'day' => 28,
//                            'month' =>11,
//                            'year' => 1996
//                        ],
//                        'first_name_kana' => 'フリガナ',
//                        'last_name_kana' => 'フリガナ',
//                        'first_name_kanji' => 'Lappi',
//                        'last_name_kanji' => 'Hoai',
//                        'phone' => config('app.custom_account_default.phone_number')
//                    ]
//                ]
//            );
//
//            $ip = getenv('HTTP_CLIENT_IP') ?:
//                getenv('HTTP_X_FORWARDED_FOR') ?:
//                    getenv('HTTP_X_FORWARDED') ?:
//                        getenv('HTTP_FORWARDED_FOR') ?:
//                            getenv('HTTP_FORWARDED') ?:
//                                getenv('REMOTE_ADDR');
//
//            $this->stripeClient->accounts->update(
//                $account->id,
//                [
//                    'tos_acceptance' => ['date' => now()->getTimestamp(), 'ip' => $ip],
//                    'settings' => ['payouts' => ['schedule' => ['interval' => 'manual']]]
//                ]
//            );
//        }
        dd(123);
        // test realtime transfer
//        $this->sendEvent('realtime', [
//            'url' => '/portal/transfer-histories',
//            'screen' => 'TRANSFER',
//            'id' => 9
//        ]);
//        $c = $this->course->where('type', DBConstant::COURSE_TYPE_MAIN)
//            ->whereNotNull('parent_course_id');
//        $cIds = $c->pluck('course_id')->toArray();
//        $cs = $this->courseSchedule->whereIn('course_id', $cIds)->get();
//        $i = $this->image->whereIn('course_id', $cIds)->get();

//        $strCustomerId = '';
//
//        $card = $this->getCreditCard($strCustomerId);
//
////            $strConnectId = $teacher->str_connect_id;
//
////            if (is_null($card['data']) || is_null($strConnectId)) {
//        if (is_null($card['data'])) {
//            dd([
//                'success' => false
//            ]);
//        }
//
//        $checkoutSession = \Stripe\PaymentIntent::create([
//            'payment_method_types' => ['card'],
//            'payment_method' => $card['data']['card_id'],
//            'amount' => 6000,
//            'currency' => 'jpy',
//            'customer' => $strCustomerId,
//            'confirm' => 'true',
//            'capture_method' => 'automatic',
//            'transfer_group' => '{COURSE_SCHEDULE_448}',
//            'metadata' => [
//                'card_brand' => $card['data']['card_brand'],
//                'card_number' => $card['data']['last4']
//            ]
//        ]);
//
//        dd($checkoutSession);
        $this->sendEvent('realtime', [
            'url' => '/portal/business/business-verification-image',
            'screen' => 'BUSINESS',
            'id' => 26148
        ]);
        dd(123);
//        $limelight = new Limelight();
//        $results = $limelight->parse('p');
//
//        echo 'Hiragana: ' . $results->toHiragana()->string('word') . "\n";
//        echo 'Katakana: ' . $results->toKatakana()->string('word') . "\n";
//        $banks = $this->bankMaster
//            ->all();
//        foreach ($banks as $bank) {
//            $bank->name_kana = $this->toFull($bank->name_kana);
//            $bank->save();
//        }
    }

    /**
     * @param string $strCustomerId
     * @return array
     * @throws ApiErrorException
     */
    public function getCreditCard(string $strCustomerId)
    {
        $paymentMethodStripe = \Stripe\PaymentMethod::all([
            'customer' => $strCustomerId,
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

        return [
            'success' => true,
            'data' => [
                'last4' => $cardFirst['last4'],
                'exp_month' => $cardFirst['exp_month'],
                'exp_year' => $cardFirst['exp_year'],
                'account_name' => $billingDetails['name'],
                'card_brand' => $cardFirst['brand'],
                'card_id' => $paymentMethodStripe['data'][0]['id']
            ],
        ];
    }

    private function toFull($char)
    {
        $replaceOf = [
            'ガ', 'ギ', 'グ', 'ゲ', 'ゴ',
            'ザ', 'ジ', 'ズ', 'ゼ', 'ゾ',
            'ダ', 'ヂ', 'ヅ', 'デ', 'ド',
            'バ', 'ビ', 'ブ', 'ベ', 'ボ',
            'パ', 'ピ', 'プ', 'ペ', 'ポ',
            'ヴ', 'ヷ', 'ヺ',
            'ア', 'イ', 'ウ', 'エ', 'オ',
            'カ', 'キ', 'ク', 'ケ', 'コ',
            'サ', 'シ', 'ス', 'セ', 'ソ',
            'タ', 'チ', 'ツ', 'テ', 'ト',
            'ナ', 'ニ', 'ヌ', 'ネ', 'ノ',
            'ハ', 'ヒ', 'フ', 'ヘ', 'ホ',
            'マ', 'ミ', 'ム', 'メ', 'モ',
            'ヤ', 'ユ', 'ヨ',
            'ラ', 'リ', 'ル', 'レ', 'ロ',
            'ワ', 'ヲ', 'ン',
            '。', '、', 'ー', '「', '」', '・',
            'ア', 'イ', 'ウ', 'エ', 'オ', 'ヤ',
            'ユ', 'ヨ', 'ツ'
        ];
        $replaceBy = [
            'ｶﾞ', 'ｷﾞ', 'ｸﾞ', 'ｹﾞ', 'ｺﾞ',
            'ｻﾞ', 'ｼﾞ', 'ｽﾞ', 'ｾﾞ', 'ｿﾞ',
            'ﾀﾞ', 'ﾁﾞ', 'ﾂﾞ', 'ﾃﾞ', 'ﾄﾞ',
            'ﾊﾞ', 'ﾋﾞ', 'ﾌﾞ', 'ﾍﾞ', 'ﾎﾞ',
            'ﾊﾟ', 'ﾋﾟ', 'ﾌﾟ', 'ﾍﾟ', 'ﾎﾟ',
            'ｳﾞ', 'ﾜﾞ', 'ｦﾞ',
            'ｱ', 'ｲ', 'ｳ', 'ｴ', 'ｵ',
            'ｶ', 'ｷ', 'ｸ', 'ｹ', 'ｺ',
            'ｻ', 'ｼ', 'ｽ', 'ｾ', 'ｿ',
            'ﾀ', 'ﾁ', 'ﾂ', 'ﾃ', 'ﾄ',
            'ﾅ', 'ﾆ', 'ﾇ', 'ﾈ', 'ﾉ',
            'ﾊ', 'ﾋ', 'ﾌ', 'ﾍ', 'ﾎ',
            'ﾏ', 'ﾐ', 'ﾑ', 'ﾒ', 'ﾓ',
            'ﾔ', 'ﾕ', 'ﾖ',
            'ﾗ', 'ﾘ', 'ﾙ', 'ﾚ', 'ﾛ',
            'ﾜ', 'ｦ', 'ﾝ',
            '｡', '､', 'ｰ', '｢', '｣', '･',
            'ァ', 'ィ', 'ゥ', 'ェ', 'ォ', 'ャ',
            'ュ', 'ョ', 'ッ'
        ];

        return str_replace($replaceBy, $replaceOf, $char);
    }

    /**
     * Batch 01.
     *
     * @return RedirectResponse
     */
    public function insertBoxNotification()
    {
        Artisan::call('box-notification:insert');

        return redirect()->route('command');
    }

    /**
     * Batch 02 send mail notification.
     *
     * @return RedirectResponse
     */
    public function sendEmail()
    {
        Artisan::call('send:mail');

        return redirect()->route('command');
    }

    /**
     * Batch 03 credit card capture.
     *
     * @return RedirectResponse
     */
    public function captureCreditCard()
    {
        Artisan::call('credit-card:capture');

        return redirect()->route('command');
    }

    /**
     * Batch 04.
     *
     * @return RedirectResponse
     */
    public function changeCourseSchedule()
    {
        Artisan::call('courses-schedule:change');

        return redirect()->route('command');
    }

    /**
     * Batch 05.
     *
     * @return RedirectResponse
     */
    public function updateExpiredPoint()
    {
        Artisan::call('expired-point:update');

        return redirect()->route('command');
    }

    /** Batch 06.
     *
     * @return RedirectResponse
     */
    public function insertRanking()
    {
        Artisan::call('ranking:insert');

        return redirect()->route('command');
    }

    /**
     * Batch 07.
     *
     * @return RedirectResponse
     */
    public function insertSaleTotal()
    {
        Artisan::call('sale-total:insert');

        return redirect()->route('command');
    }

    /**
     * Batch 08 create statistics.
     *
     * @return RedirectResponse
     */
    public function createStatistics()
    {
        Artisan::call('statistics:create');

        return redirect()->route('command');
    }

    /**
     * Batch 09 change Teacher Rank.
     *
     * @return RedirectResponse
     */
    public function changeTeacherRank()
    {
        Artisan::call('teacher-rank:change');

        return redirect()->route('command');
    }

    public function remindConfirm()
    {
        Artisan::call('confirm-mail:change');

        return redirect()->route('command');
    }

    public function cancelCourseSchedule()
    {
        Artisan::call('cancel-courses-schedules:change');
        return redirect()->route('command');
    }

    public function sendMailNewService()
    {
        Artisan::call('send-mail-sale-commission:change');
        return redirect()->route('command');
    }

    public function payoutLappi()
    {
        Artisan::call('payout-lappi:run');
        return redirect()->route('command');
    }

    public function payoutTeacher()
    {
        Artisan::call('payout-teacher:run');
        return redirect()->route('command');
    }

    public function testMail(CourseScheduleService $courseSchedule)
    {
        $courseSchedule->testMail();
        return redirect()->route('command');
    }

    public function readCsv()
    {
        $csvFileName = "data-bank.csv";
        $csvFile = storage_path($csvFileName);
        $data = $this->readExtensionCSV($csvFile, array('delimiter' => ','));

        $arrParents = [];
        $arrParents2 = [];
        $arrBankCodes2 = [];
        foreach ($data as $item) {
            if (isset($item[1])) {
                $arrParents[] = $item[1];
                $arrParents2[] = $item[2];
                $arrBankCodes2[] = $item[5];
            }
        }

        if (count($arrParents) > 0) {
//            $arrParents = array_values(array_unique($arrParents));
//            $arrParents2 = array_values(array_unique($arrParents2));
            $tempArrParents = $tempArrParents2 = $tempArrBankCodes2 = [];

            $tempText = $arrParents;
            foreach ($arrParents as $key => $value) {
                if (!$tempText || $value !== $tempText) {
                    $tempArrParents[] = $value;
                    $tempArrParents2[] = $arrParents2[$key];
                    $tempArrParents2[] = $arrParents2[$key];
                    $tempArrBankCodes2[] = $arrBankCodes2[$key];
                }
                $tempText = $value;
            }
            $lineBank = '';
            $lineBranch = '';
            foreach ($tempArrParents as $key => $arrParent) {
                $lineBank .= '(' . $key . ',"' . $arrParent . '銀行"' . ',"' . $tempArrParents2[$key] . '",0,"' . $tempArrBankCodes2[$key] .'"),';
                foreach ($data as $item) {
                    if (isset($item[1]) && $item[1] === $arrParent) {
                        $lineBranch .= '("' . $item[3] . '","' . $item[4] . '",' . $key . ',1,"' . $item[6] . '"),';
                    }
                }
            }
            Storage::disk('local')->append('banks.txt', $lineBank);
            Storage::disk('local')->append('branch.txt', $lineBranch);
        }


    }

    /**
     * Read extension CSV.
     *
     * @param $csvFile
     * @param $array
     * @return mixed
     */
    private function readExtensionCSV($csvFile, $array)
    {
        $fileHandle = fopen($csvFile, 'r');
        while (!feof($fileHandle)) {
            $lineOfText[] = fgetcsv($fileHandle, 0, $array['delimiter']);
        }
        unset($lineOfText[0]);
        fclose($fileHandle);
        return array_values($lineOfText);
    }

    public function command(){
        return view('command');
    }
}
