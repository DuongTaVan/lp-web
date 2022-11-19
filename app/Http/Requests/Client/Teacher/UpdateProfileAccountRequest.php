<?php

namespace App\Http\Requests\Client\Teacher;
use Illuminate\Support\Facades\Auth;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileAccountRequest extends FormRequest
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
        $rule = [
            'nickname' => 'required|min:3|max:20',
            'profile_image' => 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120'
        ];

        return $rule;
    }

    public function attributes()
    {
        return [
            'confirm_password' => trans('labels.change_password.password_confirm'),
            'profile_image' => 'プロフィール画像'
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimetypes' => 'プロフィール画像GIF、JPG、PNGタイプのファイルを指定してください。',
            'profile_image.max' => 'プロフィール画像には、5 MB以下のファイルを指定してください。',
            'confirm_password.same' => 'パスワード（確認）とパスワードが一致しません。'
        ];
    }
}
