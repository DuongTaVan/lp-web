<div class="teacher-sidebar-right__navbar-order-list__flex">
    @if(auth()->guard('client')->user()->teacher_category_skills != \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
        <a href="{{ route('client.teacher.my-page.service-list', ['tab' => 'clone']) }}">
            <div class="teacher-sidebar-right__navbar-order-list__order {{ request('tab') === 'clone' ? 'active' : '' }}">
                <span>@lang('labels.service-list.services_on_sale_clone')</span>
                <span>新規</span>
            </div>
        </a>
    @endif
    @if(auth()->guard('client')->user()->teacher_category_skills == \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
        <a href="{{ route('client.teacher.my-page.service-list', ['tab' => 'new']) }}">
            <div class="teacher-sidebar-right__navbar-order-list__order {{ request('tab') === 'new' ? 'active' : '' }}">
                <span>@lang('labels.service-list.create_new_service')</span>
                <span>新規</span>
            </div>
        </a>
    @endif
    <a href="{{ route('client.teacher.my-page.service-list') }}">
        <div class="teacher-sidebar-right__navbar-order-list__order {{ request()->filled('tab') ? '' : 'active' }}">
            <span>@lang('labels.service-list.services_on_sale')({{$totalCourseScheduleOpen ?? 0}})</span>
            <span>販売中</span>
        </div>
    </a>
    <a href="{{ route('client.teacher.my-page.service-list', ['tab' => 'cancel']) }}">
        <div class="teacher-sidebar-right__navbar-order-list__cancel {{ request('tab') === 'cancel' ? 'active' : '' }}">
            @lang('labels.service-list.delete_Cancel')
        </div>
    </a>
    <a href="{{ route('client.teacher.my-page.service-list', ['tab' => 'draft']) }}">
        <div class="teacher-sidebar-right__navbar-order-list__cancel {{ request('tab') === 'draft' ? 'active' : '' }}">
            @lang('labels.service-list.draft')
        </div>
    </a>
</div>
