<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseCommonRequest extends FormRequest
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
            'sort' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'category_type' => 'nullable|integer',
            'time_frame' => 'nullable|integer|in:1,2,3',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'sort' => '選別',
            'category_id' => 'カテゴリID',
            'time_frame' => '時間枠',
            'start_date' => '開始日',
            'end_date' => '終了日',
        ];
    }
}
