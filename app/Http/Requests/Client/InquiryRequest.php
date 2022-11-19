<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
        $rule = [
            'full_name' => 'required|max:30',
            'email' => 'required|email',
            'type' => 'required',
            'subject' => 'required|max:30',
            'content_inquiry' => 'required|max:200',

        ];
        if (isset($this->file) && $this->file != 'undefined') {
            $rule['file'] = 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120';
        }
        return $rule;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'full_name' => 'フルネーム',
            'Eメール' => 'サービス内容',
            'type' => 'タイプ',
            'subject' => '主題',
            'content_inquiry' => 'コンテンツ',
            'file' => '画像 '
        ];
    }
}
