<?php

namespace App\Http\Requests\Client\Teacher;

use App\Enums\DBConstant;
use App\Models\ImagePath;
use App\Traits\ManageFile;
use Illuminate\Foundation\Http\FormRequest;

class RegisterTeacherRequest extends FormRequest
{
    use ManageFile;

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
            'first_name_kana' => ucwords($this->first_name_kana),
            'account_name' => ucwords($this->account_name)
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
        $step = (int)$this->step;
        $rule = [];

        if ($step === 1) {
            $ruleImage = [
                'mimetypes:image/png,image/jpg,image/jpeg,image/gif',
                'max:5120',
                'required'
            ];
            //        if (!$user->getOriginal('profile_image')) {
            //            $ruleImage[] = 'required';
            //        }
            $rule = [
                'first_name_kanji' => 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u',
                'last_name_kanji' => 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u',
                'first_name_kana' => "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu",
                'last_name_kana' => "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu",
                'name_use' => 'required',
                'profile_image' => $ruleImage,
                'catchphrase' => 'required|max:65535',
                'biography' => 'required'
            ];
        } else if ($step === 2) {
            $teacherCategory = (int)$this->teacher_category;
            if ($teacherCategory === 2) {
                $qualification = (int)$this->qualifications;
                $ruleFile = [
                    'mimetypes:image/png,image/jpg,image/jpeg,image/gif',
                ];
                if ($qualification) {
                    $ruleFile[] = 'required';
                }

                return [
                    'business_file' => $ruleFile,
                    'qualifications' => 'required'
                ];
            }
        } else if ($step === 3) {
            $isChangeName = (int)$this->isChangeName;
            $ruleFile = [
                'mimetypes:image/png,image/jpg,image/jpeg',
                'required'
            ];

            $rule = [
                'isChangeName' => 'required',
                'image_identify' => $ruleFile,
                'identity_verification_type' => 'required',
                "address" => "required|max:255"
            ];
            if ((int)$this->identity_verification_type !== 2) {
                $rule['image_identify1'] = $ruleFile;
            }

            if ($isChangeName === 1) {
                $rule['first_name_kanji'] = 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u';
                $rule['last_name_kanji'] = 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ一-龥ぁ-ん\ \　]+$/u';
                $rule['first_name_kana'] = "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu";
                $rule['last_name_kana'] = "required|max:255|regex:/^[\u{3000}-\u{301C}\u{30A1}-\u{30F6}\u{30FB}-\u{30FE}]+$/mu";
            }
        } else if ($step === 5) {
            $rule = [
                'bank_name' => 'required|max:255',
                'account_type' => 'required',
                'branch_name' => 'required|max:255',
                'account_number' => 'required|max:9999999',
                'account_name' => 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ\ \　\）\（\ー]+$/u',
            ];
        }

//        $this->makeSessionUpdateAccount($this, $rule);

        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name_use' => '公開表示',
            'profile_image' => '出品者プロフィール画像',
            'catchphrase' => 'キャッチコピー(自己紹介のタイトル)',
            'biography' => '自己紹介文の入力',
            'address' => '住所'
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
            'last_name_kana.regex' => 'カタカナのフォーマットが正しくありません',
            'first_name_kana.regex' => 'カタカナのフォーマットが正しくありません',
            'first_name_kanji.regex' => 'お名前（姓 / 名）はローマ字、漢字、ひらがな、カタカナでご入力ください。',
            'last_name_kanji.regex' => 'お名前（姓 / 名）はローマ字、漢字、ひらがな、カタカナでご入力ください。',
            'business_file.required' => '本人確認画像は、必ず指定してください。',
            'business_file.mimetypes' => '選択された本人確認画像は、有効ではありません。',
            'is_nda.required' => 'NDAの締結は必須となります。',
            'qualifications.required' => '資格保有は、必ず指定してください。',
            'bank_name.required' => '銀行名は、必ず指定してください。',
            'bank_name.max' => '銀行名は、255文字以下にしてください。',
            'account_name.regex' => 'カタカナ又はアルファベットでご入力ください。'
        ];
    }
}
