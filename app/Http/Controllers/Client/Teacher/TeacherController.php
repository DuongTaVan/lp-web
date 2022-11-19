<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Course\CreateCourseRequest;
use App\Http\Requests\Client\Course\PreviewCloneCourse;
use App\Http\Requests\Client\Course\PreviewCourseSchedule;
use App\Http\Requests\Client\Course\PublicCourseRequest;
use App\Http\Requests\Client\Course\UpdateCourseRequest;
use App\Http\Requests\Client\Course\ValidateCourseRequest;
use App\Repositories\CourseScheduleRepository;
use App\Services\Client\Teacher\CourseScheduleService;
use App\Services\Client\Teacher\CourseService;
use App\Services\Client\Teacher\CreateCourseScreenService;
use App\Services\Client\Teacher\CreateCourseService;
use App\Services\Client\Teacher\ShowCourseService;
use App\Services\Client\Teacher\TeacherService;
use App\Services\Client\Teacher\UpdateCourseService;
use App\Traits\ManageFile;
use Illuminate\Http\Request;
use Tuupola\Base62Proxy as Base62;

class TeacherController extends Controller
{
    use ManageFile;

    /**
     * @var TeacherService
     */
    private $teacherService;

    /**
     * TeacherController constructor.
     *
     * @param TeacherService $teacherService
     */
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Cancel the captured settlement on Stripe.
     *
     * @param int $courseScheduleId
     *
     * @return array|bool[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function cancelCourse(int $courseScheduleId)
    {
        return $this->teacherService->cancelCourse($courseScheduleId);
    }

    /**
     * @param CreateCourseScreenService $service
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(CreateCourseScreenService $service)
    {
        $user = auth()->guard('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        //If the user is not authenticated, the course cannot be created.

        if ($user->identity_verification_status != \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED) {
            return view('common.403');
        }
        $data = $service->redirectScreenCreate();
        return view('client.screen.teacher.my-page.course.create')->with($data);
    }

    /**
     * @param CreateCourseRequest $request
     * @param CreateCourseService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCourseRequest $request, CreateCourseService $service)
    {
        $user = auth()->guard('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        //If the user is not authenticated, the course cannot be created.
        if (auth()->guard('client')->user()->identity_verification_status != \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED) {
            return;
        }
        return $service->create($request);
    }

    /**
     * @param int $courseId
     * @param ShowCourseService $service
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function show(int $courseId, ShowCourseService $service, Request $request)
    {
        if (!$request->isClone && $request->group) {
            $data = $service->getDataGroup($courseId, $request);
        } else {
            $data = $service->getData($courseId, $request);
        }
        $data['isClone'] = (bool)$request->isClone;
        if ($data['course']->approval_status === DBConstant::COURSE_REJECT) {
            return view('common.404');
        }

        if ($data['course']->dist_method === DBConstant::DIST_METHOD_LIVE_STREAMING) {
            if ($request->isClone) {
                $data['label'] = [
                    'screen' => 'LIVESTREAM-3',
                    'step' => 'STEP 3',
                    'title' => '開催日程の設定',
                    'deg' => 360
                ];
            } else if ($data['course']->approval_status === DBConstant::COURSE_NOT_REVIEW) {
                $data['label'] = [
                    'screen' => 'LIVESTREAM-1',
                    'step' => 'STEP 1',
                    'title' => 'サービスを作成し公開を申請する',
                    'deg' => 120
                ];
            } else if (!count($data['course']->courseSchedules)) {
                $data['label'] = [
                    'screen' => 'LIVESTREAM-2',
                    'step' => 'STEP 2',
                    'title' => '開催日程の設定',
                    'deg' => 240
                ];
            } else {
                $data['label'] = [
                    'screen' => 'LIVESTREAM-3',
                    'step' => 'STEP 3',
                    'title' => '開催日程の設定',
                    'deg' => 360
                ];
            }
        } else {
            $data['label'] = [
                'screen' => auth('client')->user()->teacher_category_consultation ? 'CONSULTATION' : 'FORTUNE',
            ];
        }
        $data['label']['clone'] = (bool)$request->isClone;
        $data['MAX_COURSE'] = $request->isClone || $request->group ? $data['course']->maxScheduleCanCreate : DBConstant::MAX_COURSE_SCHEDULE;
        $data['group'] = $request->group;
        return view('client.screen.teacher.my-page.course.edit')->with($data);
    }

    /**
     * @param ValidateCourseRequest $request
     */
    public function previewCourse(ValidateCourseRequest $request)
    {
        if ($request->start_day && $request->start_time && $request->minutes_required) {
            $this->courseScheduleRepository = $this->courseScheduleRepository ?? app(CourseScheduleRepository::class);
            //Get list course schedules opening of user .
            foreach ($request->start_day as $key => $value) {
                $start[] = $value . ' ' . $request->start_time[$key] . ':00';
            }
            $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->minutes_required);
            if ($existTime) {
                return response()->json(
                    [
                        'data' => [
                            'errors' => [
                                [
                                    'key' => 'start_day',
                                    'error' => __('errors.MSG_5050')
                                ]
                            ]
                        ]
                    ], 422
                );
            }
        }
        $formData = $request->except('preview');
        $user = auth()->guard('client')->user();
        try {
            $formData['imagePaths'] = [];
            $formData['course_id'] = '';
            $formData['approval_status'] = (!$request->parent_course_id && $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS && $request->screen === 'LIVESTREAM-1') ?
                DBConstant::COURSE_NOT_REVIEW : DBConstant::COURSE_APPROVED;
            $formData['optionalExtras'] = [];
            $formData['is_mask_required'] = isset($formData['is_mask_required']) ? (int)$formData['is_mask_required'] : 0;
            $formData['dist_method'] = $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::DIST_METHOD_LIVE_STREAMING : DBConstant::DIST_METHOD_LIVE_VIDEO_CALL;
            $imagePaths = [];
            if ($request->file('preview')) {
                $imagePaths = $this->saveTmpFile($request->file('preview'));
            }
            foreach ($imagePaths as $image) {
                $formData['imagePaths'][] = [
                    'image_url' => $image['fullPath']
                ];
            }
            $start = [];
            if ($request->start_day) {
                foreach ($request->start_day as $key => $value) {
                    $start[] = $value . ' ' . $request->start_time[$key] . ':00';
                }
            }
            // course schedules
            $courseSchedules = [];
            if (count($start)) {
                foreach ($start as $time) {
                    $channel = Base62::encode(random_bytes(10));
                    $startDate = now()->parse($time);
                    $endDate = now()->parse($startDate)->addMinutes((int)$request->minutes_required);
                    $purchaseDeadline = now()->parse($startDate)->subHour();
                    $courseSchedules[] = [
                        'course_id' => '',
                        'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                        'status' => $request->is_clone && (int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW ? DBConstant::COURSE_SCHEDULES_STATUS_CLONE : $request->status,
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'body' => $request->body,
                        'flow' => $request->flow,
                        'cautions' => $request->cautions,
                        'minutes_required' => $request->minutes_required ?? "",
                        'price' => $request->price,
                        'fixed_num' => $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN,
                        'num_of_applicants' => DBConstant::NUM_OF_APPLICANT,
                        'purchase_deadline' => $purchaseDeadline,
                        'start_datetime' => $startDate,
                        'end_datetime' => $endDate,
                        'agora_channel' => $channel,
                        'agora_token' => null,
                        'group' => '',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'is_mask_required' => $request->is_mask_required ?? "",
                        'dist_method' => $formData['dist_method'],
                        'hour_minute' => $startDate->format('H:i') . ' - ' . $endDate->format('H:i')
                    ];
                }
            }
            $formData['courseSchedules'] = $courseSchedules;
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
            $formData['extensionsOpen'] = $extensionCourses;

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
            $formData['optionalExtras'] = $optionalExtras;

            $data = [
                'isSchedule' => false,
                'course' => $formData,
                'user' => $user,
                'avgRating' => 0,
                'sumRating' => 0,
                'isClone' => true,
                'group' => 'DT1LRJU'
            ];
            return response([
                'success' => true,
                'html' => view('client.screen.teacher.my-page.course.course-preview')->with($data)->render(),
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response([
                'success' => false
            ]);
        }
    }

    /**
     * @param UpdateCourseRequest $request
     * @param UpdateCourseService $courseService
     * @param int $courseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(UpdateCourseRequest $request, UpdateCourseService $courseService, int $courseId)
    {
        // clean clone data
        $courseService->cleanCloneData($courseId);
        $result = $courseService->update($request, $courseId);

        if (!$result['success']) {
            if (isset($result['errors'])) {
                return redirect()->back()->withInput()->withErrors($result['errors']);
            }
            $notification = [
                'message' => $result['message'],
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

//        if ((int)$result['course']->status === DBConstant::COURSE_STATUS_DRAFT || (int)$request->status === DBConstant::COURSE_STATUS_DRAFT) {
        if ((int)$request->status === DBConstant::COURSE_STATUS_DRAFT) {
            return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])
                ->with('success', $result['message']);
        }

        if ($request->screen === 'LIVESTREAM-2') {
            return redirect()->route('client.teacher.courses.show', [
                'course' => $result['course']->course_id,
                'isClone' => $request->is_clone,
                'group' => $result['group'],
            ]);
        }
        $data['course_id'] = $result['course']->course_id;
//        if (isset($request->created_at)){
//            $data['created_at'] =$request->created_at;
//        }
//        else{
        $data['isClone'] = $request->is_clone;
//        }

        if ($result['group']) {
            $data['group'] = $result['group'];
        }

        if (auth('client')->user()->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS) {
            $course = $result['course'];
            if (isset($course) && $course->approval_status === DBConstant::APPROVAL_STATUS_COURSE) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_step_one_course'));
            }

            return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_approval_course'));
        }
        return redirect()->route('client.teacher.my-page.service-list')->with('success', __('message.request_approval_course'));
    }

    /**
     * @param PreviewCloneCourse $request
     * @param UpdateCourseService $courseService
     * @param int $courseId
     */
    public function previewCloneCourse(PreviewCloneCourse $request, CourseService $courseService, int $courseId)
    {
        return $courseService->previewCloneCourse($request, $courseId);
    }

    public function updateDraft(UpdateCourseRequest $request, UpdateCourseService $courseService, int $courseId)
    {
        // clean clone data
        $courseService->cleanCloneData($courseId);
        $result = $courseService->update($request, $courseId);
        if (!$result['success']) {
            if (isset($result['errors'])) {
                return redirect()->back()->withInput()->withErrors($result['errors']);
            }
            $notification = [
                'message' => $result['message'],
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        if ((int)$result['course']->status === DBConstant::COURSE_STATUS_DRAFT || (int)$request->status === DBConstant::COURSE_STATUS_DRAFT) {
            return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])
                ->with('success', $result['message']);
        }

        if ($request->screen === 'LIVESTREAM-2') {
            return redirect()->route('client.teacher.courses.show', [
                'course' => $result['course']->course_id,
                'isClone' => $request->is_clone
            ]);
        }
        $data['course_id'] = $result['course']->course_id;
        if (isset($request->created_at)) {
            $data['created_at'] = $request->created_at;
        } else {
            $data['isClone'] = $request->is_clone;
        }

        return redirect()->route('client.teacher.courses.preview', $data);
    }

    /**
     * Public course.
     *
     * @param $courseId
     * @param PublicCourseRequest $request
     * @param CourseService $courseService
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function publicCourse($courseId, PublicCourseRequest $request, CourseService $courseService)
    {
        return $courseService->publicCourse($courseId, $request);
    }

    /**
     * Public course schedule.
     *
     * @param int $id
     * @param PublicCourseRequest $request
     * @param CourseService $courseService
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function publicCourseSchedule(int $id, PublicCourseRequest $request, CourseService $courseService)
    {
        return $courseService->publicCourseSchedule($id, $request);
    }

    /**
     * @param PreviewCourseSchedule $request
     * @param $courseScheduleId
     */
    public function previewCourseSchedule(PreviewCourseSchedule $request, $courseScheduleId, CourseScheduleService $courseScheduleService)
    {
        return $courseScheduleService->previewCourseSchedule($request, $courseScheduleId);
    }
}
