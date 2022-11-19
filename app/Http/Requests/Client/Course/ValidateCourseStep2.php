<?php

namespace App\Http\Requests\Client\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\CourseScheduleRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ValidateCourseStep2 extends FormRequest
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
        $this->formatPrice();

        return parent::getValidatorInstance();
    }

    protected function formatPrice()
    {
        $this->merge([
            'price' => str_replace(',', '', $this->request->get('price')),
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
            'start_day.*' => 'nullable|date_format:Y/m/d',
            'start_time' => 'required|array|max:5',
            'start_time.*' => 'nullable|date_format:H:i',
            'start_day' => ['required', 'array', 'max:5', function ($attribute, $value, $fail) {
                $this->ruleMainSchedule($attribute, $value, $fail);
            }],
            'price' => 'required|regex:/^[a-zA-Z0-9]+$/|numeric|min:1000|max:5000',
            'minutes_required' => 'required|numeric|min:30|max:60',
            'body' => 'required',
            'flow' => 'required',
            'cautions' => 'required',
            'subtitle' => 'required|min:15|max:100'
        ];
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

    public function attributes()
    {
        return [
            'subtitle' => 'タイトル補足説明',
            'start_day' => '開始日',
            'start_time' => '開始時',
            'price' => $this->setPriceAttribute(),
            'minutes_required' => 'ご利用時間',
            'body' => 'サービス内容',
            'flow' => '当日の流れ',
            'cautions' => 'ご利用に当たって',
            'fixed_num' => '固定数',
        ];
    }

    private function ruleMainSchedule($attribute, $value, $fail)
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

        $courseScheduleRepository = app(CourseScheduleRepository::class);
        $listSchedulesCourse = $courseScheduleRepository->listSchedulesCourse(auth('client')->user())->toArray();
        for ($i = 0; $i < count($this->start_day); $i++) {
            $startDate = now()->parse($this->start_day[$i])->format('Y-m-d') . ' ' . $this->start_time[$i] . ':00';
            $endDate = now()->parse($startDate)->addMinutes((int)$this->minutes_required);
            $startDate = now()->parse($startDate);

            $checkSchedule = $this->checkCourseSchedule($listSchedulesCourse, $startDate, $endDate);

            if (!$checkSchedule) {
                return $fail(__('errors.MSG_5050'));
            }
        }
    }

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
}
