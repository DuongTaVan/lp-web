<?php


namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\CourseScheduleRepository;

class UpdateCourseVideoCallRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'title' => 'required|max:70',
            'subtitle' => 'required|min:15|max:100',
            'body' => 'required',
            'flow' => 'required',
            'cautions' => 'required',
            'minutes_required' => 'required|numeric|min:30',
            'price' => 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000',
//            'preview' => 'required|array',
            'preview.*' => 'mimetypes:image/png,image/jpg,image/jpeg,image/gif|max:5120',
            'start_time' => 'required|array',
            'start_time.*' => 'nullable|date_format:H:i',
            'category_id' => 'required',
            'is_mask_required' => 'required:in' . DBConstant::FACEMASK_OK . ',' . DBConstant::FACEMASK_NG,
            'status' => 'required|in:' . DBConstant::COURSE_STATUS_DRAFT . ',' . DBConstant::COURSE_STATUS_OPEN . ',' . DBConstant::COURSE_STATUS_PREVIEW,
            'start_day.*' => 'required|date_format:Y/m/d',
            'start_day' => ['required_if:course_schedule_id,null', function ($attribute, $value, $fail) {
                $schedule = Carbon::parse($this->start_day[0] . ' ' . $this->start_time[0])->addMinutes($this->minutes_required);
                if ($schedule->lt(now())) {
                    return $fail(__('errors.MSG_8006'));
                }

                if ($schedule->gte(now()->addDays(Constant::MAX_DAY_SCHEDULE_DATE)->format('Y-m-d'))) {
                    return $fail(__('errors.MSG_8013'));
                }
                // check start time already exists
                $courseScheduleRepository = app(CourseScheduleRepository::class);
                // Check all course schedule of user .
                $listSchedulesCourse = $courseScheduleRepository->listSchedulesCourse(auth('client')->user(), $this->course_schedule_id)->toArray();
                for ($i = 0, $iMax = count($this->start_day); $i < $iMax; $i++) {
                    $startDate = now()->parse($this->start_day[$i])->format('Y-m-d') . ' ' . $this->start_time[$i] . ':00';
                    $endDate = now()->parse($startDate)->addMinutes((int)$this->minutes_required);
                    $startDate = now()->parse($startDate);

                    $checkSchedule = $this->checkCourseSchedule($listSchedulesCourse, $startDate, $endDate);
                    if (!$checkSchedule) {
                        return $fail(__('errors.MSG_5050'));
                    }
                }
            }],
        ];

        $user = auth()->guard('client')->user();

        $this->makeSessionPreviewFile($this, $rules);

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

    /**
     * Check course schedule when edit.
     *
     * @param $listCourseSchedule
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    private function checkCourseSchedule($listCourseSchedule, $startDate, $endDate)
    {
        foreach ($listCourseSchedule as $courseSchedule) {
            $oldStart = now()->parse($courseSchedule['start_datetime']);
            $oldEnd = now()->parse($courseSchedule['end_datetime']);
            if (($startDate->gte($oldStart) && $startDate->lte($oldEnd)) || ($endDate->gte($oldStart) && $endDate->lte($oldEnd))) {
                return false;
            }
        }

        return true;
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
    }

    /**
     * Set attribute price.
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
}
