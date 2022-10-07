<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('dashboard.home') }}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">@lang('sidebar.fetch')</h2>
                </a></li>

        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item{{ request()->routeIs('dashboard.home') ? ' active' : '' }}">
                <a href="{{ route('dashboard.home') }}">
                    <i class="fas fa-tachometer-alt-fastest"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('sidebar.dashboard')
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-globe"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('cities.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.cities.index', 'dashboard.cities.show', 'dashboard.cities.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.cities.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('cities.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.cities.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.cities.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('cities.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.cities.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.cities.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('cities.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-user-shield"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('admins.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.admins.index', 'dashboard.admins.show', 'dashboard.admins.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.admins.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('admins.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.admins.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.admins.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('admins.actions.create')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-users"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('users.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.users.index', 'dashboard.users.show', 'dashboard.users.edit') && ! request('cancellation_attempts') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.users.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('users.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.users.index') && request('cancellation_attempts') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.users.index', ['cancellation_attempts' => 1]) }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('الحسابات الموقوفة')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.users.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.users.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('users.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.users.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.users.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('users.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-users-medical"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('delegates.plural')
                    </span>
                    <span class="badge mr-1 ml-auto badge-danger badge-pill">{{ \App\Models\Users\User::where('type', \App\Models\Users\User::Delegate)->where('is_active', false)->count() ?: null }}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.delegates.index', 'dashboard.delegates.show', 'dashboard.delegates.edit') && ! request('cancellation_attempts') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.delegates.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('delegates.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.delegates.index') && request('cancellation_attempts') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.delegates.index', ['cancellation_attempts' => 1]) }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('الحسابات الموقوفة')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.delegates.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.delegates.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('delegates.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.collects.index') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.collects.index') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">{{ __('مستحقات المناديب') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.delegates.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.delegates.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('delegates.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-th"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('categories.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.categories.index', 'dashboard.categories.show', 'dashboard.categories.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.categories.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('categories.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.categories.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.categories.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('categories.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.categories.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.categories.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('categories.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-user-check"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('memberships.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.memberships.index', 'dashboard.memberships.show', 'dashboard.memberships.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.memberships.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('memberships.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.memberships.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.memberships.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('memberships.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.memberships.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.memberships.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('memberships.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-building"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('shops.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.shops.index', 'dashboard.shops.show', 'dashboard.shops.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.shops.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('shops.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.shops.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.shops.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('shops.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.branches.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.branches.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('branches.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.shops.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.shops.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('shops.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-credit-card"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('coupons.plural')
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.coupons.index', 'dashboard.coupons.show', 'dashboard.coupons.edit')  ? ' active' : '' }}">
                        <a href="{{ route('dashboard.coupons.index') }}">
                            <i class="fas fa-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('coupons.actions.list')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.coupons.create') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.coupons.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('coupons.actions.create')</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.coupons.trashed') ? ' active' : '' }}">
                        <a href="{{ route('dashboard.coupons.trashed') }}">
                            <i class="fas fa-trash"></i>
                            <span class="menu-item" data-i18n="Shop">@lang('coupons.trashed')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.orders.*')  ? ' active' : '' }}">
                <a href="{{ route('dashboard.orders.index') }}">
                    <i class="fas fa-paper-plane"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        @lang('orders.plural')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.wallets.system') ? ' active' : '' }}">
                <a href="{{ route('dashboard.wallets.system') }}">
                    <i class="fas fa-sack-dollar"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('wallets.system')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.wallets.delegates') ? ' active' : '' }}">
                <a href="{{ route('dashboard.wallets.delegates') }}">
                    <i class="fas fa-sack-dollar"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('wallets.delegates')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.wallets.users') ? ' active' : '' }}">
                <a href="{{ route('dashboard.wallets.users') }}">
                    <i class="fas fa-sack-dollar"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('wallets.users')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.withdrawal.requests') }}">
                <a href="{{ route('dashboard.withdrawal.requests', ['status' => implode('-', [
                            \App\Support\Payment\Models\Transaction::WITHDRAWAL_REQUEST_STATUS,
                            \App\Support\Payment\Models\Transaction::WITHDRAWAL_STATUS,
                        ])]) }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('wallets.withdrawal')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.reports.*') ? ' active' : '' }}">
                <a href="{{ route('dashboard.reports.index') }}">
                    <i class="fas fa-comment"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('reports.plural')
                    </span>
                </a>

            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.contact_us.*') ? ' active' : '' }}">
                <a href="{{ route('dashboard.contact_us.index') }}">
                    <i class="fas fa-phone"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('contact_us.plural')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.notifications.*') ? ' active' : '' }}">
                <a href="{{ route('dashboard.notifications.index') }}">
                    <i class="fas fa-bell"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('sidebar.notifications')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.adminNotifications.*') ? ' active' : '' }}">
                <a href="{{ route('dashboard.adminNotifications.index') }}">
                    <i class="fas fa-bell"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('sidebar.interior-notifications')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.settings.*') ? ' active' : '' }}">
                <a href="{{ route('dashboard.settings.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('settings.plural')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.backup.download') ? ' active' : '' }}">
                <a href="{{ route('dashboard.backup.download') }}">
                    <i class="fas fa-download"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('backup.download')
                    </span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('dashboard.audits.index') ? ' active' : '' }}">
                <a href="{{ route('dashboard.audits.index') }}">
                    <i class="fas fa-user-secret"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        @lang('audits.plural')
                    </span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="{{ route('dashboard.logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-title" data-i18n="Form Layout">
                        @lang('sidebar.logout')
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
