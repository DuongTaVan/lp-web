<?php

namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseSchedule extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = auth()->guard('client')->user();
        $rules = [
            'preview.*' => 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'minutes_required' => 'required|numeric|min:20',
            'start_day' => ['date_format:Y/m/d', function ($attribute, $value, $fail) {
                $this->ruleMainSchedule($fail);
            }],
            'status' => 'required|in:' . DBConstant::COURSE_STATUS_OPEN . ',' . DBConstant::COURSE_STATUS_DRAFT . ',' . DBConstant::COURSE_STATUS_PREVIEW,
            'time.*' => 'required_with:money.*|nullable|numeric|min:10|max:30',
            'money.*' => 'required_with:time.*|nullable|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000',
            'extra_title.*' => 'required_with:extra_price.*|nullable|max:60',
            'extra_price.*' => 'required_with:extra_title.*|nullable|regex:/^[a-zA-Z0-9]+$/|numeric',
        ];
        if ($user->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION
            || $user->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING
        ) {
            $rules['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
        } else {
            $rules['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000|max:5000';
        }
        if ((int)$this->screen === 1) {
            $rules['price'] = '';
        }

//        if (!isset($this->editDraft)) {
//            $rules['status'] = 'required|in:' . DBConstant::COURSE_STATUS_OPEN . ',' . DBConstant::COURSE_STATUS_DRAFT . ',' . DBConstant::COURSE_STATUS_PREVIEW;
//        }
//
//        // for sub schedule
//        if ($this->is_sub_schedule) {
//            $rules['price'] = 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000';
//        }
//        if (!isset($this->subCourseScheduleDraft) && !isset($this->old_img)) {
//            $rules['preview'] = 'required|array';
//        }


        if (!$this->screen) {
            $rules['subtitle'] = 'required|min:15|max:100';
            $rules['title'] = 'max:70';
            $rules['body'] = 'required';
            $rules['flow'] = 'required';
            $rules['cautions'] = 'required';
//            $this->makeSessionPreviewFile($this, $rules);
        }
        return $rules;
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
        if ($user['teacher_category_consultation'] === DBConstant::TEACHER_CATEGORY_CONSULTATION) {
            $price = __('labels.create_course.validate.consultation.price');
        } elseif ($user['teacher_category_fortunetelling'] === DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
            $price = __('labels.create_course.validate.fortunetelling.price');
        }

        return $price;
    }

    /**
     * Validate rule course schedule main course
     *
     * @param $fail
     * @return void
     */
    private function ruleMainSchedule($fail)
    {
        $schedule = Carbon::parse($this->start_day . ' ' . $this->start_time)->addMinutes($this->minutes_required);

        if (!$this->start_day || !$this->start_time) {
            return $fail(__('errors.MSG_8012'));
        }

        if ($schedule->lt(now())) {
            return $fail(__('errors.MSG_8006'));
        }

        if ($schedule->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
            return $fail(__('errors.MSG_8013'));
        }
    }

    public function attributes()
    {
        return [
            'start_day' => '開始日',
            'start_time' => '開始時',
            'price' => $this->setPriceAttribute(),
            'minutes_required' => 'ご利用時間',
            'preview' => '画像',
            'preview.*' => '画像に',
            'subtitle' => 'タイトル補足説明',
            'body' => ' サービス内容',
            'flow' => '当日の流れ',
            'cautions' => 'ご利用に当たって'

        ];
    }

    public function messages()
    {
        $messages = [];
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
}