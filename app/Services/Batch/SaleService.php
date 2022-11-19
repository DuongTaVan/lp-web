<?php

namespace App\Services\Batch;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CashRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\GiftTippingHistoryRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\PurchaseDetailRepositoryEloquent;
use App\Repositories\QuestionTicketRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;
use App\Services\BaseService;
use App\Traits\PromotionTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class SaleService extends BaseService
{
    use PromotionTrait;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $courseScheduleRepository;
    public $applicantRepository;
    public $questionTicketRepository;
    public $giftTippingHistoryRepository;
    public $optionalExtraMappingRepository;
    public $purchaseDetailRepositoryEloquent;
    public $cashRepository;
    public $userRepository;
    public $courseRepository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->questionTicketRepository = app(QuestionTicketRepository::class);
        $this->giftTippingHistoryRepository = app(GiftTippingHistoryRepository::class);
        $this->optionalExtraMappingRepository = app(OptionalExtraMappingRepository::class);
        $this->purchaseDetailRepositoryEloquent = app(PurchaseDetailRepositoryEloquent::class);
        $this->cashRepository = app(CashRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return SaleRepository::class;
    }

    /**
     * Batch 07 Sales total batch
     *
     * @return array
     */
    public function batch07(): array
    {
        // set value.
        $runBatchCompleted = false;
        $offset = 0;

        while (!$runBatchCompleted) {
            // 1-1) Get the target data every 1,000 records from DB.
            $courseSchedules = $this->courseScheduleRepository
                ->getReservationData()
                ->offset($offset * Constant::BATCH_RECORD_LIMIT)
                ->limit(Constant::BATCH_RECORD_LIMIT)
                ->get();
            // Break when no target.
            if (!count($courseSchedules)) {
                $runBatchCompleted = true;

                break;
            }
            $offset++;

            // 1-2) Loop as many times as the number of data at 1-1).
            foreach ($courseSchedules as $courseSchedule) {
                // set value
                if ($courseSchedule->num_of_applicants === 0) {
                    continue;
                }
                $courseScheduleId = $courseSchedule->course_schedule_id;
                $categoryType = $courseSchedule->category_type;
                $courseType = $courseSchedule->course_type;
                $userId = $courseSchedule->user_id;
                $targetDate = now()->subDay();

                $inPromotion = $this->checkPromotion($userId, $courseSchedule->course_id, false, $targetDate);
                $saleCommissionRate = ($inPromotion ?
                        Constant::SALES_COMMISSION_RATE_PROMOTION : Constant::SALES_COMMISSION_RATE) / 100;

                //get number give gift
                $numberGiveGift = $this->courseRepository->getNumberGiveGift($courseScheduleId);
                $totalNumberGiveGift = count($numberGiveGift);

                // (Specified only when {categories.type}=1 AND {courses.type}=1)
                $isSkillReservation = $categoryType === DBConstant::CATEGORY_TYPE_SKILLS &&
                    $courseType === DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION;

                // (Specified only when {categories.type}=1 AND {courses.type}=2)
                $isSkillExtension = $categoryType === DBConstant::CATEGORY_TYPE_SKILLS &&
                    $courseType === DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION;

                // DBConstant::CATEGORY_TYPE_CONSULTATION (Specified only when {categories.type}=2)
                $isConsultationType = $categoryType === DBConstant::CATEGORY_TYPE_CONSULTATION;

                // DBConstant::CATEGORY_TYPE_FORTUNETELLING (Specified only when {categories.type}=3)
                $isFortunetellingType = $categoryType === DBConstant::CATEGORY_TYPE_FORTUNETELLING;

                // 1-2-1) Get applicants.
                $applicantsCount = $this->applicantRepository->getDataByCourseScheduleId($courseScheduleId);
                $totalApplicant = $applicantsCount->count_applicant ?? 0;

                // 1-2-2) Get question sales.
                $questionTickets = $this->questionTicketRepository->where(
                    ['course_schedule_id' => $courseScheduleId]
                )->count('question_ticket_id');

                // 1-2-3) Get gift sales.
                $giftSales = $this->giftTippingHistoryRepository
                    ->selectRaw('COUNT(id) as count_id, SUM(points_equivalent) as sum_points_equivalent')
                    ->where('course_schedule_id', $courseScheduleId)
                    ->first();

                // 1-2-4) Get course extensions.
                $courseScheduleExtensions = $this->courseScheduleRepository->getSumExtensionData($courseScheduleId);

                // 1-2-5) Get option sales.
                // $optionSales = $this->optionalExtraMappingRepository->getOptionSales($courseScheduleId);
                $optionSales = $this->purchaseDetailRepositoryEloquent->getOptionSales($courseScheduleId);

                //1-2-6) Get teacher's rank.
                $commission_rate = $this->userRepository->getTeacherRanks($userId);
                $commission_rate = $inPromotion ?
                    Constant::COMMISSION_RATE : ($commission_rate->commission_rate ?? Constant::COMMISSION_RATE_DEFAULT);
                // 1-2-7) Calculate teacher profit.
                $coursePrice = $courseSchedule->course_price ?? 0;
                $courseSale = $applicantsCount->count_applicant * $coursePrice;
                $extensionSale = $courseScheduleExtensions->sum_price ?? 0;
                $optionSale = $optionSales->sum_total_amount ?? 0;
                $questionSale = $questionTickets * Constant::QUESTION_TICKET_PRICE;
                $giftSale = $giftSales->sum_points_equivalent * Constant::GIFT_PRICE;
                $totalSale = $courseSale + $extensionSale + $optionSale + $questionSale + $giftSale;
                $salesCommission = ($courseSale + $extensionSale + $optionSale) * $saleCommissionRate;
                $otherCommission = ($questionSale + $giftSale) * $commission_rate;
                $systemCommission = ($saleCommissionRate === 0.1 || $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_CANCELED) ?
                    0 : (($applicantsCount->count_applicant + $courseScheduleExtensions['count_course_schedule_id']) *
                        ($inPromotion ? Constant::SYSTEM_COMMISSION_RATE_PROMOTION : Constant::SYSTEM_COMMISSION_RATE)
                    );
                $totalCommission = $salesCommission + $otherCommission + $systemCommission;
                $teacherProfit = $totalSale - $totalCommission;
                $saleTax = ($salesCommission + $systemCommission + $otherCommission) * Constant::SELLER_PROFIT;
                $teacherCashBalance = $teacherProfit - $saleTax;
                // 1-2-8) Get current cash balance.
                $cashBalance = $this->cashRepository
                    ->where('user_id', $courseSchedule->user_id)
                    ->orderBy('cash_id', 'DESC')->first();
                $balance = ($cashBalance->balance ?? 0) + $teacherCashBalance;
                $cashProfit = ($cashBalance->teacher_profit ?? 0) + $teacherProfit;
                $saleTax = ($cashBalance->sale_tax ?? 0) + $saleTax;

                // 1-2-9) Start transaction.
                DB::beginTransaction();
                try {
                    // 1-2-10) Create cash.
                    $cashes = $this->cashRepository->create([
                        'user_id' => $courseSchedule->user_id,
                        'deposit_amount' => $teacherCashBalance,
                        'deposit_reason' => DBConstant::DEPOSIT_REASON_SERVICES,
                        'withdrawal_amount' => null,
                        'withdrawal_reason' => null,
                        'balance' => $balance,
                        'teacher_profit' => $cashProfit,
                        'sale_tax' => $saleTax,
                        'transacted_at' => now(),
                    ]);

                    // 1-2-11) Update user.
                    $this->userRepository->update([
                        'cash_balance' => $balance
                    ], $courseSchedule->user_id);

                    // 1-2-12) Create sales.
                    $this->repository->create([
                        'user_id' => $courseSchedule->user_id,
                        'course_schedule_id' => $courseScheduleId,
                        'target_date' => $targetDate,
                        'cash_id' => $cashes->cash_id,
                        'is_skills' => $isSkillReservation ? 1 : 0,
                        'is_skills_sub' => $isSkillExtension ? 1 : 0,
                        'is_consultation' => $isConsultationType ? 1 : 0,
                        'is_fortunetelling' => $isFortunetellingType ? 1 : 0,
                        'total_minutes' => $courseSchedule->minutes_required + $courseScheduleExtensions->sum_minutes_required,
                        'minutes_skills' => $isSkillReservation ? ($courseSchedule->minutes_required ?? 0) : 0,
                        'minutes_skills_sub' => $isSkillExtension ? ($courseSchedule->minutes_required ?? 0) : 0,
                        'minutes_skills_sub_extended' => $isSkillExtension ? $courseScheduleExtensions->sum_minutes_required : 0,
                        'skills_sub_extension_count' => $isSkillExtension ? $courseScheduleExtensions->count_course_schedule_id : 0,
                        'minutes_consultation' => $isConsultationType ? ($courseSchedule->minutes_required ?? 0) : 0,
                        'minutes_consultation_extended' => $isConsultationType ? $courseScheduleExtensions->sum_minutes_required : 0,
                        'consultation_extension_count' => $isConsultationType ? $courseScheduleExtensions->count_course_schedule_id : 0,
                        'minutes_fortunetelling' => $isFortunetellingType ? ($courseSchedule->minutes_required ?? 0) : 0,
                        'minutes_fortunetelling_extended' => $isFortunetellingType ? $courseScheduleExtensions->sum_minutes_required : 0,
                        'fortunetelling_extension_count' => $isFortunetellingType ? $courseScheduleExtensions->count_course_schedule_id : 0,
                        'total_applicants' => $totalApplicant,
                        'total_applicants_lappi_new' => $applicantsCount->sum_is_lappi_new ?? 0,
                        'total_applicants_lappi_repeater' => $applicantsCount->sum_is_lappi_repeater ?? 0,
                        'skills_applicants' => $isSkillReservation ? $totalApplicant : 0,
                        'skills_applicants_teacher_new' => $isSkillReservation ? ($applicantsCount->sum_is_teacher_new ?? 0) : 0,
                        'skills_applicants_teacher_repeater' => $isSkillReservation ? $applicantsCount->sum_is_teacher_repeater : 0,
                        'skills_sub_applicants' => $isSkillExtension ? $totalApplicant : 0,
                        'skills_sub_applicants_teacher_new' => $isSkillExtension ? $applicantsCount->sum_is_teacher_new : 0,
                        'skills_sub_applicants_teacher_repeater' => $isSkillExtension ? $applicantsCount->sum_is_teacher_repeater : 0,
                        'consultation_applicants' => $isConsultationType ? $totalApplicant : 0,
                        'consultation_applicants_teacher_new' => $isConsultationType ? $applicantsCount->sum_is_teacher_new : 0,
                        'consultation_applicants_teacher_repeater' => $isConsultationType ? $applicantsCount->sum_is_teacher_repeater : 0,
                        'fortunetelling_applicants' => $isFortunetellingType ? $totalApplicant : 0,
                        'fortunetelling_applicants_teacher_new' => $isFortunetellingType ? $applicantsCount->sum_is_teacher_new : 0,
                        'fortunetelling_applicants_teacher_repeater' => $isFortunetellingType ? $applicantsCount->sum_is_teacher_repeater : 0,
                        'base_price' => $coursePrice,
                        'course_sales' => $courseSale,
                        'extension_sales' => $extensionSale,
                        'extension_count' => $courseScheduleExtensions->count_course_schedule_id ?? 0,
                        'option_sales' => $optionSale,
                        'option_count' => $optionSales->count_item ?? 0,
                        'question_sales' => $questionSale ?? 0,
                        'question_count' => $questionTickets ?? 0,
                        'gift_sales' => $giftSale,
                        'gift_count' => $giftSales->count_id,
                        'total_number_give_gift' => $totalNumberGiveGift,
                        'total_sales_skills' => $isSkillReservation ? $totalSale : 0,
                        'total_sales_skills_sub' => $isSkillExtension ? $totalSale : 0,
                        'total_sales_consultation' => $isConsultationType ? $totalSale : 0,
                        'total_sales_fortunetelling' => $isFortunetellingType ? $totalSale : 0,
                        'total_sales' => $totalSale,
                        'sales_commissions' => $salesCommission,
                        'other_commissions' => $otherCommission,
                        'system_commissions' => $systemCommission,
                        'total_commissions' => $totalCommission,
                        'teacher_profit' => $teacherProfit,
                        'cash_balance' => $teacherCashBalance,
                        'tax_rate' => Constant::TAX_RATE, // update db decimal(3,0) => decimal(3,1)
                        'tax_amount' => 0, // remove
                        'teacher_profit_exc_tax' => $teacherProfit * Constant::TAX_RATE,
                        'cancellation_fee' => 0,
                        'sales_skills_genre_1' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[0] ? $totalSale : 0,
                        'sales_skills_genre_2' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[1] ? $totalSale : 0,
                        'sales_skills_genre_3' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[2] ? $totalSale : 0,
                        'sales_skills_genre_4' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[3] ? $totalSale : 0,
                        'sales_skills_genre_5' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[4] ? $totalSale : 0,
                        'sales_skills_genre_6' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[5] ? $totalSale : 0,
                        'sales_skills_genre_7' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[6] ? $totalSale : 0,
                        'sales_skills_genre_8' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[7] ? $totalSale : 0,
                        'sales_skills_genre_9' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[8] ? $totalSale : 0,
                        'sales_skills_genre_10' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[9] ? $totalSale : 0,
                        'sales_skills_genre_11' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[10] ? $totalSale : 0,
                        'sales_skills_genre_12' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[11] ? $totalSale : 0,
                        'sales_skills_genre_13' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[12] ? $totalSale : 0,
                        'sales_consultation_genre_1' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[13] ? $totalSale : 0,
                        'sales_consultation_genre_2' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[14] ? $totalSale : 0,
                        'sales_consultation_genre_3' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[15] ? $totalSale : 0,
                        'sales_consultation_genre_4' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[16] ? $totalSale : 0,
                        'sales_consultation_genre_5' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[17] ? $totalSale : 0,
                        'sales_consultation_genre_6' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[18] ? $totalSale : 0,
                        'sales_consultation_genre_7' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[19] ? $totalSale : 0,
                        'sales_consultation_genre_8' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[20] ? $totalSale : 0,
                        'sales_consultation_genre_9' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[21] ? $totalSale : 0,
                        'sales_consultation_genre_10' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[22] ? $totalSale : 0,
                        'sales_fortunetelling_genre_1' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[23] ? $totalSale : 0,
                        'sales_fortunetelling_genre_2' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[24] ? $totalSale : 0,
                        'sales_fortunetelling_genre_3' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[25] ? $totalSale : 0,
                        'sales_fortunetelling_genre_4' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[26] ? $totalSale : 0,
                        'sales_fortunetelling_genre_5' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[27] ? $totalSale : 0,
                        'sales_fortunetelling_genre_6' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[28] ? $totalSale : 0,
                        'sales_fortunetelling_genre_7' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[29] ? $totalSale : 0,
                        'sales_fortunetelling_genre_8' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[30] ? $totalSale : 0,
                        'sales_fortunetelling_genre_9' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[31] ? $totalSale : 0,
                        'sales_fortunetelling_genre_10' => $courseSchedule->category_id === DBConstant::CATEGORY_ID[32] ? $totalSale : 0,
                        'sales_not_known' => $applicantsCount->count_sales_hidden_male,
                        'sales_male' => $applicantsCount->count_sales_male,
                        'sales_female' => $applicantsCount->count_sales_female,
                        'sales_unapplicable' => $applicantsCount->count_sales_unapplicable,
                        'sales_10s' => $applicantsCount->count_sales_10s,
                        'sales_20s' => $applicantsCount->count_sales_20s,
                        'sales_30s' => $applicantsCount->count_sales_30s,
                        'sales_40s' => $applicantsCount->count_sales_40s,
                        'sales_50s' => $applicantsCount->count_sales_50s,
                        'sales_60s' => $applicantsCount->count_sales_60s,
                        'is_imported' => DBConstant::SALE_NOT_IMPORTED,
                    ]);

                    // 1-2-12) Update course schedule status.
                    $this->courseScheduleRepository->update([
                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_RECORDED,
                    ], $courseScheduleId);

                    $this->courseScheduleRepository->where([
                        'type' => DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
                        'parent_course_schedule_id' => $courseScheduleId
                    ])->update([
                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_RECORDED,
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                }
            }
        }

        return [
            'success' => true
        ];
    }
}
