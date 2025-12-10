@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
  <h3 class="page-title"> Add Fund </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Wallets</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add Fund</li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Deposit form</h4>
        <p>Choose BEP20 Network to make deposit</p>

        <form class="forms-sample" method="POST" action="{{ route('user.deposit.store') }}">
        @csrf
          <div class="form-group">
            <label for="selectCurrency">Currency</label>
            <select class="form-control" name="wallet" required>
                <option value="funding">Funding Wallet</option>
            </select>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white">$</span>
              </div>
              <input type="number" class="form-control" name="amount" aria-label="Amount (to the nearest dollar)" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <button type="reset" class="btn btn-dark">Cancel</button>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
