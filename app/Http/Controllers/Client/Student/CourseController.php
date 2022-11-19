<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Student\CourseRestockRequest;
use App\Http\Requests\Client\Student\CourseReviewRequest;
use App\Services\Batch\CourseScheduleService;
use App\Services\Client\Student\Course\CourseRestockService;
use App\Services\Client\Student\Course\CourseReviewService;

class CourseController extends Controller
{
    protected $courseReviewService;
    protected $courseScheduleService;
    protected $courseRestockService;

    public function __construct()
    {
        $this->courseReviewService = app(CourseReviewService::class);
        $this->courseScheduleService = app(CourseScheduleService::class);
        $this->courseRestockService = app(CourseRestockService::class);
    }

    /**
     * Get review
     *
     * @param int $courseScheduleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function review(int $courseScheduleId)
    {
        $dataReviewed = $this->courseReviewService->getReviewView($courseScheduleId);
        if (!$dataReviewed) {
            $courseSchedule = $this->courseScheduleService->getCourseSchedule($courseScheduleId);
            return view('client.screen.student-livestream.course-review', compact('courseSchedule'));
        }
        $courseSchedule = $dataReviewed['courseSchedule'];
        $reviewed = $dataReviewed['reviewed'];
        return view('client.screen.student-livestream.course-review', compact('reviewed', 'courseSchedule'));
    }

    /**
     * Post review
     *
     * @param CourseReviewRequest $request
     * @param CourseReviewService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postReview(CourseReviewRequest $request)
    {
        if ($request->ajax()) {
            return $this->courseReviewService->postReview($request);
        }

        return response([
            'status' => false
        ]);
    }

    /**
     * Post restock
     *
     * @param CourseRestockRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postRequest(CourseRestockRequest $request)
    {
        if ($request->ajax()) {
            return $this->courseRestockService->postRestock($request);
        }

        return response([
            'status' => false
        ]);
    }
}

