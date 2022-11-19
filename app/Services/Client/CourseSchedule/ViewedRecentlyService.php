<?php

namespace App\Services\Client\CourseSchedule;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PageViewRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\DB;

class ViewedRecentlyService extends BaseService
{
    use ManageFile;

    private $firebaseService;
    private $purchaseRepository;
    private $userRepository;
    private $courseRepository;

    /**
     * @return string
     */
    public function repository()
    {
        return PageViewRepository::class;
    }

    public function __construct()
    {
        parent::__construct();
        $this->firebaseService = app(FirebaseService::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    public function listCourseScheduleViewed()
    {
        $now = now()->getTimestampMs();
        $pv = $this->repository
            ->join('course_schedules', 'course_schedules.course_schedule_id', '=', 'page_views.to_course_schedule_id')
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->join('users', 'users.user_id', 'courses.user_id')
            ->join('categories', 'courses.category_id', 'categories.category_id')
            ->leftJoin('restocks', 'restocks.course_id', 'courses.course_id')
            ->leftJoin('image_paths', function ($q) {
                $q->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where('image_paths.display_order', DBConstant::DISPLAY_ORDER_IMAGE_PATH)
                    ->where('image_paths.type', Constant::IMAGE_TYPE)
                    ->where('image_paths.status', Constant::IMAGE_STATUS);
            })
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id())
                    ->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
            })
            ->where('page_views.user_id', auth('client')->id())
            ->whereNotNull('page_views.to_course_schedule_id')
            ->orderBy('page_views.viewed_at', 'ASC')
            ->select(DB::raw('
                ROW_NUMBER() OVER(PARTITION BY courses.course_id ORDER BY page_views.viewed_at ASC) rowNumber,
                page_views.to_course_schedule_id,
                course_schedules.course_schedule_id,
                course_schedules.course_id,
                course_schedules.title,
                course_schedules.price,
                course_schedules.status,
                course_schedules.start_datetime,
                course_schedules.end_datetime,
                course_schedules.purchase_deadline,
                course_schedules.num_of_applicants,
                courses.num_of_ratings,
                courses.user_id,
                courses.rating,
                users.nickname,
                users.last_name_kanji,
                users.profile_image,
                users.first_name_kanji,
                users.name_use,
                users.user_type,
                users.user_status,
                categories.type as category_type,
                image_paths.file_name as file_name,
                image_paths.dir_path as dir_path,
                restocks.status as restock_status,
                purchases.user_id as p_user_id
            '))
            ->get();

        $pv = $pv->filter(function ($item) {
            return $item->rowNumber === 1;
        });
        foreach ($pv as $schedule) {
            $course = $schedule;
            $courseSchedules = $schedule->courseSchedules;
            if (!$courseSchedules) {
                $schedule['is_restock'] = true;
                continue;
            }
            $isPurchase = 0;

            $scheduleStatus = $courseSchedules->filter(function ($cs) use ($course, &$isPurchase) {
                $userPurchased = $this->purchaseRepository->findWhere([
                    'user_id' => auth('client')->id(),
                    'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
                    'course_schedule_id' => $cs->course_schedule_id
                ])->count();

                if ($userPurchased === 0 && $cs->fixed_num > $cs->num_of_applicants && $cs->purchase_deadline > now()->format('Y-m-d H:i:s')) {
                    $isPurchase++;
                }
                if ($isPurchase > 1) {
                    $course['isPurchase'] = true;
                } else {
                    $course['isPurchase'] = false;
                }
                if ($course['category_type'] !== 1) {
                    return $cs['status'] === 0 && $cs['purchase_deadline'] > now()->format('Y-m-d H:i:s') && $cs['num_of_applicants'] < 1;
                }

                return $cs['status'] === 0 && $cs['purchase_deadline'] > now()->format('Y-m-d H:i:s');
            });
            $countSchedule = count($scheduleStatus);
            if ($countSchedule > 0) {
                $schedule['is_open'] = $countSchedule;
                $schedule['is_restock'] = false;
            } else {
                $schedule['is_restock'] = true;
            }
        }

        return $pv;
    }
}
