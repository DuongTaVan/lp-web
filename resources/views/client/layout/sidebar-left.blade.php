<style>
    .main .sidebar-left__calendar-today__core__day__number .day-active a {
        text-decoration: none;
        color: #46CB90 !important;
        background-color: unset !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>
<div id="time-frame" class="row calendar">
    <div class="col-4 col-md-4 nopadding">
        <div class="calendar__morning f-w6  {{isset($searchParams['time_frame']) && $searchParams['time_frame'] == 1 ? 'active' : ''}}"
             data-value="1">@lang('labels.sidebar_left.in_the_morning')</div>
    </div>
    <div class=" col-4 col-md-4 nopadding">
        <div class="calendar__afternoon f-w6 {{isset($searchParams['time_frame']) && $searchParams['time_frame'] == 2 ? 'active' :''}}"
             data-value="2">@lang('labels.sidebar_left.sometimes')</div>
    </div>
    <div class=" col-4 col-md-4 nopadding">
        <div class="calendar__dinner f-w6 {{isset($searchParams['time_frame']) &&  $searchParams['time_frame'] == 3 ? 'active' :''}}"
             data-value="3">@lang('labels.sidebar_left.after_time')</div>
    </div>
</div>

<div class="row sidebar-left">
    <div class="sidebar-left__calendar-today">
        <div class="sidebar-left__calendar-today__core">
            <div class="sidebar-left__calendar-today__core__header position-relative">
                <div id="calendar-previous"
                     class="sidebar-left__calendar-today__core__header__previous position-absolute">
                    <img src="{{asset('./assets/img/top-log/icon/previous-cal.svg')}}" alt="" class="previous-cal-icon">
                    <img src="{{asset('./assets/img/top-log/icon/previous-cal-mobile-icon.svg')}}" alt="123"
                         class="previous-cal-icon-mobile">
                </div>
                <div class="sidebar-left__calendar-today__core__header__date f-w6" id="date-head">

                </div>
                <div id="calendar-next" class="sidebar-left__calendar-today__core__header__next position-absolute">
                    <img src="{{asset('./assets/img/top-log/icon/next-cal.svg')}}" alt="" class="next-cal-icon">
                    <img src="{{asset('./assets/img/top-log/icon/next-cal-mobile-icon.svg')}}" alt=""
                         class="next-cal-icon-mobile">
                </div>
                <div id="calendar-dropdown"
                     class="sidebar-left__calendar-today__core__header__dropdown-calendar position-absolute">
                    <img src="{{asset('./assets/img/top-log/icon/dropdown-icon.svg')}}" alt=""
                         class="calendar-icon-dropdown" id="calendarIconDropdown">
                </div>
            </div>
            <div class="sidebar-left__calendar-today__core__content">
                <div class="sidebar-left__calendar-today__core__day">
                    <ul class="sidebar-left__calendar-today__core__day__ul">
                        <li class="f-w3">日</li>
                        <li class="f-w3">月</li>
                        <li class="f-w3">火</li>
                        <li class="f-w3">水</li>
                        <li class="f-w3">木</li>
                        <li class="f-w3">金</li>
                        <li class="f-w3">土</li>
                    </ul>
                    <hr>
                    <div class="sidebar-left__calendar-today__core__day__loading">
                        @include('client.common.loading')
                    </div>
                    <div class="sidebar-left__calendar-today__core__day__number1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-left__clear position-relative">
        <div class="sidebar-left__clear__text calendar_reset f-w6">
            @lang('labels.sidebar_left.clear')
        </div>
        <div class="sidebar-left__clear__close calendar_reset">
            <img src="{{asset('./assets/img/top-log/icon/close.svg')}}" alt="">
        </div>
    </div>
    <div class="search-category f-w6">
        @lang('labels.sidebar_left.search_by_category')
    </div>
    <div class="card card-first">
        <div class="card__input-search @if($searchParams['category_type'] === 1) active @endif" value="1">
            <div class="card__input-search__text card__input-search__text-sp f-w6"> @lang('labels.sidebar_left.tell_me_live_streaming')</div>
            <span class="text-small f-w3">(@lang('labels.sidebar_left.live_streaming'))</span>
            <img class="arrow-top" id="category-livestream" src="{{asset('assets/img/common/arrow-top.svg')}}" alt="">
        </div>
        <div class="card__list-search" id="list-search">
            <ul class="card__list-search__ul" id="list-search-ul-skill">
                @forelse($data['categoriesSkill'] as $key => $skill)
                    @if($key === 9)
                        <style>
                            .li-custom {
                                height: 50px !important;
                            }
                        </style>
                        @if($skill['category_id'] == $searchParams['category_id'])
                            <li class="active li-custom" value="{{$skill['category_id']}}">
                                <a class=" custom-text">{{$skill['name']}}</a>
                            </li>
                            @continue
                        @endif

                        <li class="li-custom" value="{{$skill['category_id']}}">
                            <a class=" custom-text"> {{$skill['name']}} </a>
                        </li>
                    @else
                        @if($skill['category_id'] == $searchParams['category_id'])
                            <li class="active" value="{{$skill['category_id']}}">
                                <a>{{$skill['name']}}</a>
                            </li>
                            @continue
                        @endif
                        <li value="{{$skill['category_id']}}">
                            <a>{{$skill['name']}}</a>
                        </li>
                    @endif
                @empty
                    <p class="text-center">@lang('labels.common.no_data')</p>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card__input-search card__search-videocall @if($searchParams['category_type'] === 2) active @endif"
             value="2">
            <div class="card__search-videocall__text card__search-videocall__text-sp  f-w6">@lang('labels.sidebar_left.online_trouble_consultation')</div>
            <span class="text-small f-w3">(@lang('labels.sidebar_left.video_call'))</span>
            <img class="arrow-top" id="category-video" src="{{asset('assets/img/common/arrow-top.svg')}}" alt="">
        </div>
        <div class="card__list-search">
            <ul class="card__list-search__ul" id="list-search-ul-consult">
                @forelse($data['categoriesConsult'] as $consult)
                    @if($consult['category_id'] == $searchParams['category_id'])
                        <li class="active" value="{{$consult['category_id']}}">
                            <a>{{$consult['name']}}</a>
                        </li>
                        @continue
                    @endif
                    <li value="{{$consult['category_id']}}">
                        <a>{{$consult['name']}}</a>
                    </li>
                @empty
                    <p class="text-center">@lang('labels.common.no_data')</p>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card__input-search card__search-videocall-last @if($searchParams['category_type'] === 3) active @endif"
             value="3">
            <div class="card__search-videocall-last__text card__search-videocall-last__text-sp f-w6">@lang('labels.sidebar_left.online_fortune_telling')</div>
            <span class="text-small f-w3">(@lang('labels.sidebar_left.video_call'))</span>
            <img class="arrow-top" id="category-fortune" src="{{asset('assets/img/common/arrow-top.svg')}}" alt="">
        </div>
        <div class="card__list-search">
            <ul class="card__list-search__ul" id="list-search-ul-fortunetelling">
                @forelse($data['categoriesFortunetelling'] as $fortunetelling )
                    @if($fortunetelling['category_id'] == $searchParams['category_id'])
                        <li class="active" value="{{$fortunetelling['category_id']}}">
                            <a>{{$fortunetelling['name']}}</a>
                        </li>
                        @continue
                    @endif
                    <li value="{{$fortunetelling['category_id']}}">
                        <a>{{$fortunetelling['name']}}</a>
                    </li>
                @empty
                    <p class="text-center">@lang('labels.common.no_data')</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>
<script src="{{ mix('js/clients/modules/sidebar-left.js') }}"></script>
