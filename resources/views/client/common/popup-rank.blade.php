<section id="popup-rank">
    <div class="popup-rank">
        @switch($data->rank_id)
            @case(\App\Enums\DBConstant::BRONZE)
            <div class="popup-rank__header bg__bronze text-center fw-600">
                @lang('labels.rank.header.bronze')
            </div>
            @break
            @case(\App\Enums\DBConstant::SILVER)
            <div class="popup-rank__header bg__silver text-center fw-600">
                @lang('labels.rank.header.silver')
            </div>
            @break
            @case(\App\Enums\DBConstant::GOLD)
            <div class="popup-rank__header bg__gold text-center fw-600">
                @lang('labels.rank.header.gold')
            </div>
            @break
            @case(\App\Enums\DBConstant::PLATINUM)
            <div class="popup-rank__header bg__platinum text-center fw-600">
                @lang('labels.rank.header.platinum')
            </div>
            @break
            @default
        @endswitch
        <div class="popup-rank__content">
            @switch($data->rank_id)
                @case(\App\Enums\DBConstant::BRONZE)
                <p class="fw-300 description">@lang('labels.rank.name.bronze')</p>
                @break
                @case(\App\Enums\DBConstant::SILVER)
                <p class="fw-300 description description--modified">@lang('labels.rank.name.silver')</p>
                @break
                @case(\App\Enums\DBConstant::GOLD)
                <p class="fw-300 description">@lang('labels.rank.name.gold')</p>
                @break
                @case(\App\Enums\DBConstant::PLATINUM)
                <p class="fw-300 description">@lang('labels.rank.name.platinum')</p>
                @break
                @default
            @endswitch
            <div class="popup-rank__content__rank">
                <div class="bronze">
                    <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}">
                    @lang('labels.rank.bronze')
                </div>
                <img class="icon-next" src="{{ asset('assets/img/search/icon/Polygon3.svg') }}">
                <div class="silver">
                    <img src="{{ asset('assets/img/search/icon/Silver.svg') }}">
                    @lang('labels.rank.silver')
                </div>
                <img class="icon-next" src="{{ asset('assets/img/search/icon/Polygon3.svg') }}">
                <div class="gold">
                    <img src="{{ asset('assets/img/search/icon/Gold.svg') }}">
                    @lang('labels.rank.gold')
                </div>
                <img class="icon-next" src="{{ asset('assets/img/search/icon/Polygon3.svg') }}">
                <div class="platinum">
                    <img src="{{ asset('assets/img/search/icon/platium.svg') }}">
                    @lang('labels.rank.platinum')
                </div>
            </div>
        </div>
    </div>
</section>
