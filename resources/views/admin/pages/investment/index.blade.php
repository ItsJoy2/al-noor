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

            {{-- Search by Email --}}
            <input type="text" name="email" class="form-control w-auto"
                   placeholder="Search by email" value="{{ request('email') }}">

            {{-- Filter by Status --}}
            <select name="status" class="form-select w-auto">
                <option value="">All Status</option>
                @foreach(['pending', 'active', 'completed', 'cancelled'] as $statusOption)
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
                    <th>Plan Name</th>
                    <th>Amount</th>
                    <th>Expected Return</th>
                    <th>Return Type</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($investors as $index => $investor)
                    <tr>
                        <td>{{ $investors->firstItem() + $index }}</td>
                        <td>{{ $investor->user->name ?? 'N/A' }}<br>
                            <small class="text-muted">{{ $investor->user->email ?? '' }}</small>
                        </td>
                        <td>{{ $investor->package->plan_name ?? 'N/A' }}</td>
                        <td>${{ number_format($investor->amount, 2) }}</td>
                        <td>${{ number_format($investor->expected_return, 2) }}</td>
                        <td>{{ ucfirst($investor->return_type) }}</td>
                        <td>
                            {{ $investor->duration }}
                            {{ $investor->return_type === 'daily' ? 'Days' : 'Months' }}
                        </td>
                        <td>{{ $investor->start_date?->format('Y-m-d') }}</td>
                        <td>{{ $investor->end_date?->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge
                                @if($investor->status == 'running') bg-warning
                                @elseif($investor->status == 'completed') bg-success
                                @elseif($investor->status == 'cancelled') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($investor->status) }}
                            </span>
                        </td>
                        <td>{{ $investor->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No investors found.</td>
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
