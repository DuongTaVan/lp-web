<?php

namespace App\Http\Requests\Client\Teacher;

use App\Enums\DBConstant;
use App\Models\ImagePath;
use Illuminate\Foundation\Http\FormRequest;

class TeacherMypageIdenttifyUpdateRequest extends FormRequest
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
        $userId = $user = auth()->guard('client')->user()->user_id;
        $imagePath = ImagePath::where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])->first();
        $ruleFile = [
            'mimetypes:image/png,image/jpg,image/jpeg'
        ];
        if (!$imagePath || $this->request->get('check_clear_img') == 1) {
            $ruleFile[] = 'required';
        }
        $rule = [
            'file' => $ruleFile,
            'identity_verification_type' => 'required'
        ];

        if ((int)$this->identity_verification_type !== 2) {
            $rule['file1'] = $ruleFile;
        }

        return $rule;
    }

    /**
     * Message validate
     *
     * @return array
     */
    public function messages()
    {
        return [
            "file.required" => "本人確認画像は、必ず指定してください。",
            "file.mimetypes" => "選択された本人確認画像は、有効ではありません。"
        ];
    }
}
