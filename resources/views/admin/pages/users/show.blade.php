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

                {{-- BASIC INFORMATION --}}
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
                            <th>Email Verified</th>
                            <td>
                                <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                </span>
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
                        {{-- <tr>
                            <th>KYC Status</th>
                            <td>
                                <span class="badge {{ $user->kyc_status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->kyc_status ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                        </tr> --}}
                        <tr>
                            <th>Registered</th>
                            <td>
                                {{ $user->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                    </table>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#updateUserModal">
                        Update User Info
                    </button>

                    @include('admin.pages.users.__UserUpdateModel')
                </div>

                {{-- WALLET + REFERRAL --}}
                <div class="col-md-6">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Wallet Information</h5>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#walletUpdateModal">
                            Update Wallet
                        </button>
                    </div>

                    @include('admin.pages.users.__WalletUpdateModel')

                    <table class="table table-bordered">
                        <tr>
                            <th>Funding Wallet</th>
                            <td>৳{{ number_format($user->funding_wallet ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Bonus Wallet</th>
                            <td>৳{{ number_format($user->bonus_wallet ?? 0, 2) }}</td>
                        </tr>
                    </table>

                    <h5>Referral Info</h5>
                    <table class="table table-striped ">
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


            {{-- OTHER DETAILS --}}
            <div class="row">
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
                                    <img src="{{ asset('storage/' . $user->image) }}" class="img-thumbnail"
                                         style="max-width: 150px;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>


                {{-- INVESTMENT SUMMARY --}}
                <div class="col-md-6 mb-3">
                    <h5>Investments Summary</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Total Invested</th>
                            <td>
                                ৳{{ number_format($user->investors->sum('total_amount'), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Total Paid</th>
                            <td>
                                ৳{{ number_format($user->investors->sum('paid_amount'), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Total Investments</th>
                            <td>{{ $user->investors->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>


            {{-- INVESTMENTS LIST --}}
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Investment Details</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Package</th>
                                    <th>Purchase Type</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Paid Installments</th>
                                    <th>Pending Invoices</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse ($user->investors as $i => $inv)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $inv->package->plan_name ?? 'N/A' }}</td>

                                    <td>{{ ucfirst($inv->purchase_type) }}</td>

                                    <td>{{ $inv->quantity }}</td>

                                    <td>৳{{ number_format($inv->total_amount, 2) }}</td>

                                    <td>৳{{ number_format($inv->paid_amount, 2) }}</td>

                                    <td>{{ $inv->paid_installments }}</td>

                                    <td>{{ $inv->pending_invoices }}</td>

                                    <td>
                                        <span class="badge
                                            @if($inv->status == 'active') bg-success
                                            @elseif($inv->status == 'completed') bg-primary
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($inv->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        No investments found.
                                    </td>
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
@endsection
