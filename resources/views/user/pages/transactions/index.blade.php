@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
  <h3 class="page-title">Transactions</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Finance</a></li>
      <li class="breadcrumb-item active" aria-current="page">Transactions</li>
    </ol>
  </nav>
</div>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">

          <!-- Filter Form -->
  <form method="GET" action="{{ route('user.transactions') }}" class="form-inline mb-3">
    <div class="form-group mr-2">
      <label for="keyword" class="mr-2">Filter by Remark:</label>
      <select name="keyword" id="keyword" class="form-control">
        <option value="">-- All --</option>
        @foreach (['withdrawal','transfer','account_activation','activation_bonus','trade_bonus','pnl_bonus','daily_pnl','package_purchased','rank_bonus'] as $remark)
          <option value="{{ $remark }}" {{ $keyword == $remark ? 'selected' : '' }}>
            {{ ucfirst(str_replace('_', ' ', $remark)) }}
          </option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Filter</button>
  </form>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Remark</th>
              <th>Amount</th>
               <th>Charge</th>
              <th>Details</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($transactions as $transaction)
              <tr>
                <td>{{ ($transaction->created_at)->format('d M Y') }}</td>
                <td>{{ ucfirst($transaction->remark) }}</td>
                <td>${{ number_format($transaction->amount, 2) }}</td>
                <td>${{ number_format($transaction->charge, 2) }}</td>
                <td>{{ ucfirst($transaction->details) }}</td>
                <td>
                    @php
                        $status = strtolower($transaction->status);

                        $badgeClass = match($status) {
                            'pending' => 'warning',
                            'paid' => 'primary',
                            'completed' => 'success',
                            'rejected' => 'danger',
                            default => 'secondary',
                        };
                    @endphp

                    <span class="badge badge-{{ $badgeClass }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
          @empty
              <tr>
                <td colspan="6" class="text-center">No transactions found.</td>
              </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
          {{ $transactions->links('user.layouts.partials.__pagination') }}
      </div>
    </div>
  </div>
</div>

@endsection
