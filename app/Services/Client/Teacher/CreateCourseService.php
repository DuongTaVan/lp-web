<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Http\Requests\Client\Course\CreateCourseRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\BaseService;
use App\Services\Client\Student\Course\CourseRestockService;
use App\Traits\CourseTrait;
use App\Traits\ManageFile;
use App\Traits\PromotionTrait;
use Illuminate\Support\Facades\DB;
use Tuupola\Base62Proxy as Base62;

class CreateCourseService extends BaseService
{
    private $imagePathRepository;
    private $courseRestockService;
    private $courseScheduleRepository;
    private $optionalExtra;
    private $optionalExtraMapping;
    use ManageFile, CourseTrait, PromotionTrait;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseRestockService = app(CourseRestockService::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->optionalExtra = app(OptionalExtraRepository::class);
        $this->optionalExtraMapping = app(OptionalExtraMappingRepository::class);
    }

    public function repository()
    {
        return CourseRepository::class;
    }

    /**
     * Create course.
     *
     * @param CreateCourseRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateCourseRequest $request)
    {
        DB::beginTransaction();
        try {
            $start = [];

            if ($request->start_day && $request->start_time && $request->minutes_required) {
                //Get list course schedules opening of user .
                foreach ($request->start_day as $key => $value) {
                    $start[] = $value . ' ' . $request->start_time[$key] . ':00';
                }
                $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->minutes_required);
                if ($existTime) {
                    return back()->withInput()->withErrors(['start_day' => __('errors.MSG_5050')]);
                }
            } else {
                $request->merge(['minutes_required' => 0]);
            }

            // Create main course
            $group = $request->group ?? strtoupper(Base62::encode(random_bytes(5)));
            $request->merge(['group' => $group]);
            $course = $this->createMainCourse($request);

            $createCs = $this->createCourseSchedule($request, $course);

            $createCsNew = $createCs['new'];

            if ($createCsNew) {
                $this->courseRestockService->restockCourse($course->parent_course_id, $course->course_id);
            }
            $this->createExtension($request, $course);

            $this->createOption($request, $course);

            // save image
            $this->saveImageSchedules($request, $createCsNew, true);
            $this->saveImage($request, $course->course_id);

            DB::commit();
            if ((int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_DRAFT) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])
                    ->with('success', __('message.add_success'));
            }
            if ($createCsNew && $request->screen === 'LIVESTREAM-2') {
                return redirect()->route('client.teacher.courses.show', $course->course_id);
            }
            // send event realtime
            if ((int)$course->approval_status === DBConstant::COURSE_APPROVED_STATUS_PENDING && (int)$course->status === DBConstant::COURSE_STATUS_OPEN) {
                \Log::info("Send event create course " . $course->course_id);
                $this->sendEvent('realtime', [
                    'url' => '/portal/courses',
                    'screen' => 'COURSE',
                    'id' => $course->course_id
                ]);
            }

            // check course public first & send mail.
            if ((int)$request->status === DBConstant::COURSE_STATUS_OPEN && $course->approval_status === DBConstant::COURSE_APPROVED) {
                $this->checkPromotion(auth('client')->id(), $course->course_id, true);
            }

            if (auth('client')->user()->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS) {
                if (isset($course) && $course->approval_status === DBConstant::APPROVAL_STATUS_COURSE) {
                    return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_step_one_course'));
                }

                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_approval_course'));
            }
            return redirect()->route('client.teacher.my-page.service-list')->with('success', __('message.request_approval_course'));
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return back()->with('error', __('errors.MSG_5000'))->withInput();
        }
    }
}
