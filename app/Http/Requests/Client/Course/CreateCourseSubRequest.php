<?php

namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseSubRequest extends FormRequest
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

    /**
     * Set attribute price
     *
     * @return string
     */
    private function setPriceAttribute()
    {
        $price = __('labels.create_course.validate.livestream.price');
        if (auth('client')->user()->teacher_category_consultation == DBConstant::TEACHER_CATEGORY_CONSULTATION) {
            $price = __('labels.create_course.validate.consultation.price');
        } elseif (auth('client')->user()->teacher_category_fortunetelling == DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
            $price = __('labels.create_course.validate.fortunetelling.price');
        }

        return $price;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = auth()->guard('client')->user();
        $rule = [
            'title' => 'required|max:70',
            'subtitle' => 'required|min:15|max:100',
            'body' => 'required',
            'flow' => 'required',
            'cautions' => 'required',
            'minutes_required' => 'required|numeric|min:30',
            'price' => 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000',
            'preview.*' => 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'start_day.*' => 'nullable|date_format:Y/m/d',
            'start_time' => 'required|array',
            'start_time.*' => 'nullable|date_format:H:i',
            'category_id' => 'required',
            'is_mask_required' => 'required:in' . DBConstant::FACEMASK_OK . ',' . DBConstant::FACEMASK_NG,
            'status' => 'required|in:' . DBConstant::COURSE_STATUS_DRAFT . ',' . DBConstant::COURSE_STATUS_OPEN . ',' . DBConstant::COURSE_STATUS_PREVIEW,
            'start_day' => ['required', 'array', function ($attribute, $value, $fail) {
                $this->ruleMainSchedule($fail);
            }]
        ];
        $this->makeSessionPreviewFile($this, $rule);

        if ($user->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION
            || $user->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING
        ) {
            $rule = $this->ruleOptions($rule);
        }

        if ($user->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
            $rule = $this->ruleExtra($rule);
        }
        return $rule;
    }

    public function attributes()
    {
        return [
            'subtitle' => 'タイトル補足説明',
            'body' => 'サービス内容',
            'flow' => '当日の流れ',
            'cautions' => 'ご利用に当たって',
            'fixed_num' => '固定数',
            'start_day' => '開始日',
            'start_time' => '開始時',
            'price' => $this->setPriceAttribute(),
            'minutes_required' => 'ご利用時間',
            'sub_minutes_required' => 'サブ_必須_分数',
            'sub_start_day' => 'サブ_開始日',
            'sub_start_time' => 'サブ_開始時',
            'preview' => '画像',
            'money' => '有料オプション',
            'time' => '時間',
            'extra_title.*' => '有料オプション',
            'category_id' => 'タイプ',
            'money.*' => '料金',
            'title' => 'タイトル',
            'preview.*' => '画像に',
            'extra_price.*' => '有料オプション',
            'extra_price' => '有料オプション',
        ];
    }

    public function messages()
    {
        return [
            'sub_start_day.*.string' => '小さなスケジュールを指定してください',
            'sub_start_time.*.string' => '小さなスケジュールを指定してください',
            'preview.required' => '画像は、必ずアップロードしてください。',
            'preview.*.max' => 'アップロードされたファイルは5MBを超えています。',
            'preview.*.mimetypes' => 'JPEG, JPG, GIF, PNG形式のファイルを選択してください。',
            'price.required' => $this->setPriceAttribute() . '、必ず入力してください。',
            'price.min' => $this->setPriceAttribute() . 'には、:min以上の数字を指定してください。',
            'price.max' => $this->setPriceAttribute() . 'には、:max以下の数字を指定してください。',
            'price.numeric' => '半角数字のみを入力して下さい。',
            'price.regex' => '半角数字のみを入力して下さい。',
            'extra_price.*.regex' => '半角数字のみを入力して下さい',
            'extra_price.*.numeric' => '半角数字のみを入力して下さい',
            'money.*.regex' => '半角数字のみを入力して下さい。',
            'money.*.numeric' => '半角数字のみを入力して下さい。',
            'money.*.required' => '金額、必ず入力してください。',
            'money.*.min' => '料金は、:min以上の数字を指定してください。',
            'category_id.required' => 'カテゴリを必ず入力してください。',
        ];
    }

    /**
     * Validate rule option extend
     *
     * @param $rule
     * @return mixed
     */
    private function ruleOptions($rule)
    {
        $rule['money.*'] = 'nullable|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
        $rule['time'] = ['nullable', 'array', function ($attribute, $value, $fail) {
            for ($i = 0; $i < count($this->money); $i++) {
                if ((!empty($this->money[$i]) && empty($this->time[$i]))
                    || (empty($this->money[$i]) && !empty($this->time[$i]))
                ) {
                    if (empty($this->money[$i])) {
                        return $fail(__('errors.MSG_8015'));
                    }

                    return $fail(__('errors.MSG_8014'));
                }
            }
        }];
        $rule['time.*'] = 'nullable|numeric|min:10|max:30';
        $rule['money'] = [function ($attribute, $value, $fail) {
            for ($i = 0; $i < count($this->money); $i++) {
                if ((!empty($this->money[$i]) && empty($this->time[$i]))
                    || (empty($this->money[$i]) && !empty($this->time[$i]))
                ) {
                    return $fail(__('errors.MSG_8003'));
                }
            }
        }];

        return $rule;
    }

    /**
     * Validate optional extra
     *
     * @param $rule
     * @return mixed
     */
    private function ruleExtra($rule)
    {
        $rule['extra_title.*'] = 'nullable|max:60';
        $rule['extra_price.*'] = 'nullable|regex:/^[a-zA-Z0-9]+$/|numeric';

        // var check | check if has optional extra but hasn't extends
        $rule['extra_title'] = ['nullable', 'array', function ($attribute, $value, $fail) {
            for ($i = 0; $i < count($this->extra_title); $i++) {

                if (!empty($this->extra_title[$i]) && empty($this->extra_price[$i])) {
                    return $fail(__('errors.MSG_8015'));
                }

                if (empty($this->extra_title[$i]) && !empty($this->extra_price[$i])) {
                    return $fail(__('errors.MSG_8018'));
                }

            }
        }];

        return $rule;
    }

    /**
     * Validate rule course schedule main course
     *
     * @param $fail
     * @return void
     */
    private function ruleMainSchedule($fail)
    {
        if (count($this->start_day) > 1) {
            for ($i = 0; $i < count($this->start_day) - 1; $i++) {
                $currentStartDatetime = Carbon::parse($this->start_day[$i] . ' ' . $this->start_time[$i])->addMinutes($this->minutes_required);
                $nextStartDatetime = Carbon::parse($this->start_day[$i + 1] . ' ' . $this->start_time[$i + 1]);

                if (!$this->start_day[$i] || !$this->start_time[$i] || !$this->start_day[$i + 1] || !$this->start_time[$i + 1]) {
                    return $fail(__('errors.MSG_8012'));
                }

                if ($currentStartDatetime->lt(now())) {
                    return $fail(__('errors.MSG_8006'));
                }

                if ($currentStartDatetime->gt($nextStartDatetime)) {
                    return $fail(__('errors.MSG_8005'));
                }

                if ($currentStartDatetime->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                    return $fail(__('errors.MSG_8013'));
                }
            }
        } elseif (count($this->start_day) == 1) {
            if (!$this->start_day[0] || !$this->start_time[0]) {
                return $fail(__('errors.MSG_8012'));
            }

            $currentStartDatetime = Carbon::parse($this->start_day[0] . ' ' . $this->start_time[0]);
            if ($currentStartDatetime->lt(now())) {
                return $fail(__('errors.MSG_8006'));
            }

            if ($currentStartDatetime->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                return $fail(__('errors.MSG_8013'));
            }
        } else {
            return $fail(__('errors.MSG_8012'));
        }
    }
}
