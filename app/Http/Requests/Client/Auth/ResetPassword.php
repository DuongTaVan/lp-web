<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
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
            'token' => 'required',
            'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9_.-]*$/',
            'confirm_password' => 'required|same:password'
        ];
    }

    public function attributes()
    {
        return [
            'confirm_password' => trans('labels.change_password.password_confirm')
        ];
    }
}
