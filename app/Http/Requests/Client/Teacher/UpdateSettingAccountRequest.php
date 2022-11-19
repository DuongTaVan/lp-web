<?php

namespace App\Http\Requests\Client\Teacher;

use App\Models\User;
use App\Traits\ManageFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingAccountRequest extends FormRequest
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
//        $userId = $this->input('userId');
        $user = auth('client')->user();
        $ruleImage = [
            'mimetypes:image/png,image/jpg,image/jpeg,image/gif',
            'max:5120'
        ];
        if (!$user->getOriginal('profile_image')) {
            $ruleImage[] = 'required';
        }
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

        $this->makeSessionUpdateAccount($this, $rule);

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
            'biography' => '自己紹介文の入力'
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
            'last_name_kanji.regex' => 'お名前（姓 / 名）はローマ字、漢字、ひらがな、カタカナでご入力ください。'
        ];
    }
}
