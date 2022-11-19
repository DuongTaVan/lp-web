<?php

namespace App\Http\Requests\Client\Teacher;

use App\Enums\DBConstant;
use App\Models\ImagePath;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessCardRequest extends FormRequest
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
        $teacherCategory = $this->request->get('teacher_category');
        if ($teacherCategory === 'teacher_category_consultation') {
            // $userId = $this->route('userId');
            $userId = $user = auth()->guard('client')->user()->user_id;
            $qualification = $this->request->get('qualifications');
            $imagePath = ImagePath::where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
            $ruleFile = [
                'mimetypes:image/png,image/jpg,image/jpeg,image/gif',
            ];
            if (!$imagePath && $qualification == 1) {
                $ruleFile[] = 'required';
            }
            return [
                'file' => $ruleFile,
                'qualifications' => 'required'
            ];
        }
        // if ($teacherCategory === 'teacher_category_fortunetelling') {
        //     if (auth()->guard('client')->user()->nda_status !== 1) {
        //         return [
        //             'is_nda' => 'required'
        //         ];
        //     }
        // }
        return [];
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
            "file.mimetypes" => "選択された本人確認画像は、有効ではありません。",
            "is_nda.required" => "NDAの締結は必須となります。",
            "qualifications.required" => '資格保有は、必ず指定してください。'
        ];
    }
}
