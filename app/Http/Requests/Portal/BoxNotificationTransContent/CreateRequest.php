<?php

namespace App\Http\Requests\Portal\BoxNotificationTransContent;

use App\Enums\DBConstant;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $scheduled_at = $this->scheduled_at ?? now()->format('Y-m-d H:i:s');
        $this->merge([
            'scheduled_at' => $scheduled_at,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'to_type' => 'required|integer|in:' . implode(',', DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE),   
            'scheduled_at' => 'required|date',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */

    public function attributes()
    {
        return [
            'title' => trans('labels.box_notification.title'),
            'body' => trans('labels.box_notification.title_detail')
        ];
    }
}
