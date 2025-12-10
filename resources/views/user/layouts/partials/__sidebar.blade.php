<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="{{ route('user.dashboard') }}">
            @if($generalSettings && $generalSettings->logo)
                    <img src="{{ asset('public/storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
                @endif</a>
          <a class="sidebar-brand brand-logo-mini" href="{{ route('user.dashboard') }}">
            @if($generalSettings && $generalSettings->logo)
                <img src="{{ asset('public/storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
            @endif
        </a>
        </div>
        <ul class="nav">
          {{-- <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                  <span>Gold Member</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li> --}}
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
        <li class="nav-item menu-items {{ request()->routeIs('user.activation') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.activation') }}">
                <span class="menu-icon">
                <i class="mdi mdi-toggle-switch"></i>
                </span>
                <span class="menu-title">Activation</span>
            </a>
        </li>

          <li class="nav-item menu-items {{ request()->routeIs('user.purchase') ? 'active' : '' }}">
            <a class="nav-link " data-toggle="collapse" href="#invest-plan" aria-expanded="false" aria-controls="invest-plan">
              <span class="menu-icon">
                <i class="mdi mdi-package"></i>
              </span>
              <span class="menu-title">Investment Plans</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="invest-plan">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ request()->routeIs('user.purchase') ? 'active' : '' }}"> <a class="nav-link" href="{{ route('user.purchase') }}">All Plans</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.Investment.history') }}">My Investment</a></li>
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
          <li class="nav-item menu-items {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.deposit.history') }}">
                    <span class="menu-icon">
                    <i class="mdi mdi-bank"></i>
                    </span>
                    <span class="menu-title">Deposit History</span>
                </a>
            </li>

          <li class="nav-item menu-items  {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.transactions') }}">
              <span class="menu-icon">
                <i class="mdi mdi-square-inc-cash"></i>
              </span>
              <span class="menu-title">Transactions</span>
            </a>
          </li>
                   <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-square-inc-cash"></i>
              </span>
              <span class="menu-title">Buy YEEO</span>
            </a>
          </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="https://www.coingecko.com/en/coins/yee-token">
              <span class="menu-icon">
                <i class="mdi mdi-square-inc-cash"></i>
              </span>
              <span class="menu-title">CoinGecko</span>
            </a>
          </li>
         {{-- <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#tickets" aria-expanded="false" aria-controls="teamwork">
              <span class="menu-icon">
                <i class="mdi mdi-ticket"></i>
              </span>
              <span class="menu-title">Support</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tickets">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/users/createticket.html">Create Ticket</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/users/alltickets.html">All Tickets</a></li>
              </ul>
            </div>
          </li> --}}

          {{-- <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li> --}}

        </ul>
      </nav>
