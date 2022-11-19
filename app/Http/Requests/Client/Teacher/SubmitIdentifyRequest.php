<?php

namespace App\Http\Requests\Client\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SubmitIdentifyRequest extends FormRequest
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
            'teacher_category' => 'required',
            'qualifications' => 'required_if:teacher_category,==,teacher_category_consultation'
        ];
    }

    public function attributes()
    {
        return [
            'teacher_category' => 'ご利用内容',
            'qualifications' => '資格保有'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'qualifications.required_if' => ':attributeは、必ず指定してください。',
        ];
    }
}
