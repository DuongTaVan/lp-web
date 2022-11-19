<?php

namespace App\Http\Requests\Client\Student;

use Illuminate\Foundation\Http\FormRequest;

class CloseAccountRequest extends FormRequest
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
        $archiveReason = $this->request->get('archive_reason');
        $ruleArchiveReasonText = [];
        if ($archiveReason === "6") {
            $ruleArchiveReasonText = "required";
        }
        return [
            'archive_reason' => 'required|max:1000',
            'archive_reason_text' => $ruleArchiveReasonText
        ];
    }

    public function messages()
    {
        return [
            'archive_reason.required' => '退会する理由を必ず選択してください。',
            'archive_reason_text.required' => '退会する理由を必ず入力して下さい。'
        ];
    }
}
