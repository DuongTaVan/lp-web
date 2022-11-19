@extends('client.base.base')

@section('content')
    <div class="sub-course-container">
        <div class="order-view__header">
            <div class="order-view__header__text">
                {{__('labels.users.teacher_live_stream.sub_course_detail.course_single')}}
            </div>
        </div>
        <div class="order-view__sub-course-detail">
            <div class="order-view__sub-course-detail__content">
                <div class="subcourse-block" style="padding: 12px 0 12px 69px;">
                    <div class="subcourse-block__content" style="margin-bottom: 6px;">
                        <div class="d-flex course-title">
                            <div class="subcourse-block__content__title title"> 講座のタイトル</div>

                            <div class="subcourse-block__content__time name-course">{{$course->title}}</div>
                        </div>
                    </div>
                    <div class="subcourse-block__content" style="margin-bottom: 5px;">
                        <div class="d-flex">
                            <div class="subcourse-block__content__title"> {{__('labels.users.teacher_live_stream.sub_course_detail.time_course')}}</div>

                            <div class="d-flex flex-nowrap subcourse-block__content__time">
                                <input type="text" class="form-control input-time" aria-describedby="addon-wrapping"
                                       value="{{ number_format($parentSubCourse[0]->minutes_required) }}"
                                       disabled>
                                <span class="input-group-text subcourse-block__content__time__time-single"
                                      id="addon-wrapping">{{__('labels.unit.minute')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="subcourse-block__content">
                        <div class="d-flex">
                            <div class="subcourse-block__content__title"> {{__('labels.users.teacher_live_stream.sub_course_detail.date_and_time')}}</div>

                            <div class="d-block">
                                @foreach($parentSubCourse as $key => $item)
                                    @if($item->fixed_num > $item->num_of_applicants)
                                        <div class="subcourse-block__content__option option-outline">
                                            <label class="subcourse-block__content__option__option-outline subcourse-option">
                                                <input type="radio" {{ !$key ? 'checked' : '' }} name="radio">
                                                <span class="checkmark"></span>
                                                <span class="title">{{ $item->datetime_detail }}</span>
                                                <input class="time" type="hidden"
                                                       value="{{ $item->minutes_required }}">
                                                <input class="price" type="hidden"
                                                       value="{{number_format($item->price)}}">
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="subcourse-block__content mb-0">
                        <div class="d-flex">
                            <div class="subcourse-block__content__title title-money">{{__('labels.users.teacher_live_stream.sub_course_detail.price')}}</div>
                            <div class="d-flex flex-nowrap subcourse-block__content__time">
                                         <span class="input-group-text subcourse-block__content__time__time-single ml-0 sub-course-money"
                                               id="addon-wrapping">{{__('labels.unit.money_jp')}}</span>
                                <input type="text" class="form-control input-money"
                                       aria-describedby="addon-wrapping"
                                       value="{{ number_format($parentSubCourse[0]->price) }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.subcourse-option').click(function (e) {
                let time = $(this).find('.time').val();
                let price = $(this).find('.price').val();
                $('.input-time').val(time);
                $('.input-money').val(price);
            })
        });
    </script>
@endsection
