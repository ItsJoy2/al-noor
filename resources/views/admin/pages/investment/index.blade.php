@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Investors History</div>
    </div>
    <div class="card-body table-responsive">

        {{-- Filter Form --}}
        <form action="{{ route('admin.investment') }}" method="GET"
              class="mb-3 d-flex align-items-center gap-2 flex-wrap">

            <input type="text" name="email" class="form-control w-auto"
                   placeholder="Search by email" value="{{ request('email') }}">

            <select name="status" class="form-select w-auto">
                <option value="">All Status</option>
                @foreach(['active','inactive','paid'] as $statusOption)
                    <option value="{{ $statusOption }}" {{ request('status') == $statusOption ? 'selected' : '' }}>
                        {{ ucfirst($statusOption) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Search</button>

            @if(request()->has('email') || request()->has('status'))
                <a href="{{ route('admin.investment') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>

        {{-- Investors Table --}}
        <table class="table table-striped table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Package</th>
                    <th>Quantity</th>
                    <th>Purchase Type</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Paid Installments</th>
                    <th>Pending Invoices</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($investors as $index => $investor)
                    <tr>
                        <td>{{ $investors->firstItem() + $index }}</td>
                        <td>
                            {{ $investor->user->name ?? 'N/A' }}<br>
                            <small class="text-muted">{{ $investor->user->email ?? '' }}</small>
                        </td>
                        <td>{{ $investor->package->share_name ?? 'N/A' }}</td>
                        <td>{{ $investor->quantity }}</td>
                        <td>{{ ucfirst($investor->purchase_type) }}</td>
                        <td>৳{{ number_format($investor->total_amount, 2) }}</td>
                        <td>৳{{ number_format($investor->paid_amount, 2) }}</td>
                        <td>{{ $investor->paid_installments }}</td>
                        <td>{{ $investor->pending_invoices }}</td>
                        <td>
                            <span class="badge
                                @if($investor->status == 'active') bg-success
                                @elseif($investor->status == 'inactive') bg-secondary
                                @elseif($investor->status == 'paid') bg-info
                                @else bg-danger @endif">
                                {{ ucfirst($investor->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No investors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $investors->links('admin.layouts.partials.__pagination') }}
        </div>

    </div>
</div>
@endsection
