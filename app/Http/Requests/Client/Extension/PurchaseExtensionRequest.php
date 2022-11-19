<?php

namespace App\Http\Requests\Client\Extension;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseExtensionRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $optionIds = $this->optional_extra_ids ?? [];
        $this->merge([
            'optional_extra_ids' => $optionIds,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required|integer', // id course extend
            'course_schedule_id' => 'required|integer', // id course schedule learning
            'current_course_schedule_id' => 'required|integer', // id course schedule
            'origin_course_schedule_id' => 'required|integer', // id course schedule learning
            'optional_extra_ids' => 'array', // list id option buy
            'optional_extra_ids.*' => 'integer',
//            'extend_ids' => 'array', // list id extend buy
//            'extend_ids.*' => 'integer'
        ];
    }
}
