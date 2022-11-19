<?php

namespace App\Http\Requests\Portal;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class UserListRequest extends FormRequest
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
            'user_id' => 'nullable',
            'user_type' => 'nullable|integer|in:0,' . DBConstant::USER_TYPE_STUDENT . ',' . DBConstant::USER_TYPE_TEACHER,
            'teacher_category' => 'nullable|integer|in:0,' . DBConstant::TEACHER_TYPE_INDIVIDUAL . ',' . DBConstant::TEACHER_TYPE_FREELANCE . ',' . DBConstant::TEACHER_TYPE_CORPORATION,
            'sex' => 'nullable|integer|in:0,' . DBConstant::SEX_MALE . ',' . DBConstant::SEX_FEMALE . ',' . DBConstant::SEX_OTHER . ',' . DBConstant::SEX_NOT_APPLICABLE,
            'identity_verification_status' => 'nullable|integer|in:' . DBConstant::IDENTITY_VERIFICATION_STATUS_NOT_YET_APPLIED . ',' . DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED . ',' . DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED . ',' . DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED,
            'business_card_verification_status' => 'nullable|integer|in:' . DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED . ',' . DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPLIED . ',' . DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_REJECTED . ',' . DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED,
        ];
    }
}
