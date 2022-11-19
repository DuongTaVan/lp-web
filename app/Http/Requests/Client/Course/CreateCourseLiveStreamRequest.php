<?php

namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseLiveStreamRequest extends FormRequest
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
        return parent::getValidatorInstance(); // TODO: Change the autogenerated stub
    }

    protected function formatPrice()
    {
        $this->merge([
            'price' => str_replace(',', '', $this->request->get('price')),
            'price_sub_course' => str_replace(',', '', $this->request->get('price_sub_course'))
        ]);
    }

    protected function formatPriceDot()
    {
        $this->merge([
            'price' => str_replace('.', '', $this->request->get('price')),
            'price_sub_course' => str_replace('.', '', $this->request->get('price_sub_course'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'step' => 'required|numeric|in:1,2'
        ];

        $this->makeSessionPreviewFile($this, $rule);

        if ((int)$this->step === 1) {
            $rule['title'] = 'required|max:70';
            $rule['body'] = 'required';
            $rule['flow'] = 'required';
            $rule['cautions'] = 'required';
            $rule['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000|max:5000';
            $rule['subtitle'] = 'required|min:15|max:100';
            $rule['is_mask_required'] = 'required|in:' . DBConstant::FACEMASK_OK . ',' . DBConstant::FACEMASK_NG;
            $rule['status'] = 'required|in:' . DBConstant::COURSE_STATUS_PREVIEW . ',' . DBConstant::COURSE_STATUS_DRAFT;
//            $rule['preview'] = 'required|array';
            $rule['preview.*'] = 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120';
            $rule['category_id'] = 'required';
            if (($this->sub_minutes_required && !$this->price_sub_course)
                || (!$this->sub_minutes_required && $this->price_sub_course)) {
                $rule['sub_minutes_required'] = 'required|numeric|min:30|max:60';
                $rule['price_sub_course'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
            } else {
                $rule['sub_minutes_required'] = 'nullable';
                $rule['price_sub_course'] = 'nullable';
            }
        }

        if ((int)$this->step === 2) {
            $rule['body'] = 'required';
            $rule['flow'] = 'required';
            $rule['cautions'] = 'required';
            $rule['subtitle'] = 'required|min:15|max:100';
            $rule['minutes_required'] = 'required|numeric|min:30|max:60';
            $rule['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000|max:5000';
            $rule['status'] = 'required|in:' . DBConstant::COURSE_STATUS_PREVIEW . ',' . DBConstant::COURSE_STATUS_DRAFT . ',' . DBConstant::COURSE_STATUS_OPEN;
            $rule['start_day.*'] = 'nullable|date_format:Y/m/d';
            $rule['start_time'] = 'required|array|max:5';
            $rule['start_time.*'] = 'nullable|date_format:H:i';
            $rule['start_day'] = ['required', 'array', 'max:5', function ($attribute, $value, $fail) {
                $this->ruleMainSchedule($fail);
            }];

            if ($this->sub_minutes_required || $this->price_sub_course || $this->sub_start_day[0] || $this->sub_start_time[0]) {
                $rule['sub_start_day.*'] = 'required|date_format:Y/m/d';
                $rule['sub_start_time.*'] = 'required|date_format:H:i';
                $rule['sub_start_day'] = ['required', 'array', function ($attribute, $value, $fail) {
                    $this->ruleSubSchedule($fail);
                }];

                $rule['sub_minutes_required'] = 'required|numeric|min:30|max:60';
                $rule['price_sub_course'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
                $rule['sub_start_time'] = 'required|array';
            } else {
                $rule['sub_minutes_required'] = 'nullable';
                $rule['price_sub_course'] = 'nullable';
                $rule['sub_start_day.*'] = 'nullable';
                $rule['sub_start_time.*'] = 'nullable';
            }

//            if (!isset($this->old_img)) {
//                $rule['preview'] = 'required|array';
//                $rule['preview.*'] = 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120';
//            }
        }

        return $rule;
    }

    /**
     * Set attribute price
     *
     * @return string
     */
    private function setPriceAttribute()
    {
        $user = auth('client')->user();
        if (!$user) {
            return '';
        }
        $price = __('labels.create_course.validate.livestream.price');
        if ($user->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION) {
            $price = __('labels.create_course.validate.consultation.price');
        } elseif ($user->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
            $price = __('labels.create_course.validate.fortunetelling.price');
        }

        return $price;
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
            'price_sub_course' => '料金',
            'sub_minutes_required' => 'ご利用時間',
            'sub_start_day' => 'サブ_開始日',
            'sub_start_time' => 'サブ_開始時',
            'preview' => '画像',
            'money' => '価格',
            'time' => '時間',
            'extra_title.*' => 'タイトル',
            'category_id' => 'タイプ',
            'money.*' => '価格',
            'title' => 'タイトル',
            'preview.*' => '画像'
        ];
    }

    public function messages()
    {

        return [
            'sub_start_day.*.string' => '小さなスケジュールを指定してください',
            'sub_start_time.*.string' => '小さなスケジュールを指定してください',
            'price.required' => $this->setPriceAttribute() . '、必ず入力してください。',
            'price.min' => $this->setPriceAttribute() . 'には、:min以上の数字を指定してください。',
            'price.max' => $this->setPriceAttribute() . 'には、:max以下の数字を指定してください。',
            'price.regex' => '半角数字のみを入力して下さい。',
            'price.numeric' => '半角数字のみを入力して下さい。',
            'preview.*.max' => 'アップロードされたファイルは5MBを超えています。',
            'preview.*.mimetypes' => '画像には、有効な正規表現を指定してください。',
            'preview.required' => '画像は、必ずアップロードしてください。',
            'category_id.required' => 'カテゴリを必ず入力してください。',
            'price_sub_course.regex' => '半角数字のみを入力して下さい',
            'price_sub_course.number' => '半角数字のみを入力して下さい',
            'price_sub_course.required' => Constant::HANDLE_SUB_PRICE,
        ];
    }

    /**
     * Validate rule main course schedule
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
     * Check sub start day .
     *
     * @param $fail
     */
    private function checkSubStartDay($fail)
    {
        //Get array y-m-d h:i:s parent.
        if (isset($this->start_day) && isset($this->sub_start_day)) {
            foreach ($this->start_day as $key => $startDay) {
                $dateParent = Carbon::parse($this->start_day[$key] . ' ' . $this->start_time[$key])->format('Y-m-d H:i:s');
                foreach ($this->sub_start_day as $key => $subStartDay) {
                    if ($dateParent === Carbon::parse($this->sub_start_day[$key] . ' ' . $this->sub_start_time[$key])->format('Y-m-d H:i:s')) {
                        return $fail(__('errors.MSG_5051'));
                    }
                }
            }
        }
    }

}
