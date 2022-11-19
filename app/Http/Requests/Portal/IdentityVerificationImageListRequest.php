<?php

namespace App\Http\Requests\Portal;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class IdentityVerificationImageListRequest extends FormRequest
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
        $status = $this->status ?? Constant::IMAGE_PATHS_STATUS;
        $per_page = $this->per_page ?? Constant::DEFAULT_LIMIT;
        $this->merge([
            'per_page' => $per_page
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
            'user_id' => 'nullable',
            'status' => 'nullable|in:' . implode(',', DBConstant::IMAGE_PATH_STATUS)
        ];
    }
}
