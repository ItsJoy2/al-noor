@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
  <h3 class="page-title">Deposit History</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Finance</a></li>
      <li class="breadcrumb-item active" aria-current="page">Deposits</li>
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
              <th>Transaction ID</th>
              <th>Wallet</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($deposits as $deposit)
              <tr>
                <td>{{ ($deposit->created_at)->format('d M Y') }}</td>
                <td>{{ $deposit->transaction_id }}</td>
                <td>{{ ucfirst($deposit->wallet) }} Wallet</td>
                <td>${{ number_format($deposit->amount, 2) }}</td>
                <td>
                    @php
                        $status = $deposit->status ? 'completed' : 'pending';
                        $badgeClass = $deposit->status ? 'success' : 'warning';
                    @endphp

                    <span class="badge badge-{{ $badgeClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </td>
              </tr>
          @empty
              <tr>
                <td colspan="5" class="text-center">No deposits found.</td>
              </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
          {{ $deposits->links('user.layouts.partials.__pagination') }}
      </div>
    </div>
  </div>
</div>

@endsection
