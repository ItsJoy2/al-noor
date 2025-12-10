@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
    <h3 class="page-title">My Direct Referrals</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Direct Referrals</li>
        </ol>
    </nav>
</div>
    <form method="GET" action="{{ route('user.direct.referrals') }}" class="form-inline mb-3">
        <label for="status" class="mr-2">Filter by Status:</label>
        <select name="status" id="status" class="form-control mr-2 text-light">
            <option value="" {{ $statusFilter == '' ? 'selected' : '' }}>-- All --</option>
            <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $statusFilter == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-primary py-2">Filter</button>
    </form>

<div class="col-lg-12 grid-margin stretch-card">

    <div class="card">
        <div class="card-body">
            @if($referrals->isEmpty())
                <p>You have not referred anyone yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total running Invest</th>
                                <th>Status</th>
                                <th>Join Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referrals as $index => $referral)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $referral->name }}</td>
                                    <td>{{ $referral->email }}</td>
                                    <td>${{ number_format($referral->running_investment_total, 2) }}</td>
                                    <td>
                                        @if ($referral->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $referral->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
