<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Services\Batch\CourseScheduleService;
use App\Services\Client\Gift\PurchaseGiftService;
use App\Services\Client\Student\Course\CourseReviewService;
use Illuminate\Http\Request;
use App\Services\Common\StripePaymentService;

class StudentLiveStreamController extends Controller
{

    protected $stripePaymentService;

    public function __construct(
        StripePaymentService $stripePaymentService
    )
    {
        $this->stripePaymentService = $stripePaymentService;
    }

    /**
     * Student Live Stream Page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function studentLiveStream(PurchaseGiftService $giftService, $courseScheduleId)
    {
        $gifts = $giftService->repository->all();
        $creditCard = $this->stripePaymentService->getCreditCard()['data'] ?? [];

        return view('client.screen.student-livestream.index')->with([
            'gifts' => $gifts,
            'creditCard' => $creditCard,
            'courseScheduleId' => $courseScheduleId
        ]);
    }

    /** Student Course Review Page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
//    public function studentCourseReview($courseScheduleId, CourseScheduleService $courseScheduleService, CourseReviewService $courseReviewService)
//    {
//        $dataReviewed = $courseReviewService->getReviewView($courseScheduleId);
//        if (!$dataReviewed) {
//            $courseSchedule = $courseScheduleService->getCourseSchedule($courseScheduleId);
//            return view('client.screen.student-livestream.course-review', compact('courseSchedule'));
//        }
//        $courseSchedule = $dataReviewed['courseSchedule'];
//        $reviewed = $dataReviewed['reviewed'];
//        return view('client.screen.student-livestream.course-review', compact('reviewed', 'courseSchedule'));
//    }
}
