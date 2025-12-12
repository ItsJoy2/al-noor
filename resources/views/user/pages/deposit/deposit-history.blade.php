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

      <h4 class="card-title mb-3">Your Deposit Records</h4>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>Date</th>
              <th>Transaction ID</th>
              <th>Method</th>
              <th>Account / Wallet</th>
              <th>Amount</th>
              <th>Note</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
          @forelse ($deposits as $deposit)
              @php
                  // Status mapping
                  $statusText = match($deposit->status) {
                      'pending' => 'Pending',
                      'approved' => 'Approved',
                      'rejected' => 'Rejected',
                      default => 'Unknown',
                  };
                  $badge = match($deposit->status) {
                      'pending' => 'warning',
                      'approved' => 'success',
                      'rejected' => 'danger',
                      default => 'secondary',
                  };
              @endphp

              <tr>
                  <td>{{ $deposit->created_at->format('d M Y') }}</td>
                  <td class="d-flex">
                      <span id="trx_{{ $deposit->id }}">{{ $deposit->transaction_id }}</span>
                      <button class="btn btn-sm ml-2 copy-btn"
                              data-copy-target="trx_{{ $deposit->id }}">
                          <i class="fa-solid fa-copy"></i>
                      </button>
                  </td>
                  <td>{{ $deposit->method->name ?? '-' }}</td>
                  <td>
                      @if(isset($deposit->method->details['account']))
                          <div class="d-flex align-items-center mb-1">
                              <span id="account_{{ $deposit->id }}"> {{ $deposit->method->details['account'] }}</span>
                              <button class="btn btn-sm ml-2 copy-btn" data-copy-target="account_{{ $deposit->id }}">
                                  <i class="fa-solid fa-copy"></i>
                              </button>
                          </div>
                      @endif

                      @if(isset($deposit->method->details['account_number']))
                          <div class="d-flex align-items-center mb-1">
                              <span id="account_number_{{ $deposit->id }}">{{ $deposit->method->details['account_number'] }}</span>
                              <button class="btn btn-sm ml-2 copy-btn" data-copy-target="account_number_{{ $deposit->id }}">
                                  <i class="fa-solid fa-copy"></i>
                              </button>
                          </div>
                      @endif

                      @if(isset($deposit->method->details['wallet_address']))
                          <div class="d-flex align-items-center">
                              <span id="wallet_address_{{ $deposit->id }}">{{ $deposit->method->details['wallet_address'] }}</span>
                              <button class="btn btn-sm ml-2 copy-btn" data-copy-target="wallet_address_{{ $deposit->id }}">
                                  <i class="fa-solid fa-copy"></i>
                              </button>
                          </div>
                      @endif
                  </td>
                  <td>৳{{ number_format($deposit->amount, 2) }}</td>
                  <td>{{ $deposit->note ?? '-' }}</td>
                  <td><span class="badge badge-{{ $badge }}">{{ $statusText }}</span></td>
              </tr>

          @empty
              <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                      <i class="fa-solid fa-folder-open fa-2x mb-2"></i><br>
                      No deposit history found.
                  </td>
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

@push('scripts')
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll('.copy-btn');

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-copy-target');
            const text = document.getElementById(id).innerText.replace(/^[A-Za-z _]+:\s*/, '');

            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    });
});
</script>
@endpush
