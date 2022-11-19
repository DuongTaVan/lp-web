@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/modules/teacher/inquiry.css') }}" rel="stylesheet">
    <style>
        .layout-content {
            padding-top: 0;
            padding-bottom: 0 !important;
        }

        .text-danger {
            font-size: 12px;
        }

        .inquiry__content__title {
            font-size: 18px;
            display: block;
            margin-bottom: 15px;
            margin-top: 15px;
            text-align: center;
        }

        .inquiry__content__title__one, .inquiry__content__title__two {
            font-size: 18px;
        }

        @media only screen and (max-width: 414px) {
            .inquiry__content__title {
                display: flex;
                flex-direction: column;
            }

            .inquiry__content__option:last-child {
                margin-bottom: 5px;
            }

            .inquiry__form-info {
                padding: 0 10px;
            }

            .inquiry__form-info__user {
                margin-top: 0;
            }
        }
    </style>
@endsection
@section('header')
    <meta name="description" content="お問い合わせの前に、よくあ るご質問をお役立てください。">
    <title>お問い合わせ</title>
@endsection
@section('content')
    <div class="inquiry">
        <div class="inquiry__header">
            <div class="inquiry__header__text">お問い合わせ</div>
        </div>
        <div class="inquiry__content">
            <div class="inquiry__content__title">
                <span class="inquiry__content__title__one">お問い合わせの前に、よくあ</span>
                <span class="inquiry__content__title__two">るご質問をお役立てください。</span>
                <div class="inquiry__content__title__one inquiry__content__title__one-mobile">お問い合わせの前に</div>
                <div class="inquiry__content__title__two inquiry__content__title__one-mobile">よくあるご質問をお役立てください。</div>
            </div>
            <div class="inquiry__content__option">
                <div class="inquiry__content__option__block">
                    <div class="inquiry__content__option__block__left">
                        <span class="inquiry__content__option__block__left__one">Q.</span>
                        <span class="inquiry__content__option__block__left__two"> ログインできない</span>
                    </div>
                    <div class="inquiry__content__option__block__right">
                        <img src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt="">
                    </div>
                </div>
                <div class="inquiry__content__option__question__toogle">
                    <div class="inquiry__content__option__question">
                        <div class="inquiry__content__option__question__left">A.</div>
                        <div class="inquiry__content__option__question__right">
                            <div class="inquiry__content__option__question__right__title">メールアドレス・パスワードの再確認</div>
                            <div class="inquiry__content__option__question__right__black">
                                会員登録画面ではなく、ログイン画面からログインに必要な情報を入力しているかご確認ください。
                            </div>
                            <div class="inquiry__content__option__question__right__black">
                                メールアドレスパスワードはすべて半角で入力しているかご確認ください。(記号含め@も半角です)
                            </div>
                            <div class="inquiry__content__option__question__right__black">
                                サブメールアドレスではログインできませんので、登録メールアドレスを入力しているか確認してください。
                            </div>
                            <div class="inquiry__content__option__question__right__black">
                                【Google/LINE/Facebook】で会員登録した場合、メールアドレスとパスワードの組み合わせによるログインではなく、
                                <br>
                                「各アカウントでログインする」のボタンからログインをお試しください。
                            </div>


                            <div class="inquiry__content__option__question__right__title">Cookie削除</div>
                            <div class="inquiry__content__option__question__right__black">
                                ブラウザに古い情報が残っていると正常にログインできない場合がありますので、Cookie削除をお試しください。
                                　<br>
                                ※ブラウザ設定でCookieを「無効」にしないようご注意ください。　
                            </div>


                            <div class="inquiry__content__option__question__right__title">上記いずれの方法でもログインできない場合</div>
                            <div class="inquiry__content__option__question__right__black custom">
                                「登録メールアドレス」は、運営からお教えすることができないため、ご自身で思い出していただく必要があります。<br>お問い合わせをいただいた場合でも、個人情報保護の観点よりアカウント情報を運営から開示することはできかねますので、予めご了承ください。
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inquiry__content__option">
                <div class="inquiry__content__option__block">
                    <div class="inquiry__content__option__block__left">
                        <span class="inquiry__content__option__block__left__one"> Q.</span>
                        <span class="inquiry__content__option__block__left__two">パスワードを忘れた</span>
                    </div>
                    <div class="inquiry__content__option__block__right">
                        <img src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt="">
                    </div>
                </div>
                <div class="inquiry__content__option__question__toogle">
                    <div class="inquiry__content__option__question">
                        <div class="inquiry__content__option__question__left">A.</div>
                        <div class="inquiry__content__option__question__right">
                            <div class="inquiry__content__option__question__right__title">パスワードを忘れた場合</div>
                            <div class="inquiry__content__option__question__right__black">
                                パスワードをお忘れの場合やパスワードでのログインをご希望の場合は、再発行の手続きをお願いします。

                            </div>
                            <div class="inquiry__content__option__question__right__black">
                                パスワード再設定は
                                @if(auth('client')->user())
                                    <a target="_blank"
                                       href="{{route('client.student.my-page.change-password')}}">こちら</a><img
                                            src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                @else
                                    <a target="_blank" href="{{route('client.password-reset.show-link')}}">こちら</a><img
                                            src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inquiry__content__option">
                <div class="inquiry__content__option__block">
                    <div class="inquiry__content__option__block__left">
                        <span class="inquiry__content__option__block__left__one"> Q.</span>
                        <span class="inquiry__content__option__block__left__two">キャンセル・日時変更をしたい</span>
                    </div>
                    <div class="inquiry__content__option__block__right">
                        <img src="{{asset('assets/img/icons/dropdown-arrow-seller.svg')}}" alt="">
                    </div>
                </div>
                <div class="inquiry__content__option__question__toogle">
                    <div class="inquiry__content__option__question">
                        <div class="inquiry__content__option__question__left">A.</div>
                        <div class="inquiry__content__option__question__right">
                            <div class="inquiry__content__option__question__right__title">キャンセルの場合</div>
                            <div class="inquiry__content__option__question__right__black">
                                開催日前日21:59まではキャンセルは可能です。<br>２２時を過ぎますとサービスの参加の有無に関係なく返金はできません。
                            </div>
                            <div class="inquiry__content__option__question__right__black">
                                キャンセル画面は <a target="_blank"
                                            href="{{route('client.student.my-page.order')}}">こちら️</a><img
                                        src="{{ url('assets/img/payment_method/icon-right-link.png') }}" alt="icon">
                            </div>
                            <div class="inquiry__content__option__question__right__title mt5">日時変更の場合</div>
                            <div class="inquiry__content__option__question__right__black">
                                開催日時を変更することはできません。<br>
                                その場合は一旦キャンセルをしてください。 <br>
                                ※キャンセルは開催日前日２２時以降はできません。
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inquiry__form-info">
            <div class="inquiry__form-info__question">
                <a class="inquiry__form-info__question__text" href="{{route('client.faq')}}">
                    よくあるご質問一覧へ
                </a>
            </div>
            <div class="inquiry__form-info__precaution">
                <div class="inquiry__form-info__precaution__title">
                    <div class="inquiry__form-info__precaution__title__text">
                        お問い合わせの注意事項
                    </div>

                </div>
                <div class="inquiry__form-info__precaution__black">
                    ※出品者の方へのご質問の内容は恐れ入りますが直接お問い合わせください。
                </div>
                <div class="inquiry__form-info__precaution__black">
                    ※メールが正しく届かない場合がございますので、【info@lappi-live.com】からのメールの受信許可設定を<br>お願いいたします。
                </div>
                <div class="inquiry__form-info__precaution__black">
                    ※電話およびその他、お問い合わせフォーム以外での対応は行っておりません。
                </div>
            </div>
            @include('client.screen.teacher.my-page.component.inquiry-form')
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('body').on('click', '.inquiry__form-info__user__profile__full-name__input__option', function () {
            $('.inquiry__form-info__user__profile__full-name__dropdown').slideToggle();
            $('img').toggleClass('arow-down')
        })

        $('body').on('click', '.inquiry__form-info__user__profile__full-name__dropdown__option__one', function () {
            let appendText = $(this).html();
            $('.inquiry__form-info__user__profile__full-name__input__option__title').html(appendText);
            $('.inquiry__form-info__user__profile__full-name__dropdown').slideToggle();
            $('img').toggleClass('arow-down')
        })

        $('body').on('click', '.preview-img-block', function () {
            $('#uploadFile').trigger('click')
        })
        uploadFile.onchange = evt => {
            const [file] = uploadFile.files
            if (file) {
                blah.src = URL.createObjectURL(file)
                $('.inquiry__form-info__user__avatar__content__preview').css('display', 'block');
                $('.inquiry__form-info__user__avatar__content__img').css('display', 'none')
            }
        }
        $('body').on('click', '.inquiry__form-info__user__avatar__content__preview__remove', function () {
            $("#uploadFile").val('');
            $('.inquiry__form-info__user__avatar__content__preview').css('display', 'none');
            $('.inquiry__form-info__user__avatar__content__img').css('display', 'flex')
        })

        $('body').on('click', '.inquiry__content__option__block', function () {
            $(this).find('img').toggleClass('img-rotate'); //Add class to img tag.
            $(this).closest('.inquiry__content__option').find('.inquiry__content__option__question__toogle').slideToggle(); //Find element in block .
        })


        // POST data inquiry .
        $(function () {
            $('body').on('click', '#send-inquiry', function (e) {
                e.preventDefault();
                $('.text-danger').html('');
                let full_name = $("input[name=full_name]").val();
                let email = $("input[name=email]").val();
                let type = $('.inquiry__form-info__user__profile__full-name__input__option__title').html();
                let subject = $("input[name=subject]").val();
                let content = $("textarea[name=content]").val();
                let files = new FormData();
                files.append('file', $('#uploadFile')[0].files[0]);
                files.append('full_name', full_name);
                files.append('email', email);
                files.append('type', type);
                files.append('subject', subject);
                files.append('content_inquiry', content);

                let route = $(this).data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: route,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: files,
                    beforeSend: function () {
                        $('#loading-overlay').show();
                    },
                }).done(function () {
                    $('#loading-overlay').hide();
                    toastr.success("メッセージを送信しました ");
                    $("input[name=full_name]").val('');
                    $("input[name=email]").val('');
                    $('.inquiry__form-info__user__profile__full-name__input__option__title').html('');
                    $("input[name=subject]").val('');
                    $("textarea[name=content]").val('');
                    $("#uploadFile").val('');
                    $('.inquiry__form-info__user__avatar__content__preview').css('display', 'none');
                    $('.inquiry__form-info__user__avatar__content__img').css('display', 'flex')
                }).fail(function (err) {
                    $('#loading-overlay').hide();
                    $.each(err.responseJSON.data.errors, function (key, error) {

                        if (error['key']) {
                            $('.inquiry__error__' + error['key']).html(error['error'])
                        }
                    })
                });

            })

        })
    </script>
@endsection
