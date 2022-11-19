<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Student;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseDetailRequest extends FormRequest
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
            'id' => [
                'required',
                'exists:course_schedules,course_schedule_id',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
