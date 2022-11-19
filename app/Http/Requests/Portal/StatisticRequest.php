<?php

namespace App\Http\Requests\Portal;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
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
        $startDate = $this->start_date ?? now()->firstOfMonth()->format('Y-m-d');
        $type = $this->category_type ?? null;
        $endDate = $this->end_date ?? null;
        $this->merge([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'category_type' => $type,
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
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'category_type' => 'nullable|in:' . implode(',', DBConstant::LIST_CATEGORY_TYPE),
            'category_id' => 'nullable|integer'
        ];
    }
}
