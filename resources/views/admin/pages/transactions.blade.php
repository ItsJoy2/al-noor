@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Transactions History</div>
    </div>
    <div class="card-body table-responsive">
        @php
            $allowedTypes = ['transfer','convert','level_bonus','director_bonus','shareholder_bonus','club_bonus','rank_bonus'];
        @endphp

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="mb-3 d-flex align-items-center gap-2 flex-wrap">
            <input type="text" name="email" class="form-control w-auto" placeholder="Search by email" value="{{ request('email') }}">

            <select name="remark" class="form-select w-auto">
                <option value="">All Types</option>
                @foreach($allowedTypes as $type)
                    <option value="{{ $type }}" {{ request('remark') == $type ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Search</button>

            @if(request()->has('email') || request()->has('remark'))
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>

        <table class="table table-striped table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $transactions->firstItem() + $index }}</td>
                        <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                        <td>৳{{ number_format($transaction->amount, 3) }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $transaction->remark)) }}</td>
                        <td>{{ $transaction->details }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $transactions->links('admin.layouts.partials.__pagination') }}
        </div>

    </div>
</div>
@endsection
