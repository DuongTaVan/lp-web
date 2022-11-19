<!-- Modal login -->
<!-- if you want to using this modal get id of modal -->
<!-- eg:
<button type="button" class="btn btn-primary" data-toggle="modal"
data-target="#modalLogin">Launch demo modal</button> -->
<div class="modal fade modal-custom pr-0" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-custom">
            <div class="modal-header d-flex justify-content-center align-items-center position-relative">
                <p class="text-center">会員登録</p>
                <img class="close position-absolute" data-dismiss="modal" aria-label="Close"
                     src="{{asset('assets/img/top-log/icon/close-grey.svg')}}" alt="">
            </div>
            <div class="modal-body text-center modal-body-custom social-login">
                <div class="row">
                    <div class="col-md-12 social-login__title"><h1>{{__('labels.users.modal_login.message')}}</h1></div>
                    <div class="col-md-12 social-login__title-mobile d-none">
                        <h1>サービスを利用するには
                            <br>
                            登録またはログインをしてください</h1></div>
                    <div class="col-md-12 mb-pc-14">
                        <a href="{{ route('client.auth.url-redirect', ['url'=> url()->current(),'service' => \App\Enums\Constant::SOCIAL_LOGIN_GOOGLE, 'user_type' => \App\Enums\DBConstant::USER_TYPE_STUDENT, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                           class="btn btn-google-custom btn-custom position-relative">

                            <img class="google position-absolute"
                                 src="{{asset('assets/img/teacher-page/icon/google-login-icon.svg')}}" alt="">
                            {{__('labels.users.modal_login.google_login')}}</a>
                    </div>
                    <div class="col-md-12 mb-pc-14">
                        <a href="{{ route('client.auth.url-redirect', ['url'=> url()->current(),'service' => \App\Enums\Constant::SOCIAL_LOGIN_LINE, 'user_type' => \App\Enums\DBConstant::USER_TYPE_STUDENT, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                           class="btn btn-custom position-relative" style="color:#fff;background: #00C300;">
                            <img class="line position-absolute"
                                 src="{{asset('assets/img/teacher-page/icon/line-login-icon.svg')}}"
                                 alt="">
                            <span>{{__('labels.users.modal_login.line_login')}}</span></a>
                    </div>
                    <div class="col-md-12 mb-pc-14">
                        <a href="{{ route('client.auth.url-redirect', ['url'=> url()->current(),'service' => \App\Enums\Constant::SOCIAL_LOGIN_FACEBOOK, 'user_type' => \App\Enums\DBConstant::USER_TYPE_STUDENT, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                           class="btn btn-custom position-relative" style="color:#fff; background: #1877F2">
                            <img class="facebook position-absolute"
                                 src="{{asset('assets/img/teacher-page/icon/fb-1.svg')}}" alt="">
                            <span>{{__('labels.users.modal_login.facebook_login')}}</span></a>
                    </div>
                    <div class="col-md-12 mb d-flex align-items-center line-hr" style="padding: 0 145px;">
                        <p class="underline-short"></p>
                        <span class="text-underline">または</span>
                        <p class="underline-short"></p>
                    </div>
                    <div class="col-md-12">
                        <a href="{{route('client.register-form')}}" class="btn btn-email-register btn-custom">
                            <span>{{__('labels.users.modal_login.email_login')}}</span></a>
                    </div>
                    <div class="col-md-12 underline-outline" style="padding: 0 145px;">
                        <p class="underline"></p>
                    </div>
                    <div class="col-md-12 mb-pc-14">
                        <div class="load-more-link row text-center ">
                            <div class="col-md-12">
                                <a href="{{route('client.login')}}"
                                   class="text-decoration-none">{{__('labels.users.modal_login.login_text')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>