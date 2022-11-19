<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Models\ImagePath;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Services\BaseService;
use App\Traits\CourseImageTrait;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CourseScheduleService extends BaseService
{
    use CourseImageTrait, ManageFile;

    private $imagePathRepository;
    private $courseRepository;

    public function __construct()
    {
        parent::__construct();
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * Get course.
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $courseSchedule = $this->repository
            ->with(['course' => function ($query) {
                $query->where('is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG)->with(['category', 'user']);
            }])
            ->findWhere([
                'course_schedule_id' => $id,
            ])
            ->first();
        $courseSchedule->parent_course_id = $courseSchedule->course->parent_course_id;
        $this->getImageOfSchedule($courseSchedule);
        return $courseSchedule;
    }

    /**
     * Get extend course.
     *
     * @param int $id
     * @return mixed
     */
    public function getLastExtendPurchased(int $id)
    {
        return $this->repository
            ->orderBy('end_datetime', 'DESC')
            ->findWhere([
                'parent_course_schedule_id' => $id,
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
                'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
            ])
            ->first();
    }

    /**
     * Get sub course detail
     *
     * @param int $courseId
     * @return array
     */
    public function getSubCourseDetail(int $courseId)
    {
        $sub = $this->courseRepository
            ->where([
                'parent_course_id' => $courseId,
                'type' => DBConstant::COURSE_TYPE_SUB,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->first();
        $schedule = [];
        if ($sub) {
            $schedule = $this->repository
                ->where([
                    'course_id' => $sub->course_id,
                    ['purchase_deadline', '>=', Carbon::now()],
                    'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                    'status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN
                ])
                ->orderBy('start_datetime')
                ->get();
        }

        return [
            'sub' => $sub,
            'schedules' => $schedule
        ];
    }


    /**
     * Get all sub course detail
     *
     * @param $courseId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getAllSubCourseDetail($courseId)
    {
        return $this->courseRepository
            ->rightJoin('course_schedules as cs', 'cs.course_id', '=', 'courses.course_id')
            ->where([
                'courses.type' => DBConstant::COURSE_TYPE_SUB,
                'courses.parent_course_id' => $courseId,
                ['cs.purchase_deadline', '>=', Carbon::now()],
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'cs.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->select('courses.*', 'courses.title as title_course', 'cs.*')
            ->orderBy('start_datetime')
            ->get();
    }

    /**
     * Get course parent.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getCourseParent($courseScheduleId)
    {
        return $this->repository->findOrFail($courseScheduleId);
    }

    /**
     * @return mixed
     */
    public function imagePaths()
    {
        return $this->hasMany(ImagePath::class, 'course_id', 'course_id');
    }

    /**
     * Get course schedules .
     *
     * @param $coursesId
     * @param $timeSubCourseSchedule
     * @return mixed
     */
    public function getCourseSchedules($coursesId, $timeSubCourseSchedule)
    {
        return $this->repository->getCourseSchedules($coursesId, $timeSubCourseSchedule);
    }

    /**
     * Add time actual to teacher and student.
     *
     * @param $courseScheduleId
     * @return null
     */
    public function addTimeActual($courseScheduleId)
    {
        $courseSchedule = $this->repository->find($courseScheduleId);
        //update actual start date when teacher join course
        if (isset($courseSchedule) && now()->gt(now()->parse($courseSchedule->start_datetime))) {
            if (!isset($courseSchedule->actual_start_date)) {
                $courseSchedule->update([
                    'actual_start_date' => now()->format('Y-m-d H:i:s'),
                    'actual_end_date' => Carbon::now()->addMinute($courseSchedule->minutes_required)->format('Y-m-d H:i:s')
                ]);
            }
            return $courseSchedule->actual_end_date->toString();
        }
        return null;
    }

    /**
     * get time end string.
     *
     * @param $courseScheduleId
     * @return false|int
     */
    public function getTimeEndString($courseScheduleId)
    {
        $courseSchedule = $this->repository->find($courseScheduleId);

        //update actual start date when teacher join course
        if (isset($courseSchedule)) {
            if (isset($courseSchedule->actual_end_date)) {
                return $courseSchedule->actual_end_date->toString();
            }

        }
        return false;
    }

    /**
     * @param $request
     * @param $courseScheduleId
     */
    public function previewCourseSchedule($request, $courseScheduleId)
    {
        $user = auth()->guard('client')->user();
        $formData = $request->all();
        try {
            $course = $this->repository
                ->find($courseScheduleId);
            $rating = $this->courseRepository->getTheRatingOfCourse($course->course_id);
            $avgRating = $rating->avg('rating') ?? 0;
            $sumRating = $rating->sum('num_of_ratings') ?? 0;

            $course['title'] = $formData['title'] ?? '';
            $course['subtitle'] = $formData['subtitle'] ?? '';
            $course['body'] = $formData['body'] ?? '';
            $course['flow'] = $formData['flow'] ?? '';
            $course['cautions'] = $formData['cautions'] ?? '';
            $startDate = $formData['start_day'] . ' ' . $formData['start_time'] . ':00';
            $course['start_datetime'] = now()->parse($startDate);
            $course['end_datetime'] = now()->parse($startDate)->addMinutes((int)$formData['minutes_required']);
            $course['purchase_deadline'] = now()->parse($startDate)->subHour();
            $course['is_mask_required'] = isset($formData['is_mask_required']) ? (int)$formData['is_mask_required'] : 0;
            $course['price'] = $formData['price'] ?? 0;

            // Extension
            // extension course
            $extensionCourses = [];
            if (isset($formData['time'])) {
                foreach ($formData['time'] as $key => $time) {
                    if ($time && $formData['money'][$key]) {
                        $extensionCourses[] = [
                            'user_id' => $user->user_id,
                            'status' => '',
                            'is_mask_required' => $request->is_mask_required ?? '',
                            'type' => DBConstant::COURSE_TYPE_EXTENSION,
                            'parent_course_id' => "",
                            'minutes_required' => $time,
                            'price' => $formData['money'][$key],
                            'fixed_num' => $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN,
                            'dist_method' => DBConstant::DIST_METHOD_LIVE_VIDEO_CALL,
                            'rating' => DBConstant::RATING_DEFAULT,
                            'num_of_ratings' => DBConstant::NUM_OF_RATING_DEFAULT,
                            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                            'approval_status' => DBConstant::COURSE_APPROVED,
                            'group' => '',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
            $course['extensionsOpen'] = $extensionCourses;
            // image
            $paths = [];
            if (isset($formData['previewOld'])) {
                foreach ($formData['previewOld'] as $oldPreview) {
                    $val = json_decode($oldPreview, true);
                    $paths[] = [
                        'image_url' => $val['fullPath']
                    ];
                }
            }

            // option extra
            $optionalExtras = [];
            if (isset($formData['extra_title'])) {
                for ($i = 0, $iMax = count($formData['extra_title']); $i < $iMax; $i++) {
                    if ($formData['extra_title'][$i]) {
                        $optionalExtras[] = [
                            'title' => $formData['extra_title'][$i],
                            'price' => $formData['extra_price'][$i],
                            'course_id' => '',
                        ];
                    }
                }
            }

            $course['optionalExtras'] = $optionalExtras;

            if ($request->file('preview')) {
                $imagePaths = $this->saveTmpFile($request->file('preview'));
                if (count($imagePaths) > 0) {
                    $course['imagePaths'] = [];
                    foreach ($imagePaths as $image) {
                        $paths[] = [
                            'image_url' => $image['fullPath']
                        ];
                    }
                }
            }
            $course['imagePaths'] = $paths;

            $data = [
                'course' => $course,
                'isSchedule' => true,
                'user' => $user,
                'avgRating' => $avgRating,
                'sumRating' => $sumRating,
                'isClone' => false,
                'group' => '',
                'isPublic' => true
            ];
            return response([
               'success' => true,
               'html' => view('client.screen.teacher.my-page.course.course-preview')->with($data)->render()
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response([
               'success' => false
            ], 500);
        }
    }
}
