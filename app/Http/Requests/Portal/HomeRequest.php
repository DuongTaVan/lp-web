<?php

namespace App\Http\Requests\Portal;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
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
        $month = $this->month ?? now()->format('Y-m');
        $category = $this->category ?? DBConstant::LIST_CATEGORY_TYPE['all'];
        $this->merge([
            'month' => $month,
            'category' => $category,
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
            'month' => 'required|date',
            'category' => 'required|integer|in:' . implode(',', DBConstant::LIST_CATEGORY_TYPE)
        ];
    }
}
