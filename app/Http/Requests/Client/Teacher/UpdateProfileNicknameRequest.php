<?php

namespace App\Http\Requests\Client\Teacher;
use Illuminate\Support\Facades\Auth;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileNicknameRequest extends FormRequest
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
        $ruleNickname = '';
        if ($this->request->has('nickname')) {
            $ruleNickname = 'required|min:3|max:20';
        }

        $rule = [
            'nickname' => $ruleNickname,
            'profile_image' => 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'catchphrase' => 'required',
            'biography' => 'required'
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
            'catchphrase.required' => 'キャッチコピー(自己紹介のタイトル)は、必ず指定してください。',
            'biography.required' => '自己紹介文の入力は、必ず指定してください。',
            'profile_image.mimetypes' => 'プロフィール画像GIF、JPG、PNGタイプのファイルを指定してください。',
            'profile_image.max' => 'プロフィール画像には、5 MB以下のファイルを指定してください。',
            'confirm_password.same' => 'パスワード（確認）とパスワードが一致しません。'
        ];
    }
}
