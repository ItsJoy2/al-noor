@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
      <h2 class="page-title">Activation</h2>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('user.activation') }}">Activation</a></li>
        </ol>
      </nav>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center g-4">
            <div class="col-md-6 col-lg-4 d-flex">
              <div class="package-card w-100">

                <div class="package-title">Account Activation</div>

                @if (auth()->user()->is_active)
                  <div class="alert alert-success mt-3 text-center">
                    Your account is already <strong>activated</strong>.
                  </div>
                @else
                  <form method="POST" action="{{ route('user.account.activate') }}">
                    @csrf

                    {{-- Activation Amount --}}
                    <div class="mb-3">
                      <label for="activation-amount" class="form-label">Activation Amount (USD)</label>
                      <input type="text"
                             class="form-control text-dark"
                             id="activation-amount"
                             value="{{ number_format(optional($activationSetting)->activation_amount, 2) }}"
                             readonly>
                    </div>

                    {{-- Activation Bonus --}}
                    {{-- @if(optional($activationSetting)->activation_bonus > 0)
                      <div class="mb-3">
                        <label class="form-label">Bonus After Activation</label>
                        <input type="text"
                               class="form-control"
                               value="{{ number_format($activationSetting->activation_bonus, 2) }} Tokens"
                               readonly>
                      </div>
                    @endif --}}

                    {{-- Referral Bonus Info (Optional) --}}
                    {{-- @if(optional($activationSetting)->referral_bonus > 0)
                      <div class="mb-3">
                        <label class="form-label">Referral Bonus</label>
                        <input type="text"
                               class="form-control"
                               value="{{ number_format($activationSetting->referral_bonus, 2) }} Tokens to your referrer"
                               readonly>
                      </div>
                    @endif --}}

                    <button type="submit" class="btn btn-primary w-100">Activate Now</button>
                  </form>
                @endif

              </div> {{-- package-card --}}
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
