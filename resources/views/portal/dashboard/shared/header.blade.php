
<div class="c-wrapper">
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
    <span class="c-header-toggler-icon"></span>
    </button>
    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
    <span class="c-header-toggler-icon"></span>
    </button>
    <ul class="c-header-nav ml-auto">
        <li class="c-header-nav-item d-md-down-none mx-2 dropleft box-dropdown">
            <img src="{{ asset(config('storage.icon_folder') . 'ico-setting.png') }}"  class="btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
            <div class="dropdown-menu div-dropdown" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item justify-content-center first-item-dropdown" href="">
                    <span>{{ __('labels.header.change_password') }}</span>
                </a>
                <a class="dropdown-item justify-content-center second-item-dropdown" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <span>{{ __('labels.header.logout') }}</span>
                </a>
                <form id="logout-form" action="" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>

<style type="text/css">
    .c-header .c-header-toggler-icon {
        background-image: url('/assets/icons/portal/ico_toggler.svg');
        height: 26px;
    }
    .c-header .c-header-toggler-icon:hover {
        background-image: url('/assets/icons/portal/ico_toggler.svg') !important;
    }
    .second-item-dropdown {
        cursor: pointer;
    }
</style>
