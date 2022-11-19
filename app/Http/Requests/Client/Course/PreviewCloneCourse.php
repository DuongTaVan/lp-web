<?php

namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PreviewCloneCourse extends FormRequest
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
        $this->formatPrice();
        $this->formatPriceDot();
        return parent::getValidatorInstance();
    }

    protected function formatPrice()
    {
        $money = array_map(function ($item) {
            return str_replace(',', '', $item);
        }, $this->money ?? []);
        $this->merge([
            'price' => str_replace(',', '', $this->request->get('price')),
            'price_sub_course' => str_replace(',', '', $this->request->get('price_sub_course')),
            'money' => $money
        ]);
    }

    protected function formatPriceDot()
    {
        $money = array_map(function ($item) {
            return str_replace('.', '', $item);
        }, $this->money ?? []);
        $this->merge([
            'price' => str_replace('.', '', $this->request->get('price')),
            'price_sub_course' => str_replace('.', '', $this->request->get('price_sub_course')),
            'money' => $money
        ]);
    }

    /**
     * Set attribute price
     *
     * @return string
     */
    private function setPriceAttribute()
    {
        $price = __('labels.create_course.validate.livestream.price');
        if (auth('client')->user()->teacher_category_consultation) {
            $price = __('labels.create_course.validate.consultation.price');
        } elseif (auth('client')->user()->teacher_category_fortunetelling) {
            $price = __('labels.create_course.validate.fortunetelling.price');
        }

        return $price;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = auth()->guard('client')->user();
        $rule = [
            'screen' => 'required|in:LIVESTREAM-1,LIVESTREAM-2,LIVESTREAM-3,CONSULTATION,FORTUNE',
            'subtitle' => 'required|min:15|max:100',
            'body' => 'required',
            'flow' => 'required',
            'cautions' => 'required',
            'preview.*' => 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'start_day.*' => 'date_format:Y/m/d',
            'start_time.*' => 'date_format:H:i',
            'sub_start_day.*' => 'nullable|date_format:Y/m/d',
            'sub_start_time.*' => 'nullable|date_format:H:i',
            'is_mask_required' => 'required|in:' . DBConstant::FACEMASK_OK . ',' . DBConstant::FACEMASK_NG,
            'time.*' => 'required_with:money.*|nullable|numeric|min:10|max:30',
            'money.*' => 'required_with:time.*|nullable|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000',
            'extra_title.*' => 'required_with:extra_price.*|nullable|max:60',
            'extra_price.*' => 'required_with:extra_title.*|nullable|regex:/^[a-zA-Z0-9]+$/|numeric',
        ];

        if ($this->screen === 'LIVESTREAM-1') {
            $rule['category_id'] = 'required';
        } else {
            $rule['minutes_required'] = 'required|numeric|min:20';
            $rule['start_time'] = 'required|array';
            $rule['start_day'] = ['required', 'array', function ($attribute, $value, $fail) {
                $this->ruleMainSchedule($attribute, $value, $fail);
            }];
        }
        if ($this->screen === 'LIVESTREAM-3') {

            $rule['sub_start_time'] = 'array';
            $rule['sub_start_day'] = ['array', function ($attribute, $value, $fail) {
                $this->ruleSubSchedule($fail);
            }];
            $rule['sub_minutes_required'] = [function ($attribute, $value, $fail) {
                $this->ruleSubMinute($fail);
            }];
            if (!empty($this->sub_start_day) && count($this->sub_start_day) > 0) {
                if ($this->sub_start_day[0] != null && $this->sub_start_time[0] != null) {
                    if ($this->price_sub_course === '') {
                        $rule['price_sub_course'] = 'required';
                    }
                }
            }
//            if (isset($this->start_day) && isset($this->sub_start_day)) {
//                $rule['price_sub_course'] = 'required';
//                if (isset($this->is_clone) && count($this->sub_start_day) === 1 && $this->sub_start_day[0] === null && $this->sub_start_time[0] === null && $this->price_sub_course === '') {
//                    $rule['price_sub_course'] = 'nullable';
//                }
//            }
        }
        if ($user->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION
            || $user->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING
        ) {
            $rule['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
        } else {
            $rule['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000|max:5000';
        }

        $this->makeSessionPreviewFile($this, $rule);
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
            'price_sub_course' => '入場料',
        ];
    }

    public function messages()
    {
        $messages = [
            'sub_start_day.*.string' => '小さなスケジュールを指定してください',
            'sub_start_time.*.string' => '小さなスケジュールを指定してください',
            'preview.*.max' => 'アップロードされたファイルは5MBを超えています。',
            'preview.required' => '画像は、必ずアップロードしてください。',
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

        if ($this->request->get('extra_price')) {
            foreach ($this->request->get('extra_price') as $key => $val) {
                $messages['extra_price.' . $key . '.required_with'] = "オプションは、必ず指定してください。";
            }
        }
        if ($this->request->get('extra_title')) {
            foreach ($this->request->get('extra_title') as $key => $val) {
                $messages['extra_title.' . $key . '.required_with'] = "オプションは、必ず指定してください。";
            }
        }
        if ($this->request->get('time')) {
            foreach ($this->request->get('time') as $key => $val) {
                $messages['time.' . $key . '.required_with'] = "延長リクエストは、必ず指定してください。";
            }
        }
        if ($this->request->get('money')) {
            foreach ($this->request->get('money') as $key => $val) {
                $messages['money.' . $key . '.required_with'] = "延長リクエストは、必ず指定してください。";
            }
        }

        return $messages;
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
            for ($i = 0, $iMax = count($this->money); $i < $iMax; $i++) {
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
            for ($i = 0, $iMax = count($this->extra_title); $i < $iMax; $i++) {
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
     * @param $attribute
     * @param $value
     * @param $fail
     * @return void
     */
    private function ruleMainSchedule($attribute, $value, $fail)
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

    /**
     * Validate rule sub course schedule
     *
     * @param $fail
     * @return void
     */
    private function ruleSubSchedule($fail)
    {
        $this->checkSubStartDay($fail);
        if (count($this->sub_start_day) > 1) {
            for ($i = 0; $i < count($this->sub_start_day) - 1; $i++) {
                $currentStartDatetime = Carbon::parse($this->sub_start_day[$i] . ' ' . $this->sub_start_time[$i])->addMinutes($this->sub_minutes_required);
                $nextStartDatetime = Carbon::parse($this->sub_start_day[$i + 1] . ' ' . $this->sub_start_time[$i + 1]);

                if (!$this->sub_start_day[$i] || !$this->sub_start_time[$i] || !$this->sub_start_day[$i + 1] || !$this->sub_start_time[$i + 1]) {
                    return $fail(__('errors.MSG_8012'));
                }

                if ($currentStartDatetime->lt(now()) || $nextStartDatetime->lt(now())) {
                    return $fail(__('errors.MSG_8006'));
                }

                if ($currentStartDatetime->gt($nextStartDatetime)) {
                    return $fail(__('errors.MSG_8005'));
                }

                if ($currentStartDatetime->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                    return $fail(__('errors.MSG_8013'));
                }
            }
        } elseif (count($this->sub_start_day) == 1) {
            if ($this->sub_start_day[0] != null && $this->sub_start_time[0] != null && $this->price_sub_course != '') {
                if (!$this->sub_start_day[0] || !$this->sub_start_time[0]) {
                    return $fail(__('errors.MSG_8012'));
                }

                $currentStartDatetime = Carbon::parse($this->sub_start_day[0] . ' ' . $this->sub_start_time[0]);
                if ($currentStartDatetime->lt(now())) {
                    return $fail(__('errors.MSG_8006'));
                }

                if ($currentStartDatetime->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                    return $fail(__('errors.MSG_8013'));
                }
            }

        } else {
            return $fail(__('errors.MSG_8012'));
        }
    }

    /**
     * @param $fail
     * @return void
     */
    private function ruleSubMinute($fail)
    {
        if (!empty($this->sub_start_day) && count($this->sub_start_day) > 0) {
            if ($this->sub_start_day[0] != null && $this->sub_start_time[0] != null) {
                if ($this->sub_minutes_required === '0') {
                    return $fail(__('errors.MSG_8021'));
                }
            }
        }
    }


    /**
     * Check sub start day .
     *
     * @param $fail
     * @return void
     */
    private function checkSubStartDay($fail)
    {
        //Get array y-m-d h:i:s parent.
        if (isset($this->start_day) && isset($this->sub_start_day)) {
            foreach ($this->start_day as $key => $startDay) {
                $dateParent = Carbon::parse($this->start_day[$key] . ' ' . $this->start_time[$key])->format('Y-m-d H:i:s');
                if (isset($this->is_clone) && count($this->sub_start_day) === 1 && $this->sub_start_day[0] === null && $this->sub_start_time[0] === null) {
                    return true;
                } elseif (count($this->sub_start_day) === 1 && $this->sub_start_day[0] === null && $this->sub_start_time[0] === null && $this->price_sub_course === '' && (int)$this->sub_minutes_required === 0) {
                    return true;
                }
                elseif (count($this->sub_start_day) === 1 && ($this->sub_start_day[0] === null || $this->sub_start_time[0] === null)) {
                    return true;
                }
                else {
                    foreach ($this->sub_start_day as $key => $subStartDay) {
                        if (Carbon::parse($this->sub_start_day[$key] . ' ' . $this->sub_start_time[$key])->lt(now())) {
                            return $fail(__('errors.MSG_8006'));
                        }
                        if ($dateParent === Carbon::parse($this->sub_start_day[$key] . ' ' . $this->sub_start_time[$key])->format('Y-m-d H:i:s')) {
                            return $fail(__('errors.MSG_5051'));
                        }
                        if (Carbon::parse($this->sub_start_day[$key] . ' ' . $this->sub_start_time[$key])->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                            return $fail(__('errors.MSG_8013'));
                        }
                    }
                }
            }
        }

    }

}
