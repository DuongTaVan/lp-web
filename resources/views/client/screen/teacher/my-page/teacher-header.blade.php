@if(auth('client')->user()->user_type == \App\Enums\DBConstant::USER_TYPE_TEACHER)
<div class="main-mypage-teacher__header">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    @php 
        $showMenuTab = false;
        if (\Request::route() && Request::route()->getName() === 'client.student.my-page.dashboard' || Request::route()->getName() === 'client.teacher.my-page.dashboard') {
            $showMenuTab = true;
        }
        
    @endphp 
    <div class="teacher-header__left" style="width: 48%" onclick="setRoleTab('student-tab-btn')">
        <a href="{{ route('client.student.my-page.dashboard') }}" class="text-left text-nowrap click-menu-sp not-redirect @if(Request::is('student/*')) active-button @endif" style="text-decoration: none;">
            {{ trans('labels.dashboard-livestream.buyer') }}
        </a>
    </div>
    <div class="teacher-header__right" style="width: 48%" onclick="setRoleTab('teacher-tab-btn')">
        <a href="{{route('client.teacher.my-page.dashboard')}}"
           class="text-right text-nowrap click-menu-sp not-redirect @if(Request::is('teacher/*')) active-button @endif" style="text-decoration: none;" style="text-decoration: none;">{{ trans('labels.dashboard-livestream.seller') }} </a>
    </div>
</div>
@endif
<script>
    $('.not-redirect').click(function(event){
        if (window.innerWidth < 526) {
            event.preventDefault();
        }
    });
    function setRoleTab(e) {
        if (window.innerWidth < 526) {
            $('.teacher-tab-btn, .student-tab-btn').removeClass('active show');
            $(`.${e}`).addClass('active show');
        }
    }
</script>