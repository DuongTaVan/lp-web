<?php

namespace App\Http\Requests\Portal\Auth;

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
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => trans('labels.change_password.password_current'),
            'new_password' => trans('labels.change_password.password_new'),
            'confirm_password' => trans('labels.change_password.password_confirm')
        ];
    }
}
