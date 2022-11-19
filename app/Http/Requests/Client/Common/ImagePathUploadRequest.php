<?php

namespace App\Http\Requests\Client\Common;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class ImagePathUploadRequest extends FormRequest
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
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->type ?? DBConstant::IMAGE_PATH_TYPE['background'],
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
            'file' => 'required|mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'type' => 'required|integer|in:' . implode(',', DBConstant::IMAGE_PATH_TYPE),
            'status' => 'nullable|integer|in:' . implode(',', DBConstant::IMAGE_PATH_STATUS),
        ];
    }

    public function messages()
    {
        return [
            'file.mimetypes' => 'ファイル形式をJPG、PNG、GIFでご指定ください。',
            'file.max' => '画像の最大容量は５MBです。',
        ];
    }
}
