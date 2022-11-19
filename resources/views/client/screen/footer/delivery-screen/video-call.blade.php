@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/delivery-screen.css') }}" rel="stylesheet">
@endsection
@section('content')
    <header class="delivery-screen__header-video-call">
        <h1 class="title f-w6">配信時の画面使用方法 (オンライン悩み相談)</h1>
        <div class="hr"></div>
    </header>
    <div class="main">
        <div class="delivery-screen">
            <div class="delivery-screen__body">
                <div class="delivery-screen__body__title">
                    <div class="delivery-screen__body__title__header">配信画面（ビデオ通話)</div>
                </div>
                <div class="delivery-screen__body__content">
                    <div class="delivery-screen__body__content__title">ビデオ通話</div>
                    <div class="delivery-screen__body__content__image">
                        <img src="{{asset('assets/img/clients/teacher/r2_2.jpg')}}" alt="" class="image-pc">
                        <img src="{{asset('assets/img/clients/teacher/group_6353.png')}}" alt="" class="image-sp">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

