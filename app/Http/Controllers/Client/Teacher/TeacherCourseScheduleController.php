<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Course\UpdateCourseSchedule;
use App\Services\Client\Teacher\CloneCourseScreenService;
use App\Services\Client\Teacher\UpdateCourseScheduleService;
use App\Services\Client\Teacher\UpdateCourseScheduleViewService;
use Illuminate\Http\Request;

class TeacherCourseScheduleController extends Controller
{
    /**
     * @param int $id
     * @param UpdateCourseScheduleViewService $service
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function show(int $id, UpdateCourseScheduleViewService $service)
    {
        $data = $service->show($id);

        return view('client.screen.teacher.my-page.course.schedule')->with($data);
    }

//    /**
//     * @param int $id
//     * @param UpdateCourseScheduleViewService $service
//     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
//     */
//    public function draft(int $id, UpdateCourseScheduleViewService $service, CloneCourseScreenService $serviceClone, Request $request)
//    {
//        // get course data to draft
//        $data = $serviceClone->getData($id, $request->created_at);
//        if ($data['course']->dist_method === DBConstant::DIST_METHOD_LIVE_STREAMING) {
//            if ($request->isClone) {
//                $data['label'] = [
//                    'screen' => 'LIVESTREAM-3',
//                    'step' => 'STEP 3',
//                    'title' => '開催日程の設定',
//                    'deg' => 360
//                ];
//            } else if ($data['course']->approval_status === DBConstant::COURSE_NOT_REVIEW) {
//                $data['label'] = [
//                    'screen' => 'LIVESTREAM-1',
//                    'step' => 'STEP 1',
//                    'title' => 'サービスを作成し公開を申請する',
//                    'deg' => 120
//                ];
//            } else if (!count($data['course']->courseSchedules)) {
//                $data['label'] = [
//                    'screen' => 'LIVESTREAM-2',
//                    'step' => 'STEP 2',
//                    'title' => '開催日程の設定',
//                    'deg' => 240
//                ];
//            } else {
//                $data['label'] = [
//                    'screen' => 'LIVESTREAM-3',
//                    'step' => 'STEP 3',
//                    'title' => '開催日程の設定',
//                    'deg' => 360
//                ];
//            }
//        } else {
//            $data['label'] = [
//                'screen' => auth('client')->user()->teacher_category_consultation ? 'CONSULTATION' : 'FORTUNE',
//            ];
//        }
//        $data['label']['clone'] = (bool)$request->isClone;
//
//        $data['MAX_COURSE'] = $data['course']->maxScheduleCanCreate;
//        return view('client.screen.teacher.my-page.course.edit')->with($data);
//    }

    public function update(int $courseSchedule, UpdateCourseSchedule $request, UpdateCourseScheduleService $service)
    {
        $startDate = now()->parse($request->start_day . ' ' . $request->start_time . ':00');
        $endDate = now()->parse($startDate)->addMinutes((int)$request->minutes_required);
        $purchaseDeadline = now()->parse($startDate)->subHour();
        $request->merge([
            'course_schedule_id' => $courseSchedule,
            'purchase_deadline' => $purchaseDeadline,
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
        ]);

        return $service->update($request);
    }
}
