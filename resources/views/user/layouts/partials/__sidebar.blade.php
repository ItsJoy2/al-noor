<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="{{ route('user.dashboard') }}">
            @if($generalSettings && $generalSettings->logo)
                    <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
                @endif</a>
          <a class="sidebar-brand brand-logo-mini" href="{{ route('user.dashboard') }}">
            @if($generalSettings && $generalSettings->logo)
                <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
            @endif
        </a>
        </div>
        <ul class="nav">
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.dashboard') }}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('user.purchase') ? 'active' : '' }}">
            <a class="nav-link " data-toggle="collapse" href="#invest-plan" aria-expanded="false" aria-controls="invest-plan">
              <span class="menu-icon">
                <i class="mdi mdi-package"></i>
              </span>
              <span class="menu-title">Buy Share</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="invest-plan">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ request()->routeIs('user.purchase') ? 'active' : '' }}"> <a class="nav-link" href="{{ route('user.purchase') }}">All Shares</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.invoices') }}">Invoices</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.Investment.history') }}">My Share</a></li>
              </ul>
            </div>
          </li>

           <li class="nav-item menu-items {{ request()->routeIs('user.deposit.index') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#wallets" aria-expanded="false" aria-controls="wallets">
              <span class="menu-icon">
                <i class="mdi mdi-wallet"></i>
              </span>
              <span class="menu-title">Wallets</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="wallets">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item" > <a class="nav-link " href="{{ route('user.deposit.index') }}">Add Fund</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.withdraw.index') }}">Make Withdraw</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.transfer.form') }}">Fund Transfer</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.wallet.convert') }}">Fund Convert</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('user.direct.referrals') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.direct.referrals') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-plus"></i>
              </span>
              <span class="menu-title">Teamwork</span>
            </a>
          </li>
          {{-- <li class="nav-item menu-items {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.deposit.history') }}">
                    <span class="menu-icon">
                    <i class="mdi mdi-bank"></i>
                    </span>
                    <span class="menu-title">Deposit History</span>
                </a>
            </li> --}}
            <li class="nav-item menu-items {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#history" aria-expanded="false" aria-controls="wallets">
              <span class="menu-icon">
                <i class="mdi mdi-history"></i>
              </span>
              <span class="menu-title">Histories</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="history">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item" > <a class="nav-link " href="{{ route('user.deposit.history') }}">deposit</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.withdraw.history') }}">Withdraw</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.transactions') }}">Transactions</a></li>
              </ul>
            </div>
          </li>

            <li class="nav-item menu-items ">
                <a class="nav-link" href="{{ route('user.kyc') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-account-check"></i>
                    </span>
                    <span class="menu-title">KYC</span>
                </a>
            </li>

          {{-- <li class="nav-item menu-items  {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.transactions') }}">
              <span class="menu-icon">
                <i class="mdi mdi-square-inc-cash"></i>
              </span>
              <span class="menu-title">Transactions</span>
            </a>
          </li> --}}

        </ul>
      </nav>
