<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Course\PublicCourseRequest;
use App\Services\Client\Teacher\CloneCourseScreenService;
use App\Services\Client\Teacher\CourseService;
use Illuminate\Http\Request;

class TeacherCourseController extends Controller
{
    private $courseService;

    /**
     * TeacherController constructor.
     */
    public function __construct()
    {
        $this->courseService = app(CourseService::class);
    }

    /**
     * Course Preview
     * @param int $courseId
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function preview(int $courseId, Request $request)
    {
        $data = $this->courseService->preview($courseId, null, (bool)$request->isClone, $request->group);

        return view('client.screen.teacher.my-page.course.preview')->with($data);
    }

    /**
     * course schedule preview
     */
    public function previewSchedule(int $id)
    {
        $data = $this->courseService->preview($id, 'COURSE_SCHEDULE');

        return view('client.screen.teacher.my-page.course.preview')->with($data);
    }

    /**
     * Public course.
     *
     * @param int $courseId
     * @param PublicCourseRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function publicCourse(PublicCourseRequest $request, int $courseId)
    {
        return $this->courseService->publicCourse($courseId, $request);
    }

    /**
     * @param CloneCourseScreenService $service
     * @param int $courseId
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function cloneCourse(CloneCourseScreenService $service, int $courseId, Request $request)
    {
        $user = auth()->guard('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        //If the user is not authenticated, the course cannot be created.
        if (auth()->guard('client')->user()->identity_verification_status != \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED) {
            return view('common.403');
        }
        // clean clone data
        if (!$request->backFrom) {
            $service->cleanCloneData($courseId);
        }
        // get course data to clone
        $data = $service->getData($courseId);
        if ($data['course']->dist_method === DBConstant::DIST_METHOD_LIVE_STREAMING) {
            $data['label'] = [
                'screen' => 'LIVESTREAM-2',
                'clone' => true,
                'step' => 'STEP 2',
                'title' => '開催日程の設定',
                'deg' => 240
            ];
        } else {
            $data['label'] = [
                'screen' => auth('client')->user()->teacher_category_consultation ? 'CONSULTATION' : 'FORTUNE',
                'clone' => true,
            ];
        }
        $data['MAX_COURSE'] = $data['course']->maxScheduleCanCreate;

        return view('client.screen.teacher.my-page.course.edit')->with($data);
    }

    public function viewGuidelines()
    {
        return view('client.screen.guidelines');
    }
}
