@extends('user.layouts.app')

@section('userContent')

@auth
    @if(!auth()->user()->is_active)
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                    <div class="card-body py-0 px-0 px-sm-3">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-3 col-xl-2">
                                <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                            </div>
                            <div class="col-5 col-sm-7 col-xl-8 p-0">
                                <h4 class="mb-1 mb-sm-0">Want to active your account?</h4>
                                <p class="mb-0 font-weight-normal d-none d-sm-block">Start your investment journey with us!</p>
                            </div>
                            <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                                <span>
                                    <a href="{{ route('user.activation') }}" class="btn btn-outline-light btn-rounded get-started-btn">Active Now</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth

            {{-- <div class="row">
              <div class="col-xl-6 grid-margin stretch-card">
                <div class="card ">
                    <script src="https://widgets.coingecko.com/gecko-coin-price-chart-widget.js"></script>
                        <gecko-coin-price-chart-widget locale="en" dark-mode="true" outlined="true" coin-id="harmony" initial-currency="usd" height="200"></gecko-coin-price-chart-widget>
                </div>
              </div>
              <div class="col-xl-6 grid-margin stretch-card">
                <div class="card ">
                    <script src="https://widgets.coingecko.com/gecko-coin-price-chart-widget.js"></script>
                    <gecko-coin-price-chart-widget locale="en" dark-mode="true" outlined="true" coin-id="polkadot" initial-currency="usd" height="200"></gecko-coin-price-chart-widget>
                </div>
              </div>
            </div> --}}

{{-- wallet card section  --}}

            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">${{ number_format($user->funding_wallet, 2) }}</h3>
                          {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
                        </div>
                      </div>
                      <div class="col-3">
                        {{-- <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> --}}
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-wallet icon-item"></span>
                        </div>

                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Funding Wallet</h6>
                  </div>
                </div>
              </div>
              {{-- <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">{{ number_format($user->bonus_wallet, 2) }}</h3>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-bitcoin icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Yeeo Token Wallet</h6>
                  </div>
                </div>
              </div> --}}
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">${{ number_format($dashboard['bonusBalance'], 2) }}</h3>
                          {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+11%</p> --}}
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-bank icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Bonus Wallet</h6>
                  </div>
                </div>
              </div>
              {{-- <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">$12.34</h3>
                          <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-trending-down icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Monthly ROI</h6>
                  </div>
                </div>
              </div> --}}
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">${{ number_format($dashboard['totalWithdraw'], 2) }}</h3>
                          {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-warning ">
                          <span class="mdi mdi-arrow-up-bold-box icon-item text-warning"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Withdraw</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">${{ number_format($dashboard['totalTransfer'], 2) }}</h3>
                          {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-swap-horizontal icon-item text-primary"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Transfer</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">No Rank</h3>
                          {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-trophy icon-item text-warning"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Current Rank</h6>
                  </div>
                </div>
              </div>
            </div>

            <!-- investment Section  -->
            {{-- @php
                use Illuminate\Support\Str;

                $totalChangeNumber = floatval(str_replace(['%', '+', '-'], '', $dashboard['totalInvestmentChange']));
                $runningChangeNumber = floatval(str_replace(['%', '+', '-'], '', $dashboard['runningInvestmentChange']));
                $maturedChangeNumber = floatval(str_replace(['%', '+', '-'], '', $dashboard['maturedInvestmentChange']));
            @endphp --}}

            <div class="row">
            <!-- Total Investment -->
            {{-- <div class="col-sm-4 grid-margin">
                <div class="card">
                <div class="card-body">
                    <h5>Total Investment</h5>
                    <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">${{ number_format($dashboard['totalInvestment'], 2) }}</h2>
                        <p class="ml-2 mb-0 font-weight-medium {{ Str::startsWith($dashboard['totalInvestmentChange'], '+') ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['totalInvestmentChange'] }}
                        </p>
                        </div>
                        <h6 class="text-muted font-weight-normal">
                        {{ $totalChangeNumber }}% Since last month
                        </h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div> --}}

            <!-- Running Investment -->
            {{-- <div class="col-sm-4 grid-margin">
                <div class="card">
                <div class="card-body">
                    <h5>Running Investment</h5>
                    <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">${{ number_format($dashboard['runningInvestment'], 2) }}</h2>
                        <p class="ml-2 mb-0 font-weight-medium {{ Str::startsWith($dashboard['runningInvestmentChange'], '+') ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['runningInvestmentChange'] }}
                        </p>
                        </div>
                        <h6 class="text-muted font-weight-normal">
                        {{ $runningChangeNumber }}% Since last month
                        </h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div> --}}

            <!-- Matured Investment -->
            {{-- <div class="col-sm-4 grid-margin">
                <div class="card">
                <div class="card-body">
                    <h5>Matured Investment</h5>
                    <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <h2 class="mb-0">${{ number_format($dashboard['maturedInvestment'], 2) }}</h2>
                        <p class="ml-2 mb-0 font-weight-medium {{ Str::startsWith($dashboard['maturedInvestmentChange'], '+') ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['maturedInvestmentChange'] }}
                        </p>
                        </div>
                        <h6 class="text-muted font-weight-normal">
                        {{ $maturedChangeNumber }}% Since last month
                        </h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div> --}}
        </div>



                        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Transaction History</h4>
                <canvas id="transaction-history" class="transaction-chart"></canvas>

                {{-- Last Transfer --}}
                <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                    <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Last Transfer</h6>
                    <p class="text-muted mb-0">
                        {{ $dashboard['lastTransfer']
                            ? $dashboard['lastTransfer']->created_at->format('d M Y, h:ia')
                            : 'No transfer yet' }}
                    </p>
                    </div>
                    <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">
                        ${{ $dashboard['lastTransfer'] ? number_format($dashboard['lastTransfer']->amount, 2) : '0.00' }}
                    </h6>
                    </div>
                </div>

                {{-- Last Withdraw --}}
                <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                    <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Last Withdraw</h6>
                    <p class="text-muted mb-0">
                        {{ $dashboard['lastWithdraw']
                            ? $dashboard['lastWithdraw']->created_at->format('d M Y, h:ia')
                            : 'No withdrawal yet' }}
                    </p>
                    </div>
                    <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">
                        ${{ $dashboard['lastWithdraw'] ? number_format($dashboard['lastWithdraw']->amount, 2) : '0.00' }}
                    </h6>
                    </div>
                </div>

                {{-- Last Deposit --}}
                <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                    <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Last Deposit</h6>
                    <p class="text-muted mb-0">
                        {{ $dashboard['lastDeposit']
                            ? $dashboard['lastDeposit']->created_at->format('d M Y, h:ia')
                            : 'No deposit yet' }}
                    </p>
                    </div>
                    <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">
                        ${{ $dashboard['lastDeposit'] ? number_format($dashboard['lastDeposit']->amount, 2) : '0.00' }}
                    </h6>
                    </div>
                </div>

                </div>
            </div>
            </div>

             <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">Transaction History</h4>
                        <p class="text-white mb-1">Recent Transactions</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="preview-list">

                            @php
                            $icons = [
                                'account_activation' => ['icon' => 'mdi mdi-file-document', 'color' => 'bg-primary'],
                                'withdrawal'         => ['icon' => 'mdi mdi-arrow-down-bold-circle', 'color' => 'bg-danger'],
                                'transfer'           => ['icon' => 'mdi mdi-swap-horizontal', 'color' => 'bg-info'],
                                'activation_bonus'   => ['icon' => 'mdi mdi-star-circle', 'color' => 'bg-warning'],
                                'trade_bonus'        => ['icon' => 'mdi mdi-trending-up', 'color' => 'bg-success'],
                                'pnl_bonus'          => ['icon' => 'mdi mdi-cash-multiple', 'color' => 'bg-success'],
                                'daily_pnl'          => ['icon' => 'mdi mdi-calendar-today', 'color' => 'bg-success'],
                                'package_purchased'  => ['icon' => 'mdi mdi-cart-outline', 'color' => 'bg-warning'],
                                'rank_bonus'         => ['icon' => 'mdi mdi-trophy-outline', 'color' => 'bg-warning'],
                            ];

                            $remarkLabels = [
                                'account_activation' => 'Account Activation',
                                'withdrawal'         => 'Withdrawal',
                                'transfer'           => 'Transfer',
                                'activation_bonus'   => 'Activation Bonus',
                                'trade_bonus'        => 'Trade Bonus',
                                'pnl_bonus'          => 'PNL Bonus',
                                'daily_pnl'          => 'Daily PNL',
                                'package_purchased'  => 'Plan Invested',
                                'rank_bonus'         => 'Rank Bonus',
                            ];
                            @endphp

                            @forelse($dashboard['transactions'] as $transaction)
                            @php
                                $icon = $icons[$transaction->remark]['icon'] ?? 'mdi mdi-file-document';
                                $color = $icons[$transaction->remark]['color'] ?? 'bg-secondary';
                                $label = $remarkLabels[$transaction->remark] ?? ucfirst(str_replace('_', ' ', $transaction->remark));
                            @endphp

                            <div class="preview-item border-bottom">
                                <div class="preview-thumbnail">
                                <div class="preview-icon {{ $color }}">
                                    <i class="{{ $icon }}"></i>
                                </div>
                                </div>
                                <div class="preview-item-content d-sm-flex flex-grow">
                                <div class="flex-grow">
                                    <h6 class="preview-subject">{{ $label }}</h6>
                                    <p class="text-muted mb-0">{{ $transaction->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                    <p class="text-muted">Amount: ${{ number_format($transaction->amount, 2) }}</p>
                                    @php
                                        $details = $transaction->details ?? '-';
                                        if ($transaction->remark === 'withdrawal' && strlen($details) > 20) {
                                            $start = substr($details, 0, 10);
                                            $end = substr($details, -10);
                                            $details = $start . '.....' . $end;
                                        }
                                    @endphp

                                    <p class="text-muted mb-0">{{ $details }}</p>

                                </div>
                                </div>
                            </div>
                            @empty
                            <p>No transactions found.</p>
                            @endforelse

                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

            </div>


            <div class="row">

                <!-- Active Referrals -->
                <div class="col-md-6 col-xl-6 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Active Referrals</h4>
                        <a href="{{ route('user.direct.referrals', ['status' => 'active']) }}" class="text-muted small">View all</a>
                        </div>

                        <div class="preview-list">
                        @forelse ($dashboard['activeReferrals'] as $referral)
                            <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                                <img src="{{ $referral->image ? asset('storage/' . $referral->image) : asset('public/assets/profile-icon.png') }}" alt="image" class="rounded-circle" />
                            </div>
                            <div class="preview-item-content d-flex flex-grow">
                                <div class="flex-grow">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="preview-subject">{{ $referral->name }}</h6>
                                        <p class="text-muted text-small">{{ $referral->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-muted">{{ $referral->email }}</p>
                                        <p class="text-muted text-small">Status: <span class="text-success">Active</span> </p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No active referrals found.</p>
                        @endforelse
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Inactive Referrals -->
                <div class="col-md-6 col-xl-6 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Inactive Referrals</h4>
                        <a href="{{ route('user.direct.referrals', ['status' => 'inactive']) }}" class="text-muted small">View all</a>
                        </div>

                        <div class="preview-list">
                        @forelse ($dashboard['inactiveReferrals'] as $referral)
                            <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">

                                <img src="{{ $referral->image ? asset('storage/' . $referral->image) : asset('public/assets/profile-icon.png') }}" alt="image" class="rounded-circle" />
                            </div>
                            <div class="preview-item-content d-flex flex-grow">
                                <div class="flex-grow">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="preview-subject">{{ $referral->name }}</h6>
                                        <p class="text-muted text-small">{{ $referral->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                    <p class="text-muted">{{ $referral->email }}</p>
                                    <p class="text-muted text-small">Status: <span class="text-danger">Inactive</span> </p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No inactive referrals found.</p>
                        @endforelse
                        </div>
                    </div>
                    </div>
                </div>

                </div>

          </div>

@endsection


@push('scripts')
    <script>
        window.transactionChartData = {
            labels: ["Deposit", "Withdraw", "Transfer"],
            datasets: [{
                data: [
                    {{ $dashboard['totalDeposit'] ?? 0 }},
                    {{ $dashboard['totalWithdraw'] ?? 0 }},
                    {{ $dashboard['totalTransfer'] ?? 0 }}
                ],
                backgroundColor: ["#ffab00", "#111111", "#00d25b" ]
            }]
        };

        window.transactionTotalAmount = {{ $dashboard['totalDeposit'] + $dashboard['totalWithdraw'] + $dashboard['totalTransfer'] }};
    </>

@endpush
