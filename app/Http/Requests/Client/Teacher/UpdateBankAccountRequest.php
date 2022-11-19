<?php

namespace App\Http\Requests\Client\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBankAccountRequest extends FormRequest
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
        return [
            'bank_name' => 'required|max:255',
            'account_type' => 'required',
            'branch_name' => 'required|max:255',
            'account_number' => 'required|max:9999999',
            'account_name' => 'required|max:255|regex:/^[ａ-ｚＡ-Ｚa-zA-Zァ-ヴｦ-ﾟ\ \　\）\（\ー]+$/u',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'account_type' => '種類'
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => '銀行名は、必ず指定してください。',
            'bank_name.max' => '銀行名は、255文字以下にしてください。',
            'account_name.regex' => 'カタカナ又はアルファベットでご入力ください。'
        ];
    }
}
