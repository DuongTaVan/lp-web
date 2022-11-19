{{-- <small>(@lang('labels.course-detail.tax_included_course'))</small> --}}
<div class="d-flex align-items-center">
    @if(!empty($result['courses']->category->type))
        @switch($result['courses']->category->type)
            @case($result['courses']->category->type === 1)
                <span class="mr-horizontal title-price">@lang('labels.course-detail.course_livestream')</span>
                @break
            @case($result['courses']->category->type === 2)
                <span class="mr-horizontal title-price">@lang('labels.course-detail.course_consultation')</span>
                @break
            @default
                <span class="mr-horizontal title-price">@lang('labels.course-detail.course_fortune')</span>
        @endswitch
    @endif
    <div>
        <span class="text-bold price-schedule">￥{{ number_format($result['courseSchedule']['price']) }}</span>
        <small>(@lang('labels.course-detail.tax_included_course'))</small>
    </div>
</div>
<div class="option-list text-left">
    <form id="purchase-course" disabled="disabled"
          action="{{ route('client.orders.payment.index', ['courseScheduleId' => $courseScheduleId]) }}">
        @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS )
            @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                <div class="d-flex flex-column list-schedule">
                    @php
                        $order = 0;
                    @endphp
                    @foreach($result['courseSchedules'] as $key => $item)
                        @if ($item['num_of_applicants'] < $item['fixed_num'] && $item['purchase_deadline'] > now())
                        <div id="option{{$key}}"
                             data-id="{{ $item["course_schedule_id"] }}"
                             data-url="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}"
                             data-price="{{ number_format($item['price']) }}"
                             data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                             data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                             class="rectangle-course-schedule d-flex flex-column justify-content-center align-items-center position-relative choose-option @if($item['course_schedule_id'] === $result['courses']->course_schedule_id) active @endif ">
                            <span class="rectangle__date">{{ date('m', strtotime($item['start_datetime'])) }}月{{ date('d', strtotime($item['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]  }})</span>
                            <span class="rectangle__time">
                    @if(isset($item['actual_start_date']))
                                    {{ date_format(date_create($item['actual_start_date']), 'H:i') }}
                                    - {{ date_format(date_create($item['actual_end_date']), 'H:i') }}
                                @else
                                    {{ date_format(date_create($item['start_datetime']), 'H:i') }}
                                    - {{ date_format(date_create($item['end_datetime']), 'H:i') }}
                                @endif
                </span>
                            @if(count($result['courseSchedules']) > 1)
                                <img class="icon-arrow position-absolute @if($key === 0) rotate @endif"
                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                            @endif
                            <span class="rectangle__text">
                    {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                </span>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="rectangle-none">
                    <img src="{{ asset('assets/img/clients/course-detail/sad-face.svg') }}" alt="">
                </div>
                <div>
                    @if(auth('client')->check())
                        <button id="purchase_procedure" type="submit">
                            @lang('labels.course-detail.purchase_procedure_course')
                        </button>
                    @else
                        <a href="#" data-toggle="modal" data-target="#modalLogin"
                           id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course')</a>
                    @endif
                </div>
            @endif
        @else
            @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                <div class="d-flex flex-column list-schedule">
                    @php
                        $order = 0;
                    @endphp
                    @foreach($result['courseSchedules'] as $key => $item)
                        @if ($item['num_of_applicants'] < $item['fixed_num'] && $item['purchase_deadline'] > now())
                        <div id="option{{$key}}" data-id="{{ $item["course_schedule_id"] }}"
                             data-url="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}"
                             data-price="{{ number_format($item['price']) }}"
                             data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                             data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                             class="rectangle-course-schedule d-flex flex-column justify-content-center align-items-center position-relative choose-option @if($item['course_schedule_id'] === $result['courses']->course_schedule_id) active @endif ">
                            <span class="rectangle__date">{{ date('m', strtotime($item['start_datetime'])) }}月{{ date('d', strtotime($item['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]  }})</span>
                            <span class="rectangle__time">
                    @if(isset($item['actual_start_date']))
                                    {{ date_format(date_create($item['actual_start_date']), 'H:i') }}
                                    - {{ date_format(date_create($item['actual_end_date']), 'H:i') }}
                                @else
                                    {{ date_format(date_create($item['start_datetime']), 'H:i') }}
                                    - {{ date_format(date_create($item['end_datetime']), 'H:i') }}
                                @endif
                </span>
                            @if(count($result['courseSchedules']) > 1)
                                <img class="icon-arrow position-absolute @if($key === 0) rotate @endif"
                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                            @endif
                            <span class="rectangle__text">
                    {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                </span>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="rectangle-none">
                    <img src="{{ asset('assets/img/clients/course-detail/sad-face.svg') }}" alt="">
                </div>
                <div>
                    @if(auth('client')->check())
                        <button id="purchase_procedure" type="submit">
                            @lang('labels.course-detail.purchase_procedure_course')
                        </button>
                    @else
                        <a href="#" data-toggle="modal" data-target="#modalLogin"
                           id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course')</a>
                    @endif
                </div>
            @endif
        @endif
        @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS )
            @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                <div class="deadline d-flex">
                    <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                    <span class="deadline__result">{{ (date('m', strtotime($result['courseSchedule']['purchase_deadline']))) }}月{{ (date('d', strtotime($result['courseSchedule']['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($result['courseSchedule']['purchase_deadline']))] }})</span>
                </div>
                @if($result['courses']->category->type === 1)
                    <div class="number_of_participants d-flex">
                        <span class="number_of_participants__title">@lang('labels.course-detail.number_of_participants_course')</span>
                        <span class="number_of_participants__result">{{ number_format($result['courseSchedule']['num_of_applicants']) }}人</span>
                    </div>
                @endif
                    <div class="purchase-deadline">※開催１時間前</div>
                <div class="a">

                    <button type="submit" id="purchase_procedure"
                            {{--                            @if(!auth('client')->check())--}}
                            {{--                        data-toggle="modal" data-target="#modalLogin"--}}
                            {{--                            onclick="return false;"--}}
                            {{--                            @endif--}}
                            class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants) bg-disabled @endif">
                        @if(auth('client')->id() === $result['courses']->user_id)
                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_notification')
                    </span>
                        @elseif($result['courseSchedulePurchased'])
                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_purchase_notification')
                    </span>
                        @elseif($result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants)

                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_service_has_already_been_purchased')
                    </span>
                        @else
                            @lang('labels.course-detail.purchase_procedure_course')
                        @endif

                    </button>
                </div>
            @endif
        @else
            @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                <div class="deadline d-flex">
                    <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                    <span class="deadline__result">{{ (date('m', strtotime($result['courseSchedule']['purchase_deadline']))) }}月{{ (date('d', strtotime($result['courseSchedule']['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($result['courseSchedule']['purchase_deadline']))] }})</span>
                </div>
                @if($result['courses']->category->type === 1)
                    <div class="number_of_participants d-flex">
                        <span class="number_of_participants__title">@lang('labels.course-detail.number_of_participants_course')</span>
                        <span class="number_of_participants__result">{{ number_format($result['courseSchedule']['num_of_applicants']) }}人</span>
                    </div>
                @endif
                <div class="purchase-deadline">※開催１時間前</div>
                <div class="a">

                    <button type="submit" id="purchase_procedure"
                            {{--                            @if(!auth('client')->check())--}}
                            {{--                        data-toggle="modal" data-target="#modalLogin"--}}
                            {{--                            onclick="return false;"--}}
                            {{--                            @endif--}}
                            class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants) bg-disabled @endif">
                        @if(auth('client')->id() === $result['courses']->user_id)
                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_notification')
                    </span>
                        @elseif($result['courseSchedulePurchased'])
                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_purchase_notification')
                    </span>
                        @elseif($result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants)

                            @lang('labels.course-detail.purchase_procedure_course')
                            <span class="tooltip-text">
                        @lang('labels.course-detail.tool_tip_service_has_already_been_purchased')
                    </span>
                        @else
                            @lang('labels.course-detail.purchase_procedure_course')
                        @endif

                    </button>
                </div>
            @endif
        @endif
        @if(!empty($result['courseSchedules']))
            @if(isset($result['courses']->category->type)
            && $result['courses']->category->type === 3
            && isset($result['optionData'])
            && count($result['optionData']) > 0 )
                <section id="charged-option">
                    <div id="option-schedule" class="charged-option d-flex justify-content-center align-items-center">
                        <img src="{{asset('assets/img/clients/course-detail/circle-plus.svg')}}" alt="">
                        <span class="charged-option-text">@lang('labels.course-detail.charged_option_course')</span>
                        <img class="arrow-down" src="{{asset('assets/img/clients/course-detail/arrow-right-grey.svg')}}"
                             alt="">
                    </div>
                    <div class="table-option disable-option">
                        @foreach($result['optionData'] as $key => $item)
                            @if($result['courseSchedulePurchased'])
                                @if(isset($result['optionExtraPurchased']) && count($result['optionExtraPurchased']) > 0)
                                    @foreach($result['optionExtraPurchased'] as $key => $optionPurchase)
                                        <div class="table-option-item d-flex align-items-center justify-content-between">
                                            <label class="checkbox">
                                                @if($result['courseSchedulePurchased'] && $item['optional_extra_id'] === $optionPurchase['optional_extra_id'])
                                                    <input type="radio" checked name="optional_extra_id[]"
                                                           data-value="{{($item['optional_extra_id'])}}"
                                                           value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                                @else
                                                    <input type="checkbox" disabled @if($item->isPurchased) checked
                                                           @endif
                                                           data-value="{{($item['optional_extra_id'])}}"
                                                           value="{{$item['title']}}"> {{$item['title']}}
                                                @endif
                                                <span class="checkmark"></span>
                                            </label>
                                            <div style="white-space: nowrap">
                                                <img src="{{asset('assets/img/clients/course-detail/add.svg')}}" alt="">
                                                <span>¥{{number_format($item['price'])}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="table-option-item d-flex align-items-center justify-content-between">
                                        <label class="checkbox">
                                            <input type="checkbox" disabled
                                                   data-value="{{($item['optional_extra_id'])}}"
                                                   value="{{$item['title']}}"> {{$item['title']}}
                                            <span class="checkmark"></span>
                                        </label>
                                        <div style="white-space: nowrap">
                                            <img src="{{asset('assets/img/clients/course-detail/add.svg')}}" alt="">
                                            <span class="option-price">¥{{number_format($item['price'])}}</span>
                                        </div>
                                    </div>
                                @endif
                            @elseif(auth('client')->check() && auth('client')->id() === $result['courses']->user->user_id)
                                <div class="table-option-item d-flex align-items-center justify-content-between">
                                    <label class="checkbox">
                                        <input type="checkbox" disabled name="optional_extra_id[]"
                                               data-value="{{($item['optional_extra_id'])}}"
                                               value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <div style="white-space: nowrap">
                                        <img src="{{asset('assets/img/clients/course-detail/add.svg')}}" alt="">
                                        <span class="option-price">¥{{number_format($item['price'])}}</span>
                                    </div>
                                </div>
                            @else
                                <div class="table-option-item d-flex align-items-center justify-content-between">
                                    <label class="checkbox">
                                        <input type="checkbox" name="optional_extra_id[]"
                                               data-value="{{($item['optional_extra_id'])}}"
                                               value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <div style="white-space: nowrap">
                                        <img src="{{asset('assets/img/clients/course-detail/add.svg')}}" alt="">
                                        <span class="option-price">¥{{number_format($item['price'])}}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        @endif
        <span class="Admission-fee__warning text-center">※キャンセルは開催日前日２1:５９まで</span>
    </form>
</div>

@if ($result['courses']->category->type === 1 && config('app.socket'))
    <script src="{{ mix('js/portals/realtime.js') }}"></script>
@endif
