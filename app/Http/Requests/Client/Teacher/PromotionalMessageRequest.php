<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class PromotionalMessageRequest extends FormRequest
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
            'title' => 'required|max:255|regex:/[a-zA-Z0-9ぁ-んァ-ン一-龥\s]+$/',
            'body' => 'required',
        ];
    }
}
