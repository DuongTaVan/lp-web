<button type="submit" id="purchase_procedure"
        @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
            class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants) bg-disabled @endif">
    @else
        class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants)
            bg-disabled
        @endif"
    @endif>
    @if(true)
        @lang('labels.course-detail.purchase_procedure_course')
    @elseif(auth('client')->id() === $result['courses']->user->user_id)
        @lang('labels.course-detail.purchase_procedure_course')
    @else
        @lang('labels.course-detail.purchase_procedure_course')
    @endif
</button>
