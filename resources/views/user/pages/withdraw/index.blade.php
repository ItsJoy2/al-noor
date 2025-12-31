@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title">Withdraw</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Wallets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Withdraw</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Withdraw Form</h4>
                <p>Enter the details based on your withdrawal method.</p>

                @include('user.layouts.alert')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="forms-sample" method="POST" action="{{ route('user.withdraw.submit') }}" id="depositForm">
                    @csrf

                    <div class="form-group">
                        <label>Your Balance</label>
                        <input type="text" class="form-control text-primary" value="Funding Wallet: ৳{{ number_format(auth()->user()->funding_wallet, 2) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="method">Withdrawal Method</label>
                        <select name="method" id="method" class="form-control @error('method') is-invalid @enderror" required>
                            <option value="bkash">Bkash</option>
                            <option value="nagad">Nagad</option>
                            <option value="bank">Bank</option>
                            <option value="crypto">Crypto</option>
                        </select>
                    </div>

                    {{-- Bkash/Nagad Fields --}}
                    <div id="bkash-nagad-fields" class="method-fields" style="display: none;">
                        <label for="account">Account Number</label>
                        <input type="text" name="account" class="form-control @error('account') is-invalid @enderror"
                               placeholder="Enter Your Bkash or Nagad Personal Account Number">
                    </div>

                    {{-- Bank Fields --}}
                    <div id="bank-fields" class="method-fields" style="display: none;">
                        <label>Bank Name</label>
                        <input type="text" name="details[bank_name]" class="form-control @error('details.bank_name') is-invalid @enderror"
                               placeholder="Enter Bank Name">

                        <label>Account Number</label>
                        <input type="text" name="details[account_number]" class="form-control @error('details.account_number') is-invalid @enderror"
                               placeholder="Enter Account Number">
                    </div>

                    {{-- Crypto Fields --}}
                    <div id="crypto-fields" class="method-fields" style="display: none;">
                        <label>Wallet Address</label>
                        <input type="text" name="details[wallet_address]" class="form-control @error('details.wallet_address') is-invalid @enderror"
                               placeholder="Enter Crypto Wallet Address">

                        <label>Network</label>
                        <input type="text" name="details[network]" class="form-control @error('details.network') is-invalid @enderror"
                               placeholder="Enter Network">
                    </div>

                    <div class="form-group mt-3">
                        <label>Withdraw Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">৳</span>
                            </div>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   placeholder="Amount" step="0.01" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2" id="submitBtn">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        const method = document.getElementById('method').value;
        document.querySelectorAll('.method-fields').forEach(el => el.style.display = 'none');

        if(method === 'bkash' || method === 'nagad') {
            document.getElementById('bkash-nagad-fields').style.display = 'block';
        } else if(method === 'bank') {
            document.getElementById('bank-fields').style.display = 'block';
        } else if(method === 'crypto') {
            document.getElementById('crypto-fields').style.display = 'block';
        }
    }

    document.getElementById('method').addEventListener('change', toggleFields);
    window.addEventListener('load', toggleFields);

    document.getElementById('depositForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');

        btn.disabled = true;
        btn.innerHTML = 'Submitting...';
    });
</script>
@endsection
