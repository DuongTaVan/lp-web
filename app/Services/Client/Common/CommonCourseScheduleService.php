<?php

declare(strict_types=1);

namespace App\Services\Client\Common;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepositoryEloquent;
use App\Repositories\FollowRepository;
use App\Repositories\FollowRepositoryEloquent;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\PageViewRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Services\BaseService;
use App\Traits\CourseImageTrait;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\Auth;

class CommonCourseScheduleService extends BaseService
{
    use ManageFile, CourseImageTrait;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private $imagePathRepository;
    private $courseRepository;
    private $applicantRepository;
    private $followRepository;
    private $reviewRepository;
    private $optionalExtraMappingRepository;
    private $pageViewRepository;
    private $userRepository;
    private $purchaseDetailRepository;
    private $purchaseRepository;

    /**
     * CourseScheduleService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->followRepository = app(FollowRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
        $this->optionalExtraMappingRepository = app(OptionalExtraMappingRepository::class);
        $this->pageViewRepository = app(PageViewRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepositoryEloquent::class;
    }

    /**
     * Course Schedule Detail.
     *
     * @param int $courseScheduleId
     * @return null|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string
     */
    public function courseScheduleDetail(int $courseScheduleId)
    {
        // Get user_id login
        $userId = \Auth::guard('client')->id();

        // 1-1 Get course schedule.
        $courseSchedule = $this->repository->courseSchedule($courseScheduleId);

        // check course schedule is purchased
        $purchaseCourse = $this->purchaseRepository->getPurchaseByUserCourseSchedule($userId, $courseScheduleId);
        if ($purchaseCourse
            || $courseSchedule->num_of_applicants >= $courseSchedule->fixed_num
            || $courseSchedule->purchase_deadline <= now()
        ) {
            $courseScheduleOpen = $this->repository->listAllCourseScheduleOpen($courseSchedule->course_id)
                ->filter(function ($cs) {
                    return !$cs->purchase_id;
                })->first();
            if ($courseScheduleOpen) {
                return [
                    'success' => true,
                    'course_schedule_open' => $courseScheduleOpen->course_schedule_id
                ];
            }
        }
        // end check

        $courseScheduleDisable = false;
        if (\Auth::guard('client')->check()) {
            $courseScheduleDetail = $this->repository->getCourseScheduleDetail($courseScheduleId);
            $courseScheduleDisable = true;
            if ($courseScheduleDetail != null) {
                $courseScheduleDisable = false;
            }
        }

        $course = $this->courseRepository->getCourseSchedule($courseScheduleId);
        // Set appends attribute in model
        if ($course) {
            $course->setAppends([
                'identity_verification_status_text',
                'business_card_verification_status_text',
                'nda_status_text'
            ]);

            $course->profile_image = $this->getS3FileUrl($course->profile_image) ?? asset('assets/img/clients/header-common/not-login.svg');

            $images = $this->getImagesOfSchedule($course)->imagePaths;

            $imagePath = [];
            foreach ($images as $image) {
                $imagePath[] = $image->image_url;
            }
            // 1-4) Get all the course schedule list
            $courseScheduleList = $this->repository->listAllCourseScheduleOpen($course['course_id']);
            $courseScheduleList =  $courseScheduleList->filter(function ($item) {
                return !$item->purchase_id;
            });
            $courseScheduleList =  $courseScheduleList->filter(function ($item) use ($courseSchedule) {
                return $item->course_schedule_id !== $courseSchedule->course_schedule_id;
            });
            $courseScheduleList->prepend($courseSchedule)->values();

            $this->getImageOfSchedules($courseScheduleList);
            $courseSchedulePurchases = $this->repository->courseSchedulePurchases($course['course_id']);

            //1-5 get option data.
            $optionData = $this->optionalExtraMappingRepository->getOptionData($courseScheduleId);

            // 1-6 Get the data of "開催実績".
            $countHoldingCourseSchedule = $this->repository->getCountCourseSchedule($course['course_id']);

            // 1-7 Get the data of "フォロワー".
            $countApplicants = $this->applicantRepository->getCountApplicant($course['course_id']);

            // 1-8 Get the data of "フォロワー" (follower).
            $countFollower = $this->followRepository->getCountFollow($course['user_id']);

            //1-9 Get the data of "評価、感想".
            $reviewsData = $this->reviewRepository->getReviewData($course['course_id']);

            $courseSchedulePurchased = null;
            $optionExtraPurchased = null;
            //1-10 Add page view.
            if (Auth::guard('client')->check()) {
                $this->pageViewRepository->create([
                    'user_id' => $userId,
                    'view_count' => 1,
                    'is_top_page' => 0,
                    'is_skills' => (int)$course['category_type'] === 1 ? 1 : 0,
                    'is_consultation' => (int)$course['category_type'] === 2 ? 1 : 0,
                    'is_fortunetelling' => (int)$course['category_type'] === 3 ? 1 : 0,
                    'to_user_id' => $course['user_id'],
                    'to_course_schedule_id' => $courseScheduleId,
                    'viewed_at' => now(),
                ]);

                $courseSchedulePurchased = $this->applicantRepository->findWhere([
                    'user_id' => auth('client')->id(),
                    'course_schedule_id' => $courseScheduleId
                ])->whereNull('canceled_at')->isNotEmpty();

                $purchased = $this->purchaseRepository
                    ->where([
                        'user_id' => $userId,
                        'course_schedule_id' => $courseScheduleId,
                    ])
                    ->whereNull('canceled_at')
                    ->first();
                if ($purchased) {
                    foreach ($optionData as $optionExtra) {
                        $purchaseDetail = $this->purchaseDetailRepository
                            ->where([
                                'purchase_details.purchase_id' => $purchased->purchase_id,
                                'optional_extra_id' => $optionExtra->optional_extra_id
                            ])
                            ->first();
                        $optionExtra->isPurchased = (bool)$purchaseDetail;
                    }
                    $optionExtraPurchased = $this->purchaseDetailRepository
                        ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.purchase_id')
                        ->where([
                            'purchase_details.course_schedule_id' => $courseScheduleId,
                            'purchases.user_id' => \auth()->guard('client')->user()->user_id,
                            'purchases.course_schedule_id' => $courseScheduleId,
                            'purchase_details.purchase_id' => $purchased->purchase_id
                        ])
                        ->whereNull('purchases.canceled_at')->get();
                }
            }
            $followed = false;
            if ($userId && $course) {
                // 1-1) Check if the user has already followed the teacher.
                $follow = $this->followRepository->where([
                    'from_user_id' => $userId,
                    'to_user_id' => $course['user_id']
                ])->first();


                if ($follow) {
                    $followed = true;
                }
            }

            return [
                'success' => true,
                'courses' => $course,
                'images' => $imagePath,
                'followed' => $followed,
                'courseScheduleList' => $courseScheduleList->toArray(),
                'courseSchedulePurchases' => $courseSchedulePurchases->toArray(),
                'optionData' => $optionData,
                'countHoldingCourseSchedule' => $countHoldingCourseSchedule,
                'countApplicants' => $countApplicants,
                'countFollower' => $countFollower,
                'reviewsData' => $reviewsData,
                'courseSchedulePurchased' => $courseSchedulePurchased,
                'courseScheduleDisable' => $courseScheduleDisable,
                'optionExtraPurchased' => $optionExtraPurchased,
                'courseSchedule' => $courseSchedule,
            ];
        }

        return [
            'success' => false,
        ];
    }

    public function fetchDataCourseSchedule($courseScheduleId)
    {
        // 1-1) Get course schedule.
        $courseSchedule = $this->courseRepository->getCourseSchedule($courseScheduleId);
        //1-8) Get the data of "評価、感想".
        return $this->reviewRepository->getReviewData($courseSchedule['course_id']);
    }

}
