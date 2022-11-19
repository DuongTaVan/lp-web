<?php

namespace App\Http\Requests\Client\Auth;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $yearRequest = $this->request->get('year');
        $monthRequest = $this->request->get('month');
        $dayRequest = $this->request->get('day');
        $rule = [
            'email' => 'required|max:254|email',
            'nickname' => 'unique:users|required|min:3|max:20',
            'year' => 'required|integer',
            'month' => 'required|min:1|max:12',
            'day' => 'required|min:1|max:31',
            'sex' => 'required|in:' . DBConstant::SEX_MALE . ',' . DBConstant::SEX_FEMALE . ',' . DBConstant::SEX_NOT_APPLICABLE . ',' . DBConstant::SEX_OTHER,
            'image' => 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'user_type' => 'required|in:' . DBConstant::USER_TYPE_STUDENT . ',' . DBConstant::USER_TYPE_TEACHER
        ];
        if (now()->parse($dayRequest . '-' . $monthRequest . '-' . $yearRequest) > now()) {
            $rule['birthday'] = 'required';
        }
        if ($this->login_type && $this->login_type === DBConstant::LOGIN_TYPE_EMAIL) {
            $loginType = DBConstant::LOGIN_TYPE_EMAIL;
        } else {
            $loginType = session('user') ? session('user')->loginType : $this->request->get('loginType') ?? DBConstant::LOGIN_TYPE_EMAIL;
        }

        if ($loginType === DBConstant::LOGIN_TYPE_EMAIL) {
            $rule['password_current'] = 'required|min:8|max:20|regex:/^[a-zA-Z0-9_.-]*$/';
            $rule['confirm_password'] = 'required|same:password_current';
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'password_current' => 'パスワー',
            'confirm_password' => 'パスワード(確認)',
            'image' => 'プロフィール画像'
        ];
    }

    public function messages()
    {
        return [
            'image.mimetypes' => '選択された購入者用プロフィール画像は、有効ではありません。',
            'password_current.required' => 'パスワードは、必ず指定してください。',
            'password_current.min' => 'パスワードは、8文字以上にしてください。',
            'password_current.max' => 'パスワードは、20文字以下にしてください。',
            'confirm_password.required' => 'パスワード（確認）は、必ず指定してください。',
            'confirm_password.same' => 'パスワード（確認）とパスワードが一致しません。',
            'birthday.required' => '現在よりの生年月日を選択できません。',
            'nickname.unique' => 'このニックネームは既に登録されています。'
        ];
    }
}
