@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/guide.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }

        .teacher-guide__content__step__one {
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="teacher-guide">
        <div class="teacher-guide__block">
            <div class="teacher-guide__block__title">
                <h1 class="teacher-guide__block__title__text mb-0 f-w6">サービスの出品（新規・再出品)</h1>
                <div class="teacher-guide__block__title__tag">
                    <div class="teacher-guide__block__title__tag__text"></div>
                </div>
            </div>

        </div>
        <div class="teacher-guide__content">
            <div class="teacher-guide__content__block">
                <div class="teacher-guide__content__block__title f-w6">配信画面の見方</div>
                <div class="teacher-guide__content__block__note f-w6">(ライブ配信・ビデオ通話)</div>
            </div>
            <div class="teacher-guide__content__step">
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title teacher-guide__content__step__one__text f-w6">
                        ライブ配信
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/r1_1.jpg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-nine-img-first">
                        <img src="{{url('/assets/img/clients/teacher/group_6493.png')}}" alt="">
                    </div>
                </div>
            </div>

            <div class="teacher-guide__content__step">
                <div class="teacher-guide__content__step__one">
                    <div class="teacher-guide__content__step__one__title teacher-guide__content__step__one__text f-w6">
                        ビデオ通話
                    </div>
                    <div class="teacher-guide__content__step__one__avatar">
                        <img src="{{url('/assets/img/clients/teacher/r2_2.jpg')}}" alt="">
                    </div>
                    <div class="teacher-guide__content__step__one__avatar-mobile guide-nine-img-second">
                        <img src="{{url('/assets/img/clients/teacher/group_6353.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
