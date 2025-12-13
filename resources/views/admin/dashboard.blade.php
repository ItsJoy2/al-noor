@extends('admin.layouts.app')
@section('content')
    <div class="container mt-4">

        {{-- Pending Withdrawals Alert --}}
        {{-- @if($dashboardData['pendingWithdrawals'] > 0)
            <a href="/withdraw" class="text-decoration-none">
                <div class="alert alert-warning d-flex align-items-center shadow-sm rounded p-3 mb-4">
                    <i class="fas fa-exclamation-triangle text-dark fs-4 me-3"></i>
                    <div class="fw-semibold text-dark">
                        You currently have {{ $dashboardData['pendingWithdrawalsCount'] }} pending withdrawal {{ $dashboardData['pendingWithdrawalsCount'] > 1 ? 'requests' : 'request' }}.
                    </div>
                </div>
            </a>
        @endif --}}

        {{-- Users Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">User Overview</h5>
                <div class="row g-4">

                    @php
                        $users = [
                            ['label' => 'Total Users', 'value' => $dashboardData['totalUser'], 'icon' => 'fas fa-user', 'bg' => 'bg-success'],
                            ['label' => 'Active Users', 'value' => $dashboardData['activeUser'], 'icon' => 'fas fa-users-cog', 'bg' => 'bg-warning'],
                            ['label' => 'Blocked Users', 'value' => $dashboardData['blockUser'], 'icon' => 'fas fa-user-slash', 'bg' => 'bg-danger'],
                            ['label' => 'New Users', 'value' => $dashboardData['newUser'], 'icon' => 'fas fa-user-plus', 'bg' => 'bg-primary'],
                        ];
                    @endphp

                    @foreach ($users as $user)
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center border rounded p-3 h-100 bg-light hover-shadow">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box {{ $user['bg'] }} bg-opacity-75 text-white rounded d-flex justify-content-center align-items-center me-3" style="width: 48px; height: 48px;">
                                        <i class="{{ $user['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-5">{{ $user['value'] }}</div>
                                        <small class="text-muted">{{ $user['label'] }}</small>
                                    </div>
                                </div>
                              <a href="{{ route('admin.users.index') }}"> <i class="fas fa-arrow-right text-muted"></i></a>
                            </div>
                        </div>
                    @endforeach

                        {{-- Pool Wallet Cards --}}
                    <div class="row g-4 mt-3">
                        @php
                            $poolWallets = [
                                ['label' => 'Rank Pool', 'value' => $dashboardData['poolRank'], 'icon' => 'fas fa-crown', 'bg' => 'bg-primary'],
                                ['label' => 'Club Pool', 'value' => $dashboardData['poolClub'], 'icon' => 'fas fa-users', 'bg' => 'bg-info'],
                                ['label' => 'Shareholder Pool', 'value' => $dashboardData['poolShareholder'], 'icon' => 'fas fa-user-tie', 'bg' => 'bg-success'],
                                ['label' => 'Director Pool', 'value' => $dashboardData['poolDirector'], 'icon' => 'fas fa-user-shield', 'bg' => 'bg-warning'],
                            ];
                        @endphp

                        @foreach ($poolWallets as $wallet)
                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center border rounded p-3 h-100 bg-light hover-shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box {{ $wallet['bg'] }} bg-opacity-75 text-white rounded d-flex justify-content-center align-items-center me-3" style="width: 48px; height: 48px;">
                                            <i class="{{ $wallet['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold fs-5">৳{{ number_format($wallet['value'], 2) }}</div>
                                            <small class="text-muted">{{ $wallet['label'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Share count   --}}
                    <div class="row g-4">
                        @php
                            $shareStats = [
                                [
                                    'label' => 'Total Shares',
                                    'value' => $dashboardData['totalShares'] ?? 0,
                                    'icon'  => 'fas fa-layer-group',
                                    'bg'    => 'bg-primary'
                                ],
                                [
                                    'label' => 'Total Shares Sold',
                                    'value' => $dashboardData['totalSoldShares'] ?? 0,
                                    'icon'  => 'fas fa-shopping-cart',
                                    'bg'    => 'bg-success'
                                ],
                                [
                                    'label' => 'Remaining Shares',
                                    'value' => $dashboardData['remainingShares'] ?? 0,
                                    'icon'  => 'fas fa-box-open',
                                    'bg'    => 'bg-warning'
                                ],
                                [
                                    'label' => 'Installment Share',
                                    'value' => $dashboardData['installmentShares'] ?? 0,
                                    'icon'  => 'fas fa-money-bill-wave',
                                    'bg'    => 'bg-info'
                                ],
                            ];
                        @endphp

                        @foreach ($shareStats as $stat)
                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center border rounded p-3 h-100 bg-light hover-shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box {{ $stat['bg'] }} bg-opacity-75 text-white rounded d-flex justify-content-center align-items-center me-3" style="width: 48px; height: 48px;">
                                            <i class="{{ $stat['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold fs-5">{{ number_format($stat['value'], 0) }}</div>
                                            <small class="text-muted">{{ $stat['label'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>

        {{-- Deposits Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Deposits</h5>
                <div class="row g-4">
                    <x-dashboard.stat-card icon="fas fa-hand-holding-usd" value="৳{{ number_format($dashboardData['totalDeposit'], 2) }}" label="Total Deposits" bg="success" />
                    <x-dashboard.stat-card icon="fas fa-hand-holding-usd" value="৳{{ number_format($dashboardData['pendingDeposit'], 2) }}" label="Pending Deposits" bg="warning" />
                    <x-dashboard.stat-card icon="fas fa-hand-holding-usd" value="৳{{ number_format($dashboardData['todayDeposit'], 2) }}" label="Today Deposits" bg="info" />
                    <x-dashboard.stat-card icon="fas fa-hand-holding-usd" value="৳{{ number_format($dashboardData['last30DaysDeposit'], 2) }}" label="Last 30 days Deposits" bg="secondary" />
                </div>
            </div>
        </div>

        {{-- Withdrawals Section --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Withdrawals</h5>
                <div class="row g-4">
                    <x-dashboard.stat-card icon="fas fa-credit-card" value="৳{{$dashboardData['totalWithdrawals']}}" label="Total Withdrawn" bg="success" />
                    <x-dashboard.stat-card icon="fas fa-credit-card" value="৳{{$dashboardData['todayWithdrawals']}}" label="Today  Withdrawals" bg="warning" />
                    <x-dashboard.stat-card icon="fas fa-credit-card" value="৳{{$dashboardData['last30DaysWithdrawals']}}" label="Last 30 days Withdrawals" bg="info" />
                    <x-dashboard.stat-card icon="fas fa-percent" value="৳{{number_format($dashboardData['withdrawChargeAmount'], 2)}}" label="Total Withdrawal Charge" bg="secondary" />
                </div>
            </div>
        </div>

        {{-- Share purchased Section --}}
<div class="card shadow-sm mb-4 border-0">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">Share Purchase Details</h5>
        <div class="row g-4">
            <x-dashboard.stat-card
                icon="fas fa-coins"
                value="৳{{ number_format($dashboardData['totalFullPayment'], 2) }}"
                label="Total Full Payment"
                bg="primary"
            />
            <x-dashboard.stat-card
                icon="fas fa-play-circle"
                value="৳{{ number_format($dashboardData['totalInstallmentBuy'], 2) }}"
                label="Total Installment"
                bg="warning"
            />
            <x-dashboard.stat-card
                icon="fas fa-money-bill-wave"
                value="৳{{ number_format($dashboardData['totalInstallmentPaid'], 2) }}"
                label="Total Installment Paid"
                bg="success"
            />
            <x-dashboard.stat-card
                icon="fas fa-hourglass-end"
                value="৳{{ number_format($dashboardData['totalPendingInvoice'], 2) }}"
                label="Total Pending Invoice"
                bg="danger"
            />
        </div>
    </div>
</div>




    </div>
@endsection
