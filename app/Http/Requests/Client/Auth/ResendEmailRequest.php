<?php

namespace App\Http\Requests\Client\Auth;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class ResendEmailRequest extends FormRequest
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
            'email' => 'required|email|max:254',
            'user_type' => 'required|in:' . DBConstant::USER_TYPE_STUDENT . ',' . DBConstant::USER_TYPE_TEACHER,
            'login_type' => 'required|in:' . DBConstant::LOGIN_TYPE_EMAIL . ',' . DBConstant::LOGIN_TYPE_FACEBOOK
                . ',' . DBConstant::LOGIN_TYPE_GOOGLE . ',' . DBConstant::LOGIN_TYPE_LINE
        ];
    }
}
