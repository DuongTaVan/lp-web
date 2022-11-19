@foreach($data as $item)
    <div class="menu-evaluation__description d-flex">
        <div class="avt">
            @if($item['is_public'] === 1)
                <img src="{{ $item->image }}" alt="">
            @else
                <img src="{{asset('assets/img/clients/header-common/not-login.svg')}}" alt="">
            @endif
                @php
                    if(isset($item->date_of_birth))
                    $current_age = Carbon\Carbon::parse($item->date_of_birth)->age;
                    else
                        $current_age = null;
                @endphp
            <div class="age fs-12">
                {{ $item->sex_text }} @fakeBirthday($current_age)
            </div>
        </div>
        <div class="menu-evaluation__rectangle">
            @if($item['is_public'] === 1)
                <p class="title text-left f-w6">{{$item['nickname']}} </p>
            @else
                <p class="title text-left f-w6">@lang('labels.course-detail.noName')</p>
            @endif
            <div class="d-flex justify-content-between align-items-end mb-3">
                <div class="d-flex">
                    <div class="rating-position">
                        <ul class="content-rating rating-star d-flex">
                            @include('client.common.rating-active', ['rating' => ratingProcess($item['rating'])])
                        </ul>
                    </div>
                    <p class="start-text">{{ $item['rating'] >= 5 ? 5 :  bcdiv($item['rating'],1,1)}}</p>
                </div>
                <p class="text">{{ date_format(date_create($item['created_at']), 'Y/m/d') }}
                    @lang('labels.course-detail.hold_course')</p>
            </div>
            <span>{{$item['comment']}}</span>
        </div>
    </div>
@endforeach
