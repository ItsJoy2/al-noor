@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title"> Withdraw </h3>
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
                <p>Enter a BEP20 wallet address to withdraw funds from your Spot Wallet</p>

                @include('user.layouts.alert')

                {{-- Withdraw Form --}}
                <form class="forms-sample" method="POST" action="{{ route('user.withdraw.index') }}">
                    @csrf

                    <div class="form-group">
                        <label for="selectWallet">Your Balance</label>
                        <select class="form-control text-primary" id="selectWallet" disabled>
                            <option>
                                Spot Wallet: ${{ number_format(auth()->user()->spot_wallet, 2) }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputWallet">Wallet Address</label>
                        <input type="text"
                               name="wallet"
                               class="form-control text-white @error('wallet') is-invalid @enderror"
                               id="inputWallet"
                               placeholder="Enter Your BEP20 Wallet Address"
                               value="{{ old('wallet') }}"
                               required
                               minlength="10"
                               maxlength="70">
                    </div>

                    <div class="form-group">
                        <label for="inputAmount">Withdraw Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">$</span>
                            </div>
                            <input type="number"
                                   name="amount"
                                   id="inputAmount"
                                   class="form-control text-white @error('amount') is-invalid @enderror"
                                   placeholder="Amount"
                                   value="{{ old('amount') }}"
                                   required
                                   step="0.01"
                                   min="{{ $withdrawSettings->min_withdraw }}"
                                   max="{{ $withdrawSettings->max_withdraw }}">
                        </div>
                        <small class="form-text text-muted mt-1">
                            Min: ${{ $withdrawSettings->min_withdraw }}, Max: ${{ $withdrawSettings->max_withdraw }} | Charge: {{ $withdrawSettings->charge }}%
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
