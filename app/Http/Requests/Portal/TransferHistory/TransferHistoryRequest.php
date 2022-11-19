<?php

namespace App\Http\Requests\Portal\TransferHistory;

use App\Enums\Constant;
use Illuminate\Foundation\Http\FormRequest;

class TransferHistoryRequest extends FormRequest
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
        $term = $this->term ? $this->term : (in_array(now()->month, Constant::ARRAY_PERIOD_1) ? Constant::PERIOD_1 : Constant::PERIOD_2);
        $this->merge([
            'term' => $term,
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
            'term' => 'required|in:' . implode(',', [ Constant::PERIOD_1,  Constant::PERIOD_2]),
            'holiday' => 'nullable|date_format:m-d'
        ];
    }
}
