<?php

namespace App\Traits;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Mail\AdminSendSaleCommission;
use App\Models\Course;
use App\Models\Promotion;
use App\Repositories\PromotionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait PromotionTrait
{
    private $promotionRepository;

    /**
     * add promotion teacher
     *
     * @param int $userId
     * @param int $courseId
     * @param bool $create
     * @param Carbon|null $time
     * @return bool
     */
    public function checkPromotion(int $userId, int $courseId, bool $create, Carbon $time = null)
    {
        $this->promotionRepository = app(PromotionRepository::class);

        $promotion = $this->promotionRepository->where([
            'user_id' => $userId
        ])->first();
        if (!$promotion && $create) {
            $this->createPromotion($userId, $courseId);
        }
        if ($promotion && !$create && $time) {
            return $time->format('Y-m-d') >= $promotion->started_at->format('Y-m-d') &&
                $time->format('Y-m-d') <= $promotion->finished_at->format('Y-m-d');
        }

        return false;
    }

    public function createPromotion(int $userId, int $courseId)
    {
        $user = auth('client')->user();
        $promotion = $this->promotionRepository->create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'started_at' => now(),
            'finished_at' => now()->addDays(Constant::TEACHER_PROMOTION_DAY),
        ]);
        Mail::to($user->email)->queue(
            new AdminSendSaleCommission(
                '【Lappi】販売手数料１０％適応開始のお知らせ。',
                $promotion,
                $user->full_name
            )
        );
    }
}
