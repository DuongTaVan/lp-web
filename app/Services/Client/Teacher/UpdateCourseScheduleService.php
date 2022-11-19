<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Http\Requests\Client\Course\UpdateCourseSchedule;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Traits\CourseTrait;
use App\Traits\ManageFile;
use App\Traits\PromotionTrait;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UpdateCourseScheduleService extends BaseService
{
    private $courseRepository;
    private $imagePathRepository;
    private $optionalExtra;
    private $optionalExtraMapping;
    use ManageFile, CourseTrait, PromotionTrait;

    public function __construct()
    {
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->optionalExtra = app(OptionalExtraRepository::class);
        $this->optionalExtraMapping = app(OptionalExtraMappingRepository::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    public function update(UpdateCourseSchedule $request)
    {
        DB::beginTransaction();
        try {
            //If the main course is not public, it will not be possible to make the secondary course public
            $cs = $this->repository->find($request->course_schedule_id);
            if (!isset($cs)) {
                return redirect()->back()->with([
                    'message' => 'コースは存在しません',
                    'alert-type' => 'error',
                ]);
            }

            $isSubCourse = $cs->course->type === DBConstant::COURSE_TYPE_SUB;
            if ($isSubCourse) {
                $mainCourse = $this->courseRepository->find($cs->course->parent_course_id);
                if (isset($mainCourse)) {
                    $courseScheduleMain = $this->repository->where([
                        'course_id' => $mainCourse->course_id,
                        'status' => DBConstant::STATUS_COURSE_SCHEDULE_OPEN
                    ])->count();
                    if (!$courseScheduleMain) {
                        return redirect()->back()->with([
                            'message' => 'サービスを公開していない限り、個別講座を公開できません。',
                            'alert-type' => 'error',
                        ]);
                    }
                }
            }

            $currentCsStatus = $cs->status;

            $schedule = $this->updateCourseSchedule($request);

            // update course
            if (!(int)$request->screen) {
                $this->courseRepository->update([
                    'is_mask_required' => $request->is_mask_required ?? 0
                ], $schedule->course_id);
                $this->createExtension($request, $schedule->course, $currentCsStatus, $schedule->group);
                $this->createOptionSchedule($request, $schedule);
            }
            if (!$isSubCourse) {
                $this->saveImageSchedule($request, $schedule->course_schedule_id);
            }

            // check course public first & send mail.
            if ((int)$request->status === DBConstant::COURSE_STATUS_OPEN) {
                $this->checkPromotion(auth('client')->id(), $schedule->course_id, true);
            }

            DB::commit();

            if ((int)$request->screen) {
                return redirect()->route('client.teacher.my-page.service-list')->with([
                    'message' => '更新しました。',
                    'alert-type' => 'success',
                ]);
            }

            if ((int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_DRAFT) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])
                    ->with('success', __('message.add_success'));
            }
            return redirect()->route('client.teacher.my-page.service-list')->with('success', __('message.request_approval_course'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }
}
