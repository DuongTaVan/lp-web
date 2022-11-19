<div class="header">
    <div class="header__bar">
        <img src="{{ url('assets/img/portal/icons/menu.svg') }}" alt="">
    </div>
    <div class="header__setting">
        <img src="{{ url('assets/img/portal/icons/setting.svg') }}" alt="">
    </div>
</div>

<div class="header__drop">
    <a href="{{route('portal.change-password')}}" class="option">パスワード変更</a>
    <hr/>
    <a href="{{ route('portal.logout') }}" class="option">ログアウト</a>
</div>
