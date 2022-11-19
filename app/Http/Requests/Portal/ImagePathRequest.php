<?php

namespace App\Http\Requests\Portal;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class ImagePathRequest extends FormRequest
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
            'status' => 'nullable|integer|in:' . implode(',', DBConstant::IMAGE_PATH_STATUS),
            'user_id' => 'nullable',
            // 'type' => 'required|integer|in:' . implode(',', DBConstant::IMAGE_PATH_TYPE),
        ];
    }
}
