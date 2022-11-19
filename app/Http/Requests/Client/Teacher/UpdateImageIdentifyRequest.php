<?php

namespace App\Http\Requests\Client\Teacher;

use App\Enums\DBConstant;
use App\Models\ImagePath;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImageIdentifyRequest extends FormRequest
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

    public function getValidatorInstance()
    {
        $this->merge([
            'first_name_kanji' => ucwords($this->first_name_kanji),
            'last_name_kanji' => ucwords($this->last_name_kanji),
            'last_name_kana' => ucwords($this->last_name_kana),
            'first_name_kana' => ucwords($this->first_name_kana)
        ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('userId');
        $isChangeName = $this->request->get('isChangeName');
        $imagePath = ImagePath::where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])->first();
        $ruleFile = [
            'mimetypes:image/png,image/jpg,image/jpeg'
        ];
        if (!$imagePath) {
            $ruleFile[] = 'required';
        }
        $rule = [
            'isChangeName' => 'required',
            'file' => $ruleFile,
            'identity_verification_type' => 'required',
            "address" => "required|max:255"
        ];
        if ((int)$this->identity_verification_type !== 2) {
            $rule['file1'] = $ruleFile;
        }

        if ((int)$isChangeName === 1) {
            $rule['first_name_kanji'] = 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u';
            $rule['last_name_kanji'] = 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u';
            $rule['first_name_kana'] = "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu";
            $rule['last_name_kana'] = "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu";
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'address' => '住所',
        ];
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
            "isChangeName.required" => "いずれか１つ選んでください。",
            'last_name_kana.regex' => 'カタカナのフォーマットが正しくありません',
            'first_name_kana.regex' => 'カタカナのフォーマットが正しくありません',
            'first_name_kanji.regex' => 'お名前（姓 / 名）はローマ字、漢字、ひらがな、カタカナでご入力ください。',
            'last_name_kanji.regex' => 'お名前（姓 / 名）はローマ字、漢字、ひらがな、カタカナでご入力ください。'
        ];
    }
}
