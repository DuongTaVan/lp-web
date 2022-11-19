<?php

namespace App\Http\Requests\Client\CourseSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PurchaseCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['course_schedule_id'] = 'required|integer';
        if (Route::currentRouteName() == 'course-schedules.purchase-main-course') {
            $rules['course_schedule_id'] = 'required|integer';
            $rules['optional_extra_ids'] = 'array|nullable';
            $rules['optional_extra_ids.*'] = 'integer';
        }

        return $rules;
    }
}
