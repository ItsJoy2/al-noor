@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">All Deposits</h4>
    </div>


<div class="d-flex justify-content-between mb-3 align-items-center" style="max-width: 100%; margin: 20px; margin-bottom: 0;">

    <!-- Status Filter (Left Side) -->
    <form method="GET" action="{{ route('admin.deposit.index') }}" class="d-flex">
        <div class="input-group input-group-sm">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
    </form>

    <!-- Search Form (Right Side) -->
    <form method="GET" action="{{ route('admin.deposit.index') }}" class="d-flex align-items-center">
        <div class="input-group input-group-sm">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            @if(request('search'))
                <button class="btn btn-danger btn-sm" type="button" onclick="window.location='{{ route('admin.deposit.index') }}'">
                    <i class="fas fa-times"></i>
                </button>
            @endif
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

</div>


    <div class="card-body table-responsive">
        <table class="table table-striped table-hover mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>TrxID</th>
                    <th>User</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deposits as $index => $deposit)
                    <tr>
                        <td>{{ $index + $deposits->firstItem() }}</td>
                        <td>{{ $deposit->transaction_id }}</td>
                        <td>{{ $deposit->user->email ?? 'N/A' }}</td>
                        <td>{{ $deposit->method->name ?? 'N/A' }}</td>
                        <td>৳{{ number_format($deposit->amount, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($deposit->status == 'pending') badge-warning
                                @elseif($deposit->status == 'approved') badge-success
                                @else badge-danger @endif">
                                {{ ucfirst($deposit->status) }}
                            </span>
                        </td>
                        <td>{{ $deposit->note ?? '-' }}</td>
                        <td>{{ $deposit->created_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($deposit->status == 'pending')
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateModal{{ $deposit->id }}">
                                    Manage
                                </button>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal for Approve / Reject -->
                    <div class="modal fade" id="updateModal{{ $deposit->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{ $deposit->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('admin.deposit.update', $deposit->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel{{ $deposit->id }}">Deposit Details</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <strong>Transaction ID:</strong> {{ $deposit->transaction_id }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>User Email:</strong> {{ $deposit->user->email ?? 'N/A' }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Method:</strong> {{ $deposit->method->name ?? 'N/A' }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Amount:</strong> ৳{{ number_format($deposit->amount, 2) }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Status:</strong>
                                            <span class="badge
                                                @if($deposit->status == 'pending') badge-warning
                                                @elseif($deposit->status == 'approved') badge-success
                                                @else badge-danger @endif">
                                                {{ ucfirst($deposit->status) }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Created At:</strong> {{ $deposit->created_at->format('Y-m-d H:i') }}
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="status">Update Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="approved" {{ $deposit->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                                <option value="rejected" {{ $deposit->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="note">Note (Optional)</label>
                                            <textarea name="note" class="form-control" rows="3">{{ $deposit->note }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No deposits found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $deposits->appends(request()->query())->links('admin.layouts.partials.__pagination') }}
        </div>
    </div>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@endsection
