<!-- Sidebar -->

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                @if($generalSettings && $generalSettings->logo)
                    <img src="{{ asset('public/storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="30">
                @endif
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <!-- Dashboard -->
                <li class="nav-item {{ request()->is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <!-- Users -->
                <li class="nav-item {{ request()->is('admin.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <p>All Users</p>
                    </a>
                </li>

                {{-- All Investors  --}}
                <li class="nav-item {{ Str::contains(request()->path(), 'investors') ? 'active' : '' }}">
                    <a href="{{ route('admin.investment') }}">
                        <i class="fas fa-chart-line"></i>
                        <p>All Investments</p>
                    </a>
                </li>

                <!-- Plans -->
                <li class="nav-item {{ Str::contains(request()->path(), 'admin.plans.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.plans.index') }}">
                        <i class="fas fa-database"></i>
                        <p>All Plans</p>
                    </a>
                </li>
                <!-- Pairs -->
                <li class="nav-item {{ Str::contains(request()->path(), 'admin.categories.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-puzzle-piece"></i>
                        <p>Trading Pairs</p>
                    </a>
                </li>
                <!-- Deposit -->
                    <li class="nav-item {{ Str::contains(request()->path(), 'deposit') ? 'active' : '' }}">
                    <a href="{{ route('admin.deposit.index') }}" class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-money-check-alt"></i>
                            <p class="m-0">Deposit</p>
                        </div>
                    </a>
                </li>

                <!-- Withdraw -->
                <li class="nav-item {{ Str::contains(request()->path(), 'withdraw') ? 'active' : '' }}">
                    <a href="{{ route('admin.withdraw.index') }}" class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-money-check-alt"></i>
                            <p class="m-0">Withdraw</p>
                        </div>

                        @if(isset($dashboardData['pendingWithdrawalsCount']) && $dashboardData['pendingWithdrawalsCount'] > 0)
                            <span class="badge bg-danger ms-2">
                {{ $dashboardData['pendingWithdrawalsCount'] }}
            </span>
                        @endif
                    </a>
                </li>

                <!-- Transactions -->
                <li class="nav-item {{ Str::contains(request()->path(), 'transactions') ? 'active' : '' }}">
                    <a href="{{ route('admin.transactions.index') }}">
                        <i class="fas fa-money-check"></i>
                        <p>Transactions</p>
                    </a>
                </li>

                <!-- Clubs -->
                {{-- <li class="nav-item {{ Str::contains(request()->path(), 'clubs') ? 'active' : '' }}"><a data-bs-toggle="collapse" href="#clubsMenu">
                        <i class="fas fa-star"></i>
                        <p>Clubs</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Str::contains(request()->path(), 'clubs') ? 'show' : '' }}" id="clubsMenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.clubs.index') }}">
                                    <span class="sub-item {{ Str::contains(request()->path(), 'clubs') ? 'active' : '' }}">All Clubs</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.clubs.create') }}">
                                    <span class="sub-item {{ Str::contains(request()->path(), 'clubs/create') ? 'active' : '' }}">Create Club</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}


                <!-- KYC -->
                {{-- @php
                    use App\Models\kyc;
                    $pendingCount = kyc::where('status', 'pending')->count();
                @endphp

                <li class="nav-item {{ Str::contains(request()->path(), 'kyc') ? 'active' : '' }}">
                    <a href="{{ route('admin.kyc.index') }}" class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-crown"></i>
                            <p class="m-0">KYC</p>
                        </div>

                        @if ($pendingCount > 0)
                            <span class="badge bg-danger ms-2">
                {{ $pendingCount }}
            </span>
                        @endif
                    </a>
                </li> --}}



                <!-- Cron -->
                {{-- <li class="nav-item {{ request()->is('cron') ? 'active' : '' }}">
                    <a href="/cron">
                        <i class="fas fa-school"></i>
                        <p>Cron Job</p>
                    </a>
                </li> --}}

                <!-- Tickets -->
                {{-- <li class="nav-item {{ request()->is('tickets') ? 'active' : '' }}">
                    <a href="/tickets">
                        <i class="fas fa-ticket-alt"></i>
                        <p>Tickets</p>
                    </a>
                </li> --}}

                <!-- Settings -->
                <li class="nav-item nav-item {{ Str::contains(request()->path(), 'settings') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#settings">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="settings">
                        <ul class="nav nav-collapse">
                            <li clsas="{{ Str::contains(request()->path(), 'settings') ? 'active' : '' }}"><a href="{{ route('admin.activation-settings.edit') }}"><span class="sub-item">Activation Setting</span></a></li>
                            <li><a href="{{ route('admin.withdraw.settings') }}"><span class="sub-item">Withdraws Settings</span></a></li>
                            <li><a href="{{ route('admin.transfer.settings') }}"><span class="sub-item">Transfer Settings</span></a></li>
                            <li><a href="{{ route('admin.general.settings') }}"><span class="sub-item">General Settings</span></a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
