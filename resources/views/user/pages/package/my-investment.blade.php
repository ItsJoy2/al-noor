@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
    <h3 class="page-title">My Share Investments</h3>
</div>
@include('user.layouts.alert')
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Share</th>
                        <th>Qty</th>
                        <th>Total Amount</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investors as $key => $inv)
                        @php
                            $remaining = $inv->total_amount - $inv->paid_amount;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $inv->package->share_name }}</td>
                            <td>{{ $inv->quantity }}</td>
                            <td>৳{{ number_format($inv->total_amount, 2) }}</td>
                            <td>৳{{ number_format($inv->paid_amount, 2) }}</td>
                            <td>
                                <strong class="text-danger">
                                    ৳{{ number_format($remaining, 2) }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge badge-{{ $inv->status == 'paid' ? 'success' : ($inv->status == 'inactive' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($inv->status) }}
                                </span>
                            </td>
                            <td>
                                @if($remaining > 0)
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#payModal{{ $inv->id }}">
                                        Pay Now
                                    </button>
                                @else
                                    <span class="d-block text-center text-success">--</span>
                                @endif
                            </td>
                        </tr>

                        <!-- PAYMENT MODAL -->
                        <div class="modal fade" id="payModal{{ $inv->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('user.investor.pay', $inv->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Pay Installments / Advance</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Total Amount:</strong> ৳{{ number_format($inv->total_amount, 2) }}</p>
                                            <p><strong>Paid:</strong> ৳{{ number_format($inv->paid_amount, 2) }}</p>
                                            <p><strong>Remaining:</strong>
                                                <span class="text-danger">৳{{ number_format($remaining, 2) }}</span>
                                            </p>
                                            <p><strong>Your Wallet:</strong> ৳{{ number_format(auth()->user()->funding_wallet, 2) }}</p>

                                            <hr>

                                            <label><strong>Enter Amount to Pay</strong></label>
                                            <input type="number" step="0.01" name="amount" class="form-control"
                                                placeholder="Example: {{ $remaining }}" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Pay Now</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END MODAL -->

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
