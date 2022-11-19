<?php

namespace App\Http\Requests\Client\Student;

use Illuminate\Foundation\Http\FormRequest;

class CourseReviewRequest extends FormRequest
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
        return [
            'course_schedule_id' => 'required|integer|exists:course_schedules',
            'rating' => 'required|min:1|max:5',
            'comment' => 'required|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'コメント'
        ];
    }
}
