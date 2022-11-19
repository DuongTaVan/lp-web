<?php

namespace App\Http\Controllers\Portal;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Mail\ApprovalCourse;
use App\Mail\RejectCourse;
use App\Services\Client\Common\CourseService;
use App\Traits\RealtimeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CourseController extends Controller
{
    use RealtimeTrait;
    /**
     * Show list course request
     *
     * @param Request $request
     * @param CourseService $courseService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request, CourseService $courseService)
    {
        $courses = $courseService->getRequestCourses($request);
        $categories = $courseService->getCategoryLiveStream();

        return view('portal.modules.courses.index')->with([
            'courses' => $courses,
            'categories' => $categories
        ]);
    }

    /**
     * Get request course detail
     *
     * @param Request $request
     * @param int $courseId
     * @param CourseService $courseService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Throwable
     */
    public function show(Request $request, int $courseId, CourseService $courseService)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $course = $courseService->getDetail($courseId);
            $html = $course ? view('portal.components.realtime.course', compact('course'))->render() : '';

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }

        $data = $courseService->getRequestCourse($courseId);

        return view('portal.modules.courses.detail')->with([
            'course' => $data['course'],
            'subCourse' => $data['subCourse']
        ]);
    }

    /**
     * Approval request course
     *
     * @param $courseId
     * @param Request $request
     * @param CourseService $courseService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function approval($courseId, Request $request, CourseService $courseService)
    {
        $parts = parse_url(url()->previous());
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        } else {
            $query = [];
        }

        $request->validate([
            'approval_status' => 'required|in:' . DBConstant::COURSE_APPROVED . ',' . DBConstant::COURSE_REJECT
        ]);

        DB::beginTransaction();
        try {
            $course = $courseService->courseRepository->with(['courses', 'user'])->findOrFail($courseId);
            if (!$course) {
                return back()->with('error', __('errors.MSG_5036'));
            }

            $course->approval_status = $request->approval_status;
            $course->admin_update_at = now();
            $course->save();

            foreach ($course->courses as $subCourse) {
                $courseService->courseRepository->where('course_id', $subCourse->course_id)->update([
                    'approval_status' => $request->approval_status
                ]);
            }

            DB::commit();

            $this->sendEvent('realtime', [
                'url' => '/portal/courses',
                'screen' => 'COURSE',
                'id' => $courseId
            ]);
            if ($request->approval_status == DBConstant::COURSE_APPROVED) {
                Mail::to($course->user->email)->queue(new ApprovalCourse('【Lappi】新規サービス承認のお知らせ。', $course->user->full_name));
                return redirect()->route('portal.courses.index', $query)->with('message', __('message.update_success_alt'));
            } else {
                Mail::to($course->user->email)->queue(new RejectCourse('【Lappi】新規サービスの否認のお知らせ。', $course->user->full_name));
                return redirect()->route('portal.courses.index', $query)->with('message', __('message.update_rejected'));
            }

            // return redirect()->route('portal.courses.index', $query)->with('message', __('message.update_success_alt'));
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Get count course not approve
     *
     * @param Request $request
     * @param CourseService $courseService
     * @return mixed
     */
    public function countCourseNotApprove(Request $request, CourseService $courseService)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $courseService->countCourseNotApprove();

            return response()->json([
                'success' => true,
                'count' => $data
            ]);
        }
    }
}
