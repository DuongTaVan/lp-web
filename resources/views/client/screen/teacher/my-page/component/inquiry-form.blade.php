<div class="inquiry__form-info__user">
    <div class="inquiry__form-info__user__profile">
        <div class="inquiry__form-info__user__profile__full-name">
            <div class="inquiry__form-info__user__profile__full-name__text">氏名</div>
            <div class="inquiry__form-info__user__profile__full-name__input"><input type="text"
                                                                                    name="full_name"
                                                                                    placeholder="">
            </div>
            <div class="inquiry__error__full_name text-danger"></div>
        </div>
        <div class="inquiry__form-info__user__profile__email">
            <div class="inquiry__form-info__user__profile__email__text">メールアドレス</div>
            <div class="inquiry__form-info__user__profile__email__input"><input type="email" name="email"
                                                                                placeholder="">
            </div>
            <div class="inquiry__error__email text-danger"></div>
        </div>
    </div>
    <div class="inquiry__form-info__user__profile">
        <div class="inquiry__form-info__user__profile__full-name">
            <div class="inquiry__form-info__user__profile__full-name__text">種別</div>
            <div class="inquiry__form-info__user__profile__full-name__input ">
                <div class="inquiry__form-info__user__profile__full-name__input__option">
                    <span class="inquiry__form-info__user__profile__full-name__input__option__title"></span>
                    <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" alt="">
                </div>
            </div>
            <div class="inquiry__error__type text-danger"></div>
            <div class="inquiry__form-info__user__profile__full-name__dropdown">
                <div class="inquiry__form-info__user__profile__full-name__dropdown__option">
                    <div class="inquiry__form-info__user__profile__full-name__dropdown__option__one">
                        Lappiご利用方法
                    </div>
                    <div class="inquiry__form-info__user__profile__full-name__dropdown__option__one">
                        サービスの内容
                    </div>
                    <div class="inquiry__form-info__user__profile__full-name__dropdown__option__one">キャンセル
                    </div>
                    <div class="inquiry__form-info__user__profile__full-name__dropdown__option__one">退会手続き
                    </div>
                    <div class="inquiry__form-info__user__profile__full-name__dropdown__option__one inquiry__form-info__user__profile__full-name__dropdown__option__end">
                        その他
                    </div>
                </div>
            </div>
        </div>
        <div class="inquiry__form-info__user__profile__email">
            <div class="inquiry__form-info__user__profile__email__text">件名</div>
            <div class="inquiry__form-info__user__profile__email__input"><input type="text" name="subject">
            </div>
            <div class="inquiry__error__subject text-danger"></div>
        </div>
    </div>
    <div class="inquiry__form-info__user__content">
        <div class="inquiry__form-info__user__content__title">お問い合わせ内容</div>
        <div class="inquiry__form-info__user__content__text">
            <textarea name="content"></textarea>
        </div>
        <div class="inquiry__error__content_inquiry text-danger"></div>
    </div>
    <div class="inquiry__form-info__user__avatar">
        <div class="inquiry__form-info__user__avatar__title">画像アップロード</div>
        <div class="inquiry__form-info__user__avatar__content">
            <div class="inquiry__form-info__user__avatar__content__img">
                <input id="uploadFile" type="file" name="inquiry_file">
                <span class="preview-img-block"><img class="preview-img"
                                                     src="{{ url('/assets/img/clients/teacher/plus.svg') }}"
                                                     alt=""></span>
            </div>
            <div class="inquiry__form-info__user__avatar__content__preview">
                <div class="inquiry__form-info__user__avatar__content__preview__remove">
                    <img src="{{ url('/assets/img/clients/teacher/remove.svg') }}" alt="">
                </div>
                <img id="blah" src="#" alt="your image"/>
            </div>

            <div class="inquiry__form-info__user__avatar__content__note">
                <div class="inquiry__form-info__user__avatar__content__note__text">
                    5MB未満の画像(jpg, png)をアップロードすること<br class="none-pc">ができます。
                </div>
            </div>
        </div>
    </div>
    <div class="inquiry__error__file text-danger"></div>
    <div class="inquiry__form-info__user__button">
        <button class="btn btn-submit-inquiry" type="submit" id="send-inquiry"
                data-url="{{route('client.send-inquiry')}}">送信する
        </button>
    </div>
</div>