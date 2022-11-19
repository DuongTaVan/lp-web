<style>
    .teacher-sidebar-right__list__option__select a {
        text-decoration: none;
    }
</style>
<link href="{{ mix('css/clients/commons/option-search.css') }}" rel="stylesheet">
<div class="sidebar-right__navbar-order-list__year option_tab">
    <div class="teacher-sidebar-right__list__option option_tab_select mr-0 pr-0">
        <div class="dropdown show teacher-sidebar-right__list__option__select ">
            <a class="btn dropdown-toggle btn-option-drop" href="#" role="button"
               id="dropDownSearchOption" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                @if(Request::get('sort'))
                    <span>{{Request::get('sort') == \App\Enums\Constant::SORT_DATETIME_DESC ? __('labels.service-list.new_order') : __('labels.service-list.oldest_first') }}</span>
                    <img
                            src="{{asset('assets/img/icons/dropdown-arrow.svg')}}"
                            alt="" class="icon-dropdown">
                @else
                    <span>@lang('labels.service-list.new_order')</span>
                    <img
                            src="{{asset('assets/img/icons/dropdown-arrow.svg')}}"
                            alt="" class="icon-dropdown">
                @endif
            </a>

            <div class="dropdown-menu drop-search-option"
                 aria-labelledby="dropDownSearchOption" style="min-width: 0">
                <a class="dropdown-item drop-search-option-item {{ Request::get('sort') == \App\Enums\Constant::SORT_DATETIME_DESC || !Request::get('sort') ? "active-option" : "" }}"
                   href="{{request()->fullUrlWithQuery($query[0] ?? ['sort'=> \App\Enums\Constant::SORT_DATETIME_DESC])}}">@lang('labels.service-list.new_order')</a>
                <a class="dropdown-item drop-search-option-item {{ Request::get('sort') == \App\Enums\Constant::SORT_DATETIME_ASC ? "active-option" : "" }}"
                   href="{{request()->fullUrlWithQuery($query[1] ?? ['sort'=> \App\Enums\Constant::SORT_DATETIME_ASC])}}">@lang('labels.service-list.oldest_first')</a>
            </div>
        </div>
    </div>
</div>
