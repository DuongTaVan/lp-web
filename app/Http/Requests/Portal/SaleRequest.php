<?php

namespace App\Http\Requests\Portal;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'type' => 'nullable|in:' . implode(',', DBConstant::LIST_CATEGORY_TYPE),
            'category_id' => 'nullable|integer',
            'user_id' => 'nullable'
        ];
    }
}
