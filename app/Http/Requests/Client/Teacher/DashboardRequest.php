<?php

namespace App\Http\Requests\Client\Teacher;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
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
        $month = implode(',', Constant::ALL_MONTH);

        return [
            'month' => "required|in:$month",
            'category' => 'required|integer|in:' . DBConstant::TEACHER_CATEGORY_SKILLS . ',' . DBConstant::TEACHER_CATEGORY_CONSULTATION . ',' . DBConstant::TEACHER_CATEGORY_FORTUNETELLING
        ];
    }
}
