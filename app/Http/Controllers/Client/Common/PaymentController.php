<?php

namespace App\Http\Controllers\Client\Common;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Common\SubmitPaymentRequest;
use App\Http\Requests\Client\Common\UpdatePaymentMethodRequest;
use App\Repositories\PurchaseRepository;
use App\Services\Client\Common\CourseService;
use App\Services\Common\StripePaymentService;
use App\Traits\CourseImageTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Repositories\CourseScheduleRepository;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use CourseImageTrait;
    protected $stripePaymentService;
    protected $courseScheduleRepository;
    protected $purchaseRepository;
    protected $courseService;

    public function __construct(
        StripePaymentService     $stripePaymentService,
        CourseScheduleRepository $courseScheduleRepository,
        PurchaseRepository       $purchaseRepository,
        CourseService            $courseService
    )
    {
        $this->stripePaymentService = $stripePaymentService;
        $this->courseScheduleRepository = $courseScheduleRepository;
        $this->purchaseRepository = $purchaseRepository;
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @pararm Request $request
     * @param Request $request
     * @param int $courseScheduleId
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function index(Request $request, int $courseScheduleId)
    {
        $optionalExtraIds = $request->optional_extra_id ?? [];
        if (!is_array($optionalExtraIds) && !empty($optionalExtraIds)) {
            $optionalExtraIds = [$optionalExtraIds];
        }
        $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId, $optionalExtraIds);
        $courseSchedule->parent_course_id = $courseSchedule->course->parent_course_id;
        $this->getImageOfSchedule($courseSchedule);
        if (!$courseSchedule) {
            return redirect()->route('client.home');
        }
        if ($courseSchedule->course->user_id === auth('client')->id()) {
            return redirect()->back()->with('error', __('errors.MSG_5034'));
        }

        $cardData = $this->stripePaymentService->getCreditCard();
        $creditCard = $cardData['data'] ?? [];
        $categoryType = $courseSchedule->course->category->type ?? DBConstant::CATEGORY_TYPE_SKILLS;

        return view('client.payment.order', compact('creditCard', 'courseSchedule', 'courseScheduleId', 'categoryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request)
    {
        $paymentType = $request->type ?? null;
        $optionalExtraIds = $request->optional_extra_id ?? [];
        $cardData = $request->only([
            'number',
            'exp_month',
            'exp_year',
            'owner_bank',
            'cvc',
            'owner_bank'
        ]);
        $courseScheduleId = $request->courseScheduleId;
        $mainCourseScheduleId = $request->mainCourseScheduleId;
        try {
            $response = $this->stripePaymentService->addCard($cardData);
            if ($response['success']) {
                $listPaymentMethod = $this->stripePaymentService->getCreditCard(true);
                // delete old payment methods
                foreach ($listPaymentMethod as $paymentMethodId) {
                    if ($response['paymentMethodId'] != $paymentMethodId)
                        $this->stripePaymentService->deletePaymentMethodById($paymentMethodId);
                }
                if ($request->ajax()) {
                    return [
                        'success' => true
                    ];
                }

                // check if sub-course page
                if (!$courseScheduleId) {
                    return redirect()->route('client.student.my-page.account-setting')->with('dataSuccess', trans('message.create_card_success'));
                }
                if ($paymentType) {
                    return redirect()->route('client.orders.payment.sub-course.view', [$mainCourseScheduleId, 'course_schedule_id' => $courseScheduleId, 'optional_extra_id' => $optionalExtraIds])
                        ->with('success', trans('message.create_card_success'));
                }
                return redirect()->route('client.orders.payment.confirm', [$courseScheduleId, 'optional_extra_id' => $optionalExtraIds])
                    ->with('success', trans('message.create_card_success'));
            }
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'errors' => [
                            [
                                'error' => $response['error'],
                                'key' => 'error_card'
                            ]
                        ]
                    ]
                ], 403);
            }
            if (!empty($response['error'])) {
                return redirect()->back()->withInput()->withErrors([
                    'error_card' => $response['error']
                ]);
            }
            return redirect()->back()->withInput()->withErrors([
                'error' => $response['message']
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'errors' => [
                            [
                                'error' => trans('errors.MSG_5035'),
                                'key' => 'error'
                            ]
                        ]
                    ]
                ], 500);
            }
            return redirect()->back()->withInput()->withErrors([
                'error' => trans('errors.MSG_5035')
            ]);
        }
    }

    public function creditConfirmPayment(UpdatePaymentMethodRequest $request)
    {
        $paymentType = $request->type ?? null;
        $optionalExtraIds = $request->optional_extra_id ?? [];
        $cardData = $request->only([
            'number',
            'exp_month',
            'exp_year',
            'owner_bank',
            'cvc',
            'owner_bank'
        ]);
        $courseScheduleId = $request->courseScheduleId;
        $mainCourseScheduleId = $request->mainCourseScheduleId;
        try {
            $response = $this->stripePaymentService->addCard($cardData);
            if ($response['success']) {
                $listPaymentMethod = $this->stripePaymentService->getCreditCard(true);
                // delete old payment methods
                foreach ($listPaymentMethod as $paymentMethodId) {
                    if ($response['paymentMethodId'] != $paymentMethodId)
                        $this->stripePaymentService->deletePaymentMethodById($paymentMethodId);
                }
                if ($request->ajax()) {
                    return [
                        'success' => true
                    ];
                }

                // check if sub-course page
                if (!$courseScheduleId) {
                    return redirect()->route('client.student.my-page.account-setting')->with('dataSuccess', trans('message.create_card_success'));
                }
                if ($paymentType) {
                    return redirect()->route('client.orders.payment.sub-course.view', [$mainCourseScheduleId, 'course_schedule_id' => $courseScheduleId, 'optional_extra_id' => $optionalExtraIds])
                        ->with('success', trans('message.create_card_success'));
                }
                return redirect()->route('client.orders.payment.confirm', [$courseScheduleId, 'optional_extra_id' => $optionalExtraIds])
                    ->with('success', trans('message.create_card_success'));
            }
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'errors' => [
                            [
                                'error' => $response['error'],
                                'key' => 'error_card'
                            ]
                        ]
                    ]
                ], 403);
            }
            if (!empty($response['error'])) {
                return redirect()->back()->withInput()->withErrors([
                    'error_card' => $response['error']
                ]);
            }
            return redirect()->back()->withInput()->withErrors([
                'error' => $response['message']
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'errors' => [
                            [
                                'error' => trans('errors.MSG_5035'),
                                'key' => 'error'
                            ]
                        ]
                    ]
                ], 500);
            }
            return redirect()->back()->withInput()->withErrors([
                'error' => trans('errors.MSG_5035')
            ]);
        }
    }

    /**
     * Confirm payment
     *
     * @param Request $request
     * @param int $courseScheduleId
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function confirmPayment(Request $request, int $courseScheduleId)
    {
        $optionalExtraIds = $request->optional_extra_id ?? [];
        $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId, $optionalExtraIds);
        if (!$courseSchedule) {
            return redirect()->route('client.home');
        }
        $categoryType = $courseSchedule->course->category->type ?? DBConstant::CATEGORY_TYPE_SKILLS;
        return view('client.payment.confirm-order', compact('courseSchedule', 'courseScheduleId', 'categoryType'));
    }

    /**
     * @param SubmitPaymentRequest $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function submitPayment(SubmitPaymentRequest $request)
    {
        $courseScheduleId = $request->courseScheduleId;
        $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId);
        if (!$courseSchedule) {
            return redirect()->back()->withErrors([
                'error' => 'errors.MSG_5036'
            ]);
        }
        $courseSchedulePrice = $courseSchedule->price ?? 0;
        $optionalPrice = $courseSchedule->optional_price_sum;

        $paymentData = [
            'name' => $courseSchedule->title,
            'price' => $courseSchedulePrice + $optionalPrice,
            'points_package_id' => null
        ];
        $response = $this->stripePaymentService->createCheckout($paymentData);
        if ($response['success']) {
            return redirect()->to($response['data']['url']);
        }
        return redirect()->back()->withErrors([
            'error' => __('errors.MSG_5038')
        ]);
    }

    /**
     * Callback when payment success
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function processPayment(Request $request)
    {
        $orderNo = $request->order_no ?? null;
        $purchase = $this->purchaseRepository->getPurchaseByOrderNo($orderNo);
        if ($purchase) {
            $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($purchase->course_schedule_id);
            $courseType = $courseSchedule->course->type ?? null;
            if ($courseType === DBConstant::COURSE_TYPE_SUB) {
                $mainCourseScheduleId = $request->main_course_schedule_id ?? null;
                return view('client.payment.subcourse-complete', compact('courseSchedule', 'mainCourseScheduleId'));
            }
            $optionExtras = $purchase->purchaseDetails ?? [];
            if ($courseSchedule) {
                $categoryType = $courseSchedule->course->category->type ?? DBConstant::CATEGORY_TYPE_SKILLS;
            } else {
                $categoryType = DBConstant::CATEGORY_TYPE_SKILLS;
            }
            $courseScheduleOpen = $this->courseScheduleRepository->listAllCourseScheduleOpen($courseSchedule->course_id)
                ->filter(function ($cs) {
                    return !$cs->purchase_id;
                })->first();
            $courseScheduleId = $courseSchedule->course_schedule_id;
            if ($courseScheduleOpen) {
                $courseScheduleId = $courseScheduleOpen->course_schedule_id;
            }
            return view('client.payment.order-complete', compact('courseSchedule', 'optionExtras', 'purchase', 'categoryType', 'courseScheduleId'));
        }
        return redirect()->route('client.home');
    }

    /**
     * @param $courseScheduleId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function subCourseScheduleDetail($courseScheduleId)
    {
        $subCourse = $this->courseService->getSubCourseDetail($courseScheduleId);

        if (!$subCourse->courseSchedules->count()) {
            throw new ModelNotFoundException();
        }
        $totalPurchased = 0;
        foreach ($subCourse->courseSchedules as $courseSchedule) {
            if ($courseSchedule->purchases->count() !== 0) {
                $totalPurchased++;
            }
        }
        $disabled = $totalPurchased === $subCourse->courseSchedules->count();

        return view('client.payment.subcourse-edit', compact('subCourse', 'courseScheduleId', 'disabled'));
    }

    /**
     * @param $courseScheduleId
     */
    public function viewSubCourseOrder($mainCourseScheduleId, Request $request)
    {
        $courseScheduleId = $request->course_schedule_id ?? null;

        $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId);
        if ($courseSchedule->course->user_id === Auth::guard('client')->user()->user_id) {
            return view('common.404');
        }
        $numOfApplicant = $courseSchedule->num_of_applicants ?? null;

        if (!isset($courseSchedule)) {
            $message = 'コースの購入は過去のものです';
            return view('client.payment.subcourse-order', compact('message'));
        }

        if ($numOfApplicant > 0) {
            $message = 'この講座は購入できません';
            return view('client.payment.subcourse-order', compact('message'));
        }

        $cardData = $this->stripePaymentService->getCreditCard();
        $creditCard = $cardData['data'] ?? [];
        return view('client.payment.subcourse-order', compact('creditCard', 'courseSchedule', 'courseScheduleId', 'mainCourseScheduleId'));
    }

    /**
     * @param Request $request
     */
    public function getViewSubCourseOrder(Request $request)
    {
        $courseScheduleId = $request->course_schedule_id;
        $mainCourseScheduleId = $request->mainCourseScheduleId ?? null;

        if ($courseScheduleId) {
            return redirect()->route('client.orders.payment.sub-course.view', [$mainCourseScheduleId, 'course_schedule_id' => $courseScheduleId]);
        }
        return redirect()->back();
    }

    /**
     * Get view confirm sub Course order
     *
     * @param $courseScheduleId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function confirmSubCourseOrder($mainCourseScheduleId, Request $request)
    {
        $courseScheduleId = $request->course_schedule_id ?? null;
        $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId);
        if (!$courseSchedule) {
            return redirect()->route('client.home');
        }
        return view('client.payment.subcourse-confirm', compact('courseSchedule', 'courseScheduleId', 'mainCourseScheduleId'));
    }

    public function edit($courseScheduleId)
    {
        $cardData = $this->stripePaymentService->getCreditCard();
        $creditCard = $cardData['data'] ?? [];

        return view('client.payment.edit-payment')->with([
            'courseScheduleId' => $courseScheduleId,
            'creditCard' => $creditCard
        ]);
    }
}
