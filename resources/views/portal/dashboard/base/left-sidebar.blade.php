
<!-- Admin user only -->
@if (Auth::user()->user_type === \App\Enums\DBConstant::MGMT_PORTAL_USER_TYPE_ADMIN_USER)
<li class="c-sidebar-nav-item" style="order: 1">
    <a
        href="{{ route('users.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'users' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_user.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.users') }}</span>
    </a>
</li>

<!-- business owners -->
<li class="c-sidebar-nav-item" style="order: 2">
    <a
        href="{{ route('clients.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'clients' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_building.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.clients') }}</span>
    </a>
</li>

<!-- products -->
<li class="c-sidebar-nav-item" style="order: 3">
    <a
        href="{{ route('products.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'products' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_product.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.products') }}</span>
    </a>
</li>
@endif

<!-- client user + admin -->
<!-- Inventory -->
<li class="c-sidebar-nav-item" style="order: 4">
    <a
        href="{{ route('inventories.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'inventories' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_stock.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.stocks') }}</span>
    </a>
</li>

@if (Auth::user()->user_type === \App\Enums\DBConstant::MGMT_PORTAL_USER_TYPE_ADMIN_USER)
<!-- reservation histories -->
<li class="c-sidebar-nav-item" style="order: 6">
    <a
        href="{{ route('reservations.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'reservations' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_calendar.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.reservation_histories') }}</span>
    </a>
</li>
@endif

<!-- client user + admin -->
<!-- sales -->
<li class="c-sidebar-nav-item" style="order: 7">
    <a
        href="{{ route('sales.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'sales' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico_earning.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.earnings') }}</span>
    </a>
</li>

@if (Auth::user()->user_type === \App\Enums\DBConstant::MGMT_PORTAL_USER_TYPE_ADMIN_USER)
<!-- brands -->
<li class="c-sidebar-nav-item" style="order: 8">
    <a
        href="{{ route('brands.index') }}"
        class="c-sidebar-nav-link {{ request()->segment(1) == 'brands' ? 'router-link-exact-active router-link-active' : '' }}"
    >
        <div class="custom-icon">
            <img src="{{ asset(config('storage.icon_folder') . 'ico-watch.svg' ) }}">
        </div>
        <span>{{ __('labels.sidebar.brands') }}</span>
    </a>
</li>
@endif
