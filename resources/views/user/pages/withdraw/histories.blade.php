@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
  <h3 class="page-title">Withdrawal History</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Finance</a></li>
      <li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
    </ol>
  </nav>
</div>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Method</th>
              <th>Details</th>
              <th>Amount</th>
              <th>Charge</th>
              <th>Net Amount</th>
              <th>Note</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($withdrawals as $withdrawal)
              <tr>
                <td>{{ $withdrawal->created_at->format('d M Y') }}</td>
                <td>{{ ucfirst($withdrawal->method) }}</td>
                <td>
                    @if ($withdrawal->details)
                        @php
                            $details = is_array($withdrawal->details) ? $withdrawal->details : json_decode($withdrawal->details, true);
                        @endphp
                        @foreach ($details as $key => $value)
                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}<br>
                        @endforeach
                    @endif
                </td>
                <td>${{ number_format($withdrawal->amount, 2) }}</td>
                <td>${{ number_format($withdrawal->charge, 2) }}</td>
                <td>${{ number_format($withdrawal->total_amount, 2) }}</td>
                <td>{{ $withdrawal->note ?? '-' }}</td>
                <td>
                    @php
                        $status = $withdrawal->status;
                        $badgeClass = match($status) {
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'secondary',
                        };
                    @endphp
                    <span class="badge badge-{{ $badgeClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </td>
              </tr>
          @empty
              <tr>
                <td colspan="8" class="text-center">No withdrawals found.</td>
              </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
          {{ $withdrawals->links('user.layouts.partials.__pagination') }}
      </div>
    </div>
  </div>
</div>

@endsection
