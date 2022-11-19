<?php

namespace App\Http\Requests\Client\Auth;
use Illuminate\Support\Facades\Auth;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'email' => 'required|max:254|email|unique:users,email,' . Auth::guard('client')->user()->user_id . ',user_id',
            'sex' => 'required|in:' . DBConstant::SEX_MALE . ',' . DBConstant::SEX_FEMALE . ',' . DBConstant::SEX_NOT_APPLICABLE . ',' . DBConstant::SEX_OTHER,
        ];

        return $rule;
    }

    public function attributes()
    {
        return [
            'confirm_password' => trans('labels.change_password.password_confirm'),
            'image' => 'プロフィール画像'
        ];
    }

    public function messages()
    {
        return [
            'image.mimetypes' => 'プロフィール画像GIF、JPG、PNGタイプのファイルを指定してください。',
            'confirm_password.same' => 'パスワード（確認）とパスワードが一致しません。'
        ];
    }
}
