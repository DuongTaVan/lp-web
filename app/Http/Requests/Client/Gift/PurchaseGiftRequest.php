<?php

namespace App\Http\Requests\Client\Gift;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseGiftRequest extends FormRequest
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
            'course_schedule_id' => 'required|integer',
            'gift_id' => 'required|integer'
        ];
    }
}
