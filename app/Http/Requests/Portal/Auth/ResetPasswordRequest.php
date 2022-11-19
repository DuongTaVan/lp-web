<?php

namespace App\Http\Requests\Portal\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token_password' => 'required',
            'new_password' => 'required|min:6|max:255',
            'confirm_password' => 'required|min:6|max:255|same:new_password'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */

    public function attributes()
    {
        return [
            'new_password' => trans('labels.change_password.password_new'),
            'confirm_password' => trans('labels.change_password.password_confirm')
        ];
    }
}
