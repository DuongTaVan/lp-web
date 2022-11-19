<?php

namespace App\Http\Requests\Client\CourseSchedule;

use Illuminate\Foundation\Http\FormRequest;

class CourseScheduleDetailRequest extends FormRequest
{
    /**
     * @var mixed
     */

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
        return [
            'course_schedule_id' => [
                'required',
                'exists:course_schedules,course_schedule_id'
            ]
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['course_schedule_id' => $this->route('course_schedule_id')]);
    }
}
