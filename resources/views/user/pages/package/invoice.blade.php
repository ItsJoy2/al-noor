@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
  <h3 class="page-title"> My Invoices </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Accounts</a></li>
      <li class="breadcrumb-item active" aria-current="page">Invoices</li>
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
              <th> Date </th>
              <th> Invoice No </th>
              <th> Amount </th>
              <th> Type </th>
              <th> Status </th>
              <th> Action </th>
            </tr>
          </thead>

          <tbody>
            @forelse ($invoices as $invoice)

              @php
                  $investor = $invoice->investor;

                  // All pending invoices for this investor
                  $pendingInvoices = \App\Models\Invoice::where('investor_id', $invoice->investor_id)
                      ->where('status', 'pending')
                      ->get();

                  $totalPendingAmount = $pendingInvoices->sum('amount');

                  $settings = \App\Models\BonusSetting::first();
                  $reactivationCharge = 0;

                  if ($investor && $investor->status === 'inactive') {
                      $reactivationCharge = $settings->reactivation_charge;
                  }

                  $totalPayable = $totalPendingAmount + $reactivationCharge;
              @endphp

              <tr>
                <td>{{ $invoice->created_at->format('d M Y') }}</td>

                <td>{{ $invoice->invoice_no }}</td>

                <td>৳{{ number_format($invoice->amount, 2) }}</td>

                <td>{{ ucfirst($invoice->type) }}</td>

                <td>
                    <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </td>

                <td>
                    @if($invoice->status == 'pending')
                        <button
                            class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#payModal{{ $invoice->id }}">
                            Pay All ({{ $pendingInvoices->count() }})
                        </button>
                    @else
                        <span class="text-success">Paid</span>
                    @endif
                </td>
              </tr>


              <!-- ========================= -->
              <!-- PAYMENT MODAL START -->
              <!-- ========================= -->
              <div class="modal fade" id="payModal{{ $invoice->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">

                  <form action="{{ route('user.invoice.pay', $invoice->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title">Pay Pending Installments</h5>
                        <button type="button" class="close" data-dismiss="modal">
                          <span>&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">

                        <p><strong>Pending Installments:</strong> {{ $pendingInvoices->count() }}</p>

                        <p><strong>Total Pending Amount:</strong>
                            ৳{{ number_format($totalPendingAmount, 2) }}
                        </p>

                        @if($reactivationCharge > 0)
                          <p><strong>Reactivation Charge:</strong>
                              ৳{{ number_format($reactivationCharge, 2) }}
                              <span class="badge badge-danger">Inactive Account</span>
                          </p>
                        @endif

                        <hr>

                        <p><strong>Total Payable Amount:</strong>
                            <span class="text-primary">
                                ৳{{ number_format($totalPayable, 2) }}
                            </span>
                        </p>

                        <p><strong>Your Wallet Balance:</strong>
                            ৳{{ number_format(auth()->user()->funding_wallet, 2) }}
                        </p>

                        @if(auth()->user()->funding_wallet < $totalPayable)
                            <p class="text-danger">
                                Not enough balance to pay all installments + reactivation charge.
                            </p>
                        @endif

                        <hr>

                        <h6>Invoice Details:</h6>
                        <ul>
                            @foreach($pendingInvoices as $p)
                                <li>
                                    <strong>{{ $p->invoice_no }}</strong> —
                                    ৳{{ number_format($p->amount,2) }}
                                    ({{ $p->created_at->format('d M Y') }})
                                </li>
                            @endforeach
                        </ul>

                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          Close
                        </button>

                        @if(auth()->user()->funding_wallet >= $totalPayable)
                          <button type="submit" class="btn btn-success">
                            Pay All ({{ $pendingInvoices->count() }})
                          </button>
                        @else
                          <button class="btn btn-success" disabled>
                            Insufficient Balance
                          </button>
                        @endif
                      </div>

                    </div>
                  </form>

                </div>
              </div>
              <!-- ========================= -->
              <!-- PAYMENT MODAL END -->
              <!-- ========================= -->


            @empty
              <tr>
                <td colspan="6" class="text-center">No invoices found.</td>
              </tr>
            @endforelse
          </tbody>

        </table>
      </div>

    </div>
  </div>
</div>

@endsection
