<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Student\FollowTeacherRequest;
use App\Services\Client\Student\Course\FollowTeacherService;

class FollowController extends Controller
{
    /**
     * Post Review.
     *
     * @param FollowTeacherRequest $request
     * @param FollowTeacherService $service
     * @return \Illuminate\View\View|mixed
     */
    public function followTeacher(FollowTeacherRequest $request, FollowTeacherService $service)
    {
        $result = $service->followTeacher($request);
        if($request->ajax())
        {
            return $result;
        }

        if (!$result['status']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
