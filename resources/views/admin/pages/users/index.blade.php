@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">All Users</h4>
    </div>

    <div class="card-body table-responsive">

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="filter" class="form-control">
                        <option value="">-- Filter Users --</option>
                        <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Active Users</option>
                        <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                        <option value="blocked" {{ request('filter') == 'blocked' ? 'selected' : '' }}>Blocked Users</option>
                        <option value="unblocked" {{ request('filter') == 'unblocked' ? 'selected' : '' }}>Unblocked Users</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Search Form --}}
        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by email" value="{{ request('search') }}">
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                <button type="submit" class="btn btn-primary me-2">Search</button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index', ['filter' => request('filter')]) }}" class="btn btn-secondary">Reset</a>
                @endif
            </form>
        </div>

        {{-- User Table --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Registered</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Funding Wallet</th>
                        <th>Spot Wallet</th>
                        <th>Token Wallet</th>
                        <th>Refer Code</th>
                        <th>Referred By</th>
                        <th>Email Verified</th>
                        <th>Active</th>
                        <th>Blocked</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + $users->firstItem() }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>${{ number_format($user->funding_wallet ?? 0, 2) }}</td>
                            <td>${{ number_format($user->spot_wallet ?? 0, 2) }}</td>
                            <td>${{ number_format($user->token_wallet ?? 0, 2) }}</td>
                            <td>{{ $user->refer_code }}</td>
                            <td>{{ $user->referredBy->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->is_block ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->is_block ? 'Blocked' : 'Unblocked' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $users->withQueryString()->links('admin.layouts.partials.__pagination') }}
        </div>
    </div>

    {{-- SweetAlert Notifications --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
</div>
@endsection
