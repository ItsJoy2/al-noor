@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header mb-4">
        <h4 class="card-title mb-0">All Withdrawals</h4>
    </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('admin.withdraw.index') }}" class="d-flex justify-content-end mb-3 px-4" style="max-width: 300px; margin-left: auto;">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" placeholder="Search by user or transaction..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

    <div class="card-body table-responsive">
        <table class="table table-striped table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Wallet / Account</th>
                    <th>Method</th>
                    <th>Net Amount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($withdrawals as $index => $withdraw)
                @php
                    $details = $withdraw->details ?? [];
                    $mainValue = $details['account'] ?? $details['account_number'] ?? $details['wallet_address'] ?? '-';
                @endphp
                <tr>
                    <td>{{ $index + $withdrawals->firstItem() }}</td>
                    <td>{{ $withdraw->user->email ?? 'N/A' }}</td>
                    <td class="d-flex align-items-center">
                        <span id="details-{{ $withdraw->id }}">{{ $mainValue }}</span>
                        <button class="btn btn-sm btn-outline-secondary ms-2 copy-btn" data-copy-target="details-{{ $withdraw->id }}" title="Copy">
                            <i class="fas fa-copy"></i>
                        </button>
                    </td>
                    <td>{{ $withdraw->method}}</td>
                    <td>${{ number_format($withdraw->total_amount, 2) }}</td>
                    <td>${{ number_format($withdraw->charge, 2) }}</td>
                    <td>
                        @php
                            $badge = match($withdraw->status) {
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                'approved' => 'success',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($withdraw->status) }}</span>
                    </td>
                    <td>{{ $withdraw->created_at?->format('d M Y') }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $withdraw->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        @if($withdraw->status != 'approved')
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $withdraw->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        @endif
                    </td>
                </tr>

                {{-- Modal --}}
                <div class="modal fade" id="withdrawModal{{ $withdraw->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel{{ $withdraw->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="withdrawModalLabel{{ $withdraw->id }}">Withdrawal Details (#{{ $withdraw->id }})</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>User Info</h6>
                                        <p>{{ $withdraw->user->name ?? 'N/A' }}<br>{{ $withdraw->user->email ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Amounts</h6>
                                        <p>Amount: ${{ number_format($withdraw->amount,2) }}<br>
                                           Charge: ${{ number_format($withdraw->charge,2) }}<br>
                                           Net: ${{ number_format($withdraw->total_amount,2) }}</p>
                                    </div>
                                </div>

                                <h6>Withdrawal Details</h6>
                                <ul>
                                    @foreach($details as $key => $value)
                                        <li><strong>{{ ucfirst(str_replace('_',' ',$key)) }}:</strong> {{ $value }}</li>
                                    @endforeach
                                </ul>

                                <h6>Status</h6>
                                <span class="badge bg-{{ $withdraw->status=='pending'?'warning':($withdraw->status=='approved'?'success':'danger') }}">{{ ucfirst($withdraw->status) }}</span>

                                @if($withdraw->status != 'approved')
                                <hr>
                                <form action="{{ route('admin.withdraw.update', $withdraw->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="status{{ $withdraw->id }}" class="form-label">Update Status</label>
                                        <select name="status" id="status{{ $withdraw->id }}" class="form-select">
                                            <option value="pending" {{ $withdraw->status=='pending'?'selected':'' }}>Pending</option>
                                            <option value="approved" {{ $withdraw->status=='approved'?'selected':'' }}>Approved</option>
                                            <option value="rejected" {{ $withdraw->status=='rejected'?'selected':'' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="note{{ $withdraw->id }}" class="form-label">Admin Note</label>
                                        <textarea name="note" id="note{{ $withdraw->id }}" class="form-control" rows="3">{{ $withdraw->note }}</textarea>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="9" class="text-center">No withdrawals found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $withdrawals->appends(request()->query())->links('admin.layouts.partials.__pagination') }}
        </div>

    </div>
</div>

{{-- Copy to clipboard --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('data-copy-target');
                const text = document.getElementById(targetId).innerText;

                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Wallet/Account copied to clipboard.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to copy.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            });
        });
    });
</script>
@endsection
