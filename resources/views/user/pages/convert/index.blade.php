@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title"> Wallet Convert </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Wallets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Convert</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Convert Bonus Wallet</h4>
                <p>Convert balance from your <strong>Bonus Wallet</strong> to <strong>Funding Wallet</strong>.</p>

                @include('user.layouts.alert')

                {{-- Convert Form --}}
                <form class="forms-sample" method="POST" action="{{ route('user.wallet.convert') }}">
                    @csrf

                    {{-- Wallet Info --}}
                    <div class="form-group">
                        <label>Your Wallet Balances</label>
                        <select class="form-control text-primary" disabled>
                            <option>
                                Bonus Wallet: ৳{{ number_format(auth()->user()->bonus_wallet, 2) }}
                            </option>
                            <option>
                                Funding Wallet: ৳{{ number_format(auth()->user()->funding_wallet, 2) }}
                            </option>
                        </select>
                    </div>

                    {{-- Convert Amount --}}
                    <div class="form-group">
                        <label for="amount">Convert Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white">৳</span>
                            </div>
                            <input type="number"
                                   name="amount"
                                   id="amount"
                                   class="form-control text-white @error('amount') is-invalid @enderror"
                                   placeholder="Enter amount"
                                   value="{{ old('amount') }}"
                                   required
                                   step="0.01"
                                   min="1"
                                   max="{{ auth()->user()->bonus_wallet }}">
                        </div>
                        <small class="form-text text-muted mt-1">
                            Available Bonus Balance: ৳{{ number_format(auth()->user()->bonus_wallet, 2) }}
                        </small>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-success mr-2">
                        <i class="fas fa-exchange-alt me-1"></i> Convert Now
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
