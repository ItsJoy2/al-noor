@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">User Details: {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                {{-- Basic Information --}}
                <div class="col-md-6">
                    <h5>Basic Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Email Verified At</th>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-danger">Not Verified</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Blocked</th>
                            <td>
                                <span class="badge {{ $user->is_block ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->is_block ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Active</th>
                            <td>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>KYC Status</th>
                            <td>
                                <span class="badge {{ $user->kyc_status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->kyc_status ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                            Update User Info
                        </button>
                    </div>

                        @include('admin.pages.users.__UserUpdateModel')

                </div>


                {{-- Wallet & Referral Info --}}
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Wallet Information</h5>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#walletUpdateModal">
                            <i class="bi bi-wallet2 me-1"></i> Update Wallet Balance
                        </button>
                    </div>

                    @include('admin.pages.users.__WalletUpdateModel')

                    <table class="table table-bordered">
                        <tr>
                            <th>Funding Wallet</th>
                            <td>${{ number_format($user->funding_wallet ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Spot Wallet</th>
                            <td>${{ number_format($user->spot_wallet ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Token Wallet</th>
                            <td>${{ number_format($user->token_wallet ?? 0, 2) }}</td>
                        </tr>
                    </table>

                    <h5>Referral Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Refer Code</th>
                            <td>{{ $user->refer_code }}</td>
                        </tr>
                        <tr>
                            <th>Referred By</th>
                            <td>{{ $user->referredBy->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Total Team Members</th>
                            <td>{{ $user->totalTeamMembersCount() }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Additional Info Sections --}}
            <div class="row">
                {{-- If you have birthday, address, etc --}}
                <div class="col-md-6 mb-3">
                    <h5>Other Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Birthday</th>
                            <td>{{ $user->birthday ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>NID / Passport</th>
                            <td>{{ $user->nid_or_passport ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $user->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                @if($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="img-thumbnail" style="max-width: 150px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- If you track investments via investors --}}
                <div class="col-md-6 mb-3">
                    <h5>Investments</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Total Invested Amount</th>
                            <td>${{ number_format($user->investors->sum('amount'), 2)  }}</td>
                        </tr>
                        <tr>
                            <th>Number of Investments</th>
                            <td>{{ $user->investors->count() }}</td>
                        </tr>
                    </table>
                </div>

                    {{-- Show list of each investment --}}
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Investment Details</h5>
                        </div>
                        <div class="card-body">
                            {{-- <table class="table table-bordered mb-3">
                                <tr>
                                    <th>Total Invested Amount</th>
                                    <td>${{ number_format($user->investors->sum('amount'), 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Investments</th>
                                    <td>{{ $user->investors->count() }}</td>
                                </tr>
                            </table> --}}

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Package</th>
                                            <th>Trade Pair</th>
                                            <th>Amount</th>
                                            <th>Expected Return</th>
                                            <th>Return Type</th>
                                            <th>Duration</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            {{-- <th>Next Return Date</th> --}}
                                            <th>Received Count</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($user->investors as $i => $inv)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $inv->package->plan_name ?? 'N/A' }}</td>
                                                <td>{{ $inv->package->category->name ?? 'N/A' }}</td> {{-- Show category --}}
                                                <td>${{ number_format($inv->amount, 2) }}</td>
                                                <td>${{ number_format($inv->expected_return, 2) }}</td>
                                                <td>{{ ucfirst($inv->return_type) }}</td>
                                                <td>{{ $inv->duration }} days</td>
                                                <td>{{ optional($inv->start_date)->format('d-m-Y') }}</td>
                                                <td>{{ optional($inv->end_date)->format('d-m-Y') }}</td>
                                                {{-- <td>{{ optional($inv->next_return_date)->format('d-m-Y') }}</td> --}}
                                                <td>{{ $inv->received_count }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($inv->status == 'active') bg-success
                                                        @elseif($inv->status == 'completed') bg-primary
                                                        @else bg-secondary @endif">
                                                        {{ ucfirst($inv->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center text-muted">No investments found for this user.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection
