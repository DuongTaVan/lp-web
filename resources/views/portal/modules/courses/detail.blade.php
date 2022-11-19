@extends('portal.layouts.main')
@section('style')
    <style>
        .course-detail__content table .course-item .image {
            object-fit: contain;
        }
    </style>
@endsection
@section('content')
    @if (session('message') != null)
        <div id="show-toast-success" data-msg="{{ session('message') }}"></div>
    @endif
    <div class="course-detail">
        @php
            $query = app('request')->request->all();
            $result = array_merge(['courseId' => $course->course_id], $query);
        @endphp
        <div class="course-detail__title">
            <div class="f-w6">新規サービス申請一覧（教えて！ライブ配信）</div>
            <a href="{{ url()->previous() }}" class="btn-back">戻る</a>
        </div>
        <div class="course-detail__content">
            <div class="table-content">
                <table>
                    <tr>
                        <td class="course-label f-w6">サブカテゴリ</td>
                        <td class="course-item">{{ $course->category->name }}</td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">入場料</td>
                        <td class="course-item">¥{{ $course->price }}</td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">タイトル</td>
                        <td class="course-item">{{ $course->title }}</td>
                    </tr>
                    <tr>
                        <td class="course-label image-label f-w6">画像</td>
                        <td class="course-item image-item">
                            @foreach($course->imagePaths as $image)
                                <img src="{{ $image->image_url }}" alt="" class="image">
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">タイトル補足説明</td>
                        <td class="course-item">{!! $course->subtitle !!} </td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">サービス内容</td>
                        <td class="course-item">{!! $course->body !!}</td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">当日の流れ</td>
                        <td class="course-item">{!! $course->flow !!}</td>
                    </tr>
                    <tr>
                        <td class="course-label f-w6">ご利用に当たって</td>
                        <td class="course-item">{!! $course->cautions !!}</td>
                    </tr>
                    {{--                    <tr>--}}
                    {{--                        <td class="course-label f-w6">受講者限定サービス！</td>--}}
                    {{--                        <td class="course-item custom-td">--}}
                    {{--                            <div class="d-flex minutes-required">--}}
                    {{--                                <div>--}}
                    {{--                                    ご利用時間--}}
                    {{--                                </div>--}}
                    {{--                                <div>{{ $subCourse ? $subCourse->minutes_required : 0 }} 分</div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="d-flex price">--}}
                    {{--                                <div>料金</div>--}}
                    {{--                                <div>¥ {{ $subCourse ? ($subCourse->price) : 0 }}</div>--}}
                    {{--                            </div>--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                </table>
            </div>
            @if($course->approval_status === 0)
                <div class="action">
                    <button class="btn-deni" data-toggle="modal" data-target="#deni">否認</button>
                    <button class="btn-approval" data-toggle="modal" data-target="#approval">承認</button>
                </div>
            @endif
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="margin-left: auto">
                            このサービスを否認してもよろしいですか。 </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="margin-left: 0">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('portal.courses.approval', ['courseId' => $course->course_id]) }}"
                          method="post">
                        @csrf
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">キャンセル</button>
                            <button type="submit" name="approval_status" value="1" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="margin-left: auto">
                            このサービスを承認してもよろしいですか。</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="margin-left: 0">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('portal.courses.approval', ['courseId' => $course->course_id]) }}"
                          method="post">
                        @csrf
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">キャンセル</button>
                            <button type="submit" name="approval_status" value="2" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
