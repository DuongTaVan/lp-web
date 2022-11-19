<div class="step-header d-flex">
    <div class="step-header__step text-center active @if($step == 1) direction @endif">
        <p class="name-step">STEP 1</p>
        <span class="title-step">{{ trans('labels.create_course.header_step.step_service') }}</span>
    </div>
    <div class="step-header__step text-center @if($step == 2 || $step == 3) active @endif @if($step == 2) direction @endif">
        <p class="name-step">STEP 2</p>
        <span class="title-step">{{ trans('labels.create_course.header_step.step_schedule') }}</span>
    </div>
    <div class="step-header__step text-center @if($step == 3) active @endif">
        <p class="name-step">STEP 3</p>
        <span class="title-step">{{ trans('labels.create_course.header_step.step_setting') }}</span>
    </div>
</div>
