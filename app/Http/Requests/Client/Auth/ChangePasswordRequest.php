<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|different:new_password',
            'new_password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9_.-]*$/',
            'confirm_password' => 'required|min:8|max:20|same:new_password|regex:/^[a-zA-Z0-9_.-]*$/',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'current_password' => trans('labels.change_password.password_current'),
            'new_password' => trans('labels.change_password.password_new'),
            'confirm_password' => trans('labels.change_password.password_confirm')
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'current_password.required' => '新しいパスワードは、必ず入力してください。',
            'new_password.required' => '新しいパスワードは、8文字以上で入力してください。',
            'confirm_password.required' => '新しいパスワード（確認は）必ず入力してください。',
        ];
    }
}
