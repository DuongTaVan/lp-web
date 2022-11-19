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
                <span class="text-content">@lang('labels.service-list.display_order')</span> <img
                        src="{{asset('assets/img/icons/dropdown-arrow.svg')}}"
                        alt="" class="icon-dropdown">
            </a>

            <div class="dropdown-menu drop-search-option"
                 aria-labelledby="dropDownSearchOption" style="min-width: 0">
                <a class="dropdown-item drop-search-option-item {{ request('created_at') ? "active-option" : "" }}"
                   href="{{ route('client.teacher.my-page.service-list', [
                        'tab' => $_GET['tab'] ?? null, 'created_at' => \App\Enums\Constant::ORDER_BY_DESC,
                        'dist_method' => $_GET['dist_method'] ?? null,
                        ]) }}">
                    @lang('labels.service-list.display_order')
                </a>
                <a class="dropdown-item drop-search-option-item {{ request('start_datetime') == 'desc' ? "active-option" : "" }}"
                   href="{{ request()->fullUrlWithQuery(['start_datetime' => \App\Enums\Constant::ORDER_BY_DESC]) }}">
                    @lang('labels.service-list.new_order')</a>
                <a class="dropdown-item drop-search-option-item {{ request('start_datetime') == 'asc' ? "active-option" : "" }}"
                   href="{{ request()->fullUrlWithQuery(['start_datetime' => \App\Enums\Constant::ORDER_BY_ASC]) }}">
                    @lang('labels.service-list.oldest_first')</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        if($(".active-option").length) {
            $(".text-content").html($(".active-option").text())
        }
    });
</script>
