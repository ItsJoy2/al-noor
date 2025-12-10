@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title"> Transfer </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Wallets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transfer</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Transfer Funds</h4>
                <p>Transfer balance from your Funding Wallet to another user by email address.</p>

                {{-- Alert Message --}}
                @include('user.layouts.alert')

                {{-- Transfer Form --}}
                <form class="forms-sample" method="POST" action="{{ route('user.transfer.submit') }}">
                    @csrf

                    {{-- Wallet Info --}}
                    <div class="form-group">
                        <label for="selectWallet">Your Balance</label>
                        <select class="form-control text-primary" id="selectWallet" disabled>
                            <option>Funding Wallet: ${{ number_format(auth()->user()->funding_wallet, 2) }}</option>
                        </select>
                    </div>

                    {{-- Recipient Email --}}
                    <div class="form-group">
                        <label for="inputEmail">Recipient Email</label>
                        <input type="email"
                               name="email"
                               class="form-control text-white @error('email') is-invalid @enderror"
                               id="inputEmail"
                               placeholder="Enter recipient's email address"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    {{-- Transfer Amount --}}
                    <div class="form-group">
                        <label for="inputAmount">Transfer Amount</label>
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
                                   min="{{ $transferSettings->min_transfer }}"
                                   max="{{ $transferSettings->max_transfer }}">
                        </div>
                        <small class="form-text text-muted mt-1">
                            Min: ${{ $transferSettings->min_transfer }}, Max: ${{ $transferSettings->max_transfer }}
                        </small>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
