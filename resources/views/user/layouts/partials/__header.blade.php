					<!-- Logo Header -->
					<div class="logo-header" data-background-color="dark">

						<a href="{{ route('user.dashboard') }}" class="logo">
							@if($generalSettings && $generalSettings->logo)
                                <img src="{{ asset('public/storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
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
